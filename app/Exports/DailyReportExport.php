<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\TransactionExport;
use App\Exports\SummaryExport;

class DailyReportExport implements WithMultipleSheets
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function sheets(): array
    {
        return [
            // First sheet: Transaction list
            new TransactionExport($this->filters),

            // Second sheet: Summary of transactions
            new SummaryExport($this->filters),
        ];
    }
}
