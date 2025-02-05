<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\TransactionExport;
use App\Exports\DailyExpensesExport;
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
            new TransactionExport($this->filters),

            new DailyExpensesExport($this->filters),

            new SummaryExport($this->filters),
        ];
    }
}
