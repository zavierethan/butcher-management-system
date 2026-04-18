<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;

class PosSessionController extends Controller
{
    public function checkOpenSession(Request $request)
    {
        $branchId = Auth::user()->branch_id;
        $hasOpenSession = DB::table('pos_sessions')
            ->where('branch_id', $branchId)
            ->where('status', 'OPEN')
            ->whereDate('opened_at', now()->toDateString())
            ->exists();

        return response()->json([
            'success' => true,
            'data' => [
                'has_open_session' => $hasOpenSession
            ]
        ]);
    }

    public function openSession(Request $request)
    {
        $request->validate([
            'opening_cash' => 'required|numeric|min:1'
        ]);

        // idealnya dari auth
        $userId   = auth()->user()->id;
        $branchId = auth()->user()->branch_id;

        return DB::transaction(function () use ($request, $userId, $branchId) {

            // 🔒 cek lagi (anti race condition)
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

            // 🟢 insert pos_session
            $sessionId = DB::table('pos_sessions')->insertGetId([
                'user_id'      => $userId,
                'branch_id'    => $branchId,
                'opened_at'    => now(),
                'opening_cash' => $request->opening_cash,
                'status'       => 'OPEN',
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);

            // 💰 insert cash_movements (ledger)
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

    public function getRemainingCashTodayByBranch(Request $request)
    {
        $branchId = auth()->user()->branch_id;

        $total = DB::table('cash_movements as cm')
            ->join('pos_sessions as ps', 'cm.pos_session_id', '=', 'ps.id')
            ->where('ps.branch_id', $branchId)
            ->where('cm.created_at', '>=', now()->startOfDay())
            ->where('cm.created_at', '<', now()->endOfDay())
            ->selectRaw("
                COALESCE(SUM(
                    CASE
                        WHEN cm.direction = 'IN' THEN cm.amount
                        ELSE -cm.amount
                    END
                ), 0) as total_cash
            ")
            ->value('total_cash');

        return response()->json([
            'success' => true,
            'data' => [
                'remaining_cash' => $total
            ]
        ]);
    }
}
