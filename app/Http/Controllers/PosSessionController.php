<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Carbon\Carbon;

class PosSessionController extends Controller
{
    public function checkOpenSession(Request $request)
    {
        $branchId = Auth::user()->branch_id;

        $todayStart = now()->startOfDay();
        $todayEnd = now()->endOfDay();

        // Cek session OPEN sebelum hari ini
        $previousOpenSession = DB::table('pos_sessions')
            ->where('branch_id', $branchId)
            ->where('status', 'OPEN')
            ->where('opened_at', '<', $todayStart)
            ->orderBy('opened_at', 'asc')
            ->first();

        if ($previousOpenSession) {
            return response()->json([
                'success' => true,
                'type' => 'PREVIOUS_OPEN_SESSION',
                'data' => [
                    'opened_at'  => Carbon::parse($previousOpenSession->opened_at)->format('Y-m-d'),
                    'session_id' => $previousOpenSession->id
                ]
            ]);
        }

        // Cek session hari ini
        $todaySession = DB::table('pos_sessions')
            ->where('branch_id', $branchId)
            ->whereBetween('opened_at', [$todayStart, $todayEnd])
            ->first();

        // Tidak ada session hari ini
        if (!$todaySession) {
            return response()->json([
                'success' => true,
                'type' => 'NO_SESSION_TODAY',
            ]);
        }

        // Ada session hari ini tapi sudah CLOSE
        if ($todaySession->status === 'CLOSE') {
            return response()->json([
                'success' => true,
                'type' => 'TODAY_SESSION_CLOSED',
            ]);
        }

        // Session hari ini masih OPEN
        return response()->json([
            'success' => true,
            'type' => 'TODAY_SESSION_OPEN',
        ]);
    }

    public function openSession(Request $request)
    {
        $request->validate([
            'opening_cash' => 'required|numeric|min:0'
        ]);

        // idealnya dari auth
        $userId   = Auth::user()->id;
        $branchId = Auth::user()->branch_id;

        return DB::transaction(function () use ($request, $userId, $branchId) {
            $exists = DB::table('pos_sessions')
                ->where('branch_id', $branchId)
                ->where('status', 'OPEN')
                ->lockForUpdate()
                ->exists();

            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Session already open'
                ], 409);
            }

            // insert pos_session
            $sessionId = DB::table('pos_sessions')->insertGetId([
                'user_id'      => $userId,
                'branch_id'    => $branchId,
                'opened_at'    => now(),
                'opening_cash' => $request->opening_cash,
                'status'       => 'OPEN',
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);

            // insert cash_movements (ledger)
            DB::table('cash_movements')->insert([
                'pos_session_id' => $sessionId,
                'user_id'        => $userId,
                'type'           => 'OPENING',
                'direction'      => 'IN',
                'amount'         => $request->opening_cash,
                'reference_type' => 'POS_SESSION',
                'reference_id'   => $sessionId,
                'description'    => 'Opening cash',
                'created_at'     => now(),
            ]);

            return response()->json([
                'success' => true,
                'data' => [
                    'session_id' => $sessionId
                ]
            ]);
        });
    }

    public function closeSession(Request $request)
    {
        $branchId = Auth::user()->branch_id;
        $params = $request->all();

        // Validasi input
        $request->validate([
            'closing_cash' => 'required|numeric',
            'actual_cash' => 'required|numeric',
            'notes' => 'nullable|string',
        ]);

        if(!empty($params['session_id'])) {
            $session = DB::table('pos_sessions')
                ->where('id', $params['session_id'])
                ->first();

            DB::table('pos_sessions')
                ->where('id', $params['session_id'])
                ->update([
                    'status' => 'CLOSE',
                    'closed_at' => now(),
                    'closing_cash' => $params['actual_cash'],
                    'expected_cash' => $params['closing_cash'],
                    'notes' => $params['notes'] ?? null,
                    'updated_at' => now()
            ]);

            return response()->json(['message' => 'Transaksi ' . $session->opened_at . ' berhasil ditutup']);
        } else {
            DB::table('pos_sessions')
                ->where('branch_id', $branchId)
                ->where('status', 'OPEN')
                ->update([
                    'status' => 'CLOSE',
                    'closed_at' => now(),
                    'closing_cash' => $params['actual_cash'],
                    'expected_cash' => $params['closing_cash'],
                    'notes' => $params['notes'] ?? null,
                    'updated_at' => now()
                ]);

            return response()->json(['message' => 'Transaksi berhasil ditutup']);
        }
    }

    public function getRemainingCashTodayByBranch(Request $request)
    {
        $branchId = Auth::user()->branch_id;

        $total = DB::table('cash_movements as cm')
            ->join('pos_sessions as ps', 'cm.pos_session_id', '=', 'ps.id')
            ->where('ps.branch_id', $branchId)
            ->where('cm.created_at', '>=', now()->startOfDay())
            ->where('cm.created_at', '<', now()->endOfDay())
            ->selectRaw("
                TO_CHAR(ROUND(COALESCE(SUM(
                    CASE
                        WHEN cm.direction = 'IN' THEN cm.amount
                        WHEN cm.direction = 'OUT' THEN -cm.amount
                        ELSE 0
                    END
                ), 0)::numeric), 'FM999,999,999') as total_cash
            ")
            ->value('total_cash');

        return response()->json([
            'success' => true,
            'data' => [
                'remaining_cash' => $total
            ]
        ]);
    }

    public function getSessionById($id)
    {

        $session = DB::table('pos_sessions')
            ->where('id', $id)
            ->first();

        $data = DB::table('pos_sessions as ps')
            ->leftJoin('cash_movements as cm', 'cm.pos_session_id', '=', 'ps.id')
            ->selectRaw("
                ps.id,
                TO_CHAR(ROUND(ps.opening_cash::numeric), 'FM999,999,999') as opening_cash,
                TO_CHAR(ROUND(COALESCE(SUM(
                    CASE
                        WHEN cm.direction = 'IN' THEN cm.amount
                        WHEN cm.direction = 'OUT' THEN -cm.amount
                        ELSE 0
                    END
                ), 0)::numeric), 'FM999,999,999') as total_cash_in_cashier
            ")
            ->where('ps.id', $session->id)
            ->groupBy('ps.id', 'ps.opening_cash')
            ->first();

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data session tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
