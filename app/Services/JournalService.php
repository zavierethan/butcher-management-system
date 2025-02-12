<?php

namespace App\Services;

use DB;
use Auth;

class JournalService {
    /**
     * Create a journal (header) and insert journal entries (detail)
     *
     * @param string $referenceType (e.g., 'sales', 'purchase', etc.)
     * @param int    $referenceId (e.g., ID transaksi)
     * @param string $description (Deskripsi jurnal)
     * @param array  $entries (Array dari akun debit/kredit)
     *
     * @return bool
     */
    public static function createJournal(string $referenceType, string $referenceId, string $description, array $entries): bool
    {
        DB::beginTransaction();

        try {
            // Validasi total debit dan kredit harus balance
            $totalDebit  = array_sum(array_column($entries, 'debit'));
            $totalCredit = array_sum(array_column($entries, 'credit'));

            if ($totalDebit !== $totalCredit) {
                throw new \Exception('Total Debit dan Kredit tidak balance!');
            }

            $journalId = DB::table('journals')->insertGetId([
                "code" => DB::select('SELECT generate_journal_number() AS journal_number')[0]->journal_number,
                "date" => date('Y-m-d'),
                "description" => $description,
                "reference" => $referenceId,
                "status" => "DRAFT",
                "created_by" => Auth::user()->id,
            ]);

            foreach ($entries as $detail) {
                DB::table('journal_details')->insertGetId([
                    "journal_id" => $journalId,
                    "account_id" =>  $detail["accountId"],
                    "debit" => $detail["debit"],
                    "credit" => $detail["credit"]
                ]);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Error creating journal: ' . $e->getMessage());
        }
    }

    /**
     * Generate unique journal ID
     *
     * @return string
     */
    private function generateJournalId(): string
    {
        return DB::select('SELECT generate_journal_number() AS journal_number')[0]->journal_number;
    }
}
