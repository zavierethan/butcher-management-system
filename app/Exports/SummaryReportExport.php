<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

use DB;
use Auth;

class SummaryReportExport implements FromCollection, WithHeadings, WithCustomStartCell, WithEvents, WithTitle, WithColumnFormatting
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        // Fetch all summary data
        $branchId = $this->filters['branch_id'];
        $startDate = $this->filters['start_date'];
        $endDate = $this->filters['end_date'];

        // Total transactions
        $totalsQuery = DB::table('transactions')
            ->selectRaw("
                SUM(CASE WHEN payment_method = '1' THEN total_amount ELSE 0 END) AS total_cash,
                SUM(CASE WHEN payment_method = '2' THEN total_amount ELSE 0 END) AS total_receivable,
                SUM(CASE WHEN payment_method = '3' THEN total_amount ELSE 0 END) AS total_transfer,
                SUM(total_amount) AS total_revenue,
                SUM(discount) AS total_discount
            ")
            ->where('branch_id', $branchId)
            ->whereDate('transaction_date', '>=', $startDate)
            ->whereDate('transaction_date', '<=', $endDate);
        $totals = $totalsQuery->first();

        // Daily expenses
        $totalExpenses = DB::table('daily_expenses')
            ->selectRaw("
                COALESCE(SUM(CASE WHEN payment_method = '1' THEN amount ELSE 0 END), 0) AS total_cash,
                COALESCE(SUM(CASE WHEN payment_method = '2' THEN amount ELSE 0 END), 0) AS total_transfer
            ")
            ->where('branch_id', $branchId)
            ->whereDate('date', '>=', $startDate)
            ->whereDate('date', '<=', $endDate);
        $totalExpenses = $totalExpenses->first();

        // Receivable payments
        $totalReceivable = DB::table('receivable_payments')
            ->selectRaw("
                COALESCE(SUM(CASE WHEN payment_method = '1' THEN amount ELSE 0 END), 0) AS total_cash,
                COALESCE(SUM(CASE WHEN payment_method = '2' THEN amount ELSE 0 END), 0) AS total_transfer
            ")
            ->where('branch_id', $branchId)
            ->whereDate('payment_date', '>=', $startDate)
            ->whereDate('payment_date', '<=', $endDate);
        $totalReceivable = $totalReceivable->first();

        // Prepare summary data
        $results = [];

        // Summary section heading
        $results[] = (object)[
            'jenis_pemasukan' => 'RINGKASAN TRANSAKSI',
            'nominal' => ''
        ];

        // Transaction summary by payment method
        $results[] = (object)[
            'jenis_pemasukan' => 'TUNAI',
            'nominal' => $totals->total_cash ?? 0
        ];

        $results[] = (object)[
            'jenis_pemasukan' => 'TRANSFER',
            'nominal' => $totals->total_transfer ?? 0
        ];

        $results[] = (object)[
            'jenis_pemasukan' => 'PIUTANG',
            'nominal' => $totals->total_receivable ?? 0
        ];

        // Expenses section
        $results[] = (object)[
            'jenis_pemasukan' => '',
            'nominal' => ''
        ];

        $results[] = (object)[
            'jenis_pemasukan' => 'PENGELUARAN TUNAI',
            'nominal' => $totalExpenses->total_cash ?? 0
        ];

        $results[] = (object)[
            'jenis_pemasukan' => 'PENGELUARAN TRANSFER',
            'nominal' => $totalExpenses->total_transfer ?? 0
        ];

        // Receivable payment section
        $results[] = (object)[
            'jenis_pemasukan' => '',
            'nominal' => ''
        ];

        $results[] = (object)[
            'jenis_pemasukan' => 'PEMBAYARAN PIUTANG TUNAI',
            'nominal' => $totalReceivable->total_cash ?? 0
        ];

        $results[] = (object)[
            'jenis_pemasukan' => 'PEMBAYARAN PIUTANG TRANSFER',
            'nominal' => $totalReceivable->total_transfer ?? 0
        ];

        return collect($results);
    }

    public function headings(): array
    {
        return [
            'JENIS PEMASUKAN',
            'NOMINAL'
        ];
    }

    public function startCell(): string
    {
        return 'A5';
    }

    public function title(): string
    {
        return 'Summary';
    }

    public function columnFormats(): array
    {
        return [
            'B' => '#,##0',  // Format angka ribuan tanpa desimal
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Header information
                $sheet->setCellValue('A1', 'TANGGAL');
                $sheet->setCellValue('B1', date("d M Y", strtotime($this->filters['start_date'])) . ' - ' . date("d M Y", strtotime($this->filters['end_date'])));

                $sheet->setCellValue('A2', 'CABANG');
                $sheet->setCellValue('B2', $this->filters['branch_name'] . ' (' . $this->filters['branch_code'] . ')');

                // Apply bold styling to labels
                $sheet->getStyle('A1:A2')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 11],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
                ]);

                // Header row styling
                $sheet->getStyle('A5:B5')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '366092']
                    ],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000']
                        ]
                    ]
                ]);

                // Get last row with data
                $rowCount = $sheet->getHighestRow();

                // Data styling
                for ($row = 6; $row <= $rowCount; $row++) {
                    $jenisPemasukan = $sheet->getCell('A' . $row)->getValue();

                    // Styling for section headers and empty rows
                    if (empty($jenisPemasukan) || in_array($jenisPemasukan, ['RINGKASAN TRANSAKSI'])) {
                        $sheet->getStyle('A' . $row . ':B' . $row)->applyFromArray([
                            'font' => ['bold' => true, 'size' => 10, 'color' => ['rgb' => '366092']],
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'startColor' => ['rgb' => 'E8F0F8']
                            ]
                        ]);
                    } else {
                        // Regular data rows
                        $sheet->getStyle('A' . $row)->applyFromArray([
                            'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT]
                        ]);

                        $sheet->getStyle('B' . $row)->applyFromArray([
                            'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
                            'numberFormat' => ['formatCode' => '#,##0']
                        ]);
                    }

                    // Borders for all cells
                    $sheet->getStyle('A' . $row . ':B' . $row)->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['rgb' => 'CCCCCC']
                            ]
                        ]
                    ]);
                }

                // Column widths
                $sheet->getColumnDimension('A')->setWidth(35);
                $sheet->getColumnDimension('B')->setWidth(20);

                // Freeze panes
                $sheet->freezePane('A6');
            }
        ];
    }
}
