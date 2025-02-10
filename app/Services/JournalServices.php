<?php

namespace App\Services;

use DB;
use Auth;

class JournalService {
    public static function recordJournal($payment) {
        DB::beginTransaction();
        try {
            // Generate Nomor Jurnal
            $journalNumber = DB::select('SELECT generate_journal_number() AS journal_number')[0]->journal_number;

            $journalId = DB::table('journals')->insertGetId([
                "code" => $journalNumber,
                "date" => $payment->date,
                "description" => $payloads["header"]["description"],
                "reference" => $payloads["header"]["reference"],
                "remarks" => $payloads["header"]["remarks"],
                "status" => "draft"
            ]);

            DB::table('journal_details')->insertGetId([
                "journal_id" => $journalId,
                "account_code" =>  $detail["accountId"],
                "account_name" =>  $detail["accountId"],
                "debit" => $detail["debit"],
                "credit" => $detail["credit"]
            ]);

            DB::table('journal_details')->insertGetId([
                "journal_id" => $journalId,
                "account_code" =>  $detail["accountId"],
                "account_name" =>  $detail["accountId"],
                "debit" => $detail["debit"],
                "credit" => $detail["credit"]
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw new Exception("Failed to create journal entry: " . $e->getMessage());
        }
    }
}
