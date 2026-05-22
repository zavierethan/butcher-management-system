<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\SummaryReportExport;
use App\Exports\DailyExpensesExport;
use App\Exports\ReceivablePaymentsExport;
use App\Exports\ServicePerformanceExport;
use App\Exports\DailyStockExport;
use App\Exports\TransactionExport;

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
            new SummaryReportExport($this->filters),
            new DailyExpensesExport($this->filters),
            new ReceivablePaymentsExport($this->filters),
            new ServicePerformanceExport($this->filters),
            new DailyStockExport($this->filters),
            new TransactionExport($this->filters),
        ];
    }
}
