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

class ReceivablePaymentsExport implements FromCollection, WithHeadings, WithCustomStartCell, WithEvents, WithTitle, WithColumnFormatting
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = DB::table('receivable_payments')
            ->select(
                'customers.name as customer_name',
                'invoices.invoice_no as invoice_number',
                DB::raw("TO_CHAR(invoices.invoice_date, 'DD/MM/YYYY') as invoice_date"),
                'receivable_payments.amount'
            )
            ->leftJoin('invoices', 'invoices.id', '=', 'receivable_payments.invoice_id')
            ->leftJoin('customers', 'customers.id', '=', 'invoices.customer_id')
            ->where('receivable_payments.branch_id', $this->filters['branch_id'])
            ->whereDate('receivable_payments.payment_date', '>=', $this->filters['start_date'])
            ->whereDate('receivable_payments.payment_date', '<=', $this->filters['end_date']);

        return $query->orderBy('receivable_payments.id', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'CUSTOMER',
            'NOMOR INVOICE',
            'TANGGAL INVOICE',
            'NOMINAL',
        ];
    }

    public function startCell(): string
    {
        return 'A5';
    }

    public function title(): string
    {
        return 'Pembayaran Piutang';
    }

    public function columnFormats(): array
    {
        return [
            'D' => '#,##0',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Add header information
                $sheet->setCellValue('A1', 'TANGGAL');
                $sheet->setCellValue('B1', date("d M Y", strtotime($this->filters['start_date'])).' - '.date("d M Y", strtotime($this->filters['end_date'])));
                $sheet->setCellValue('A2', 'CABANG');
                $sheet->setCellValue('B2', $this->filters['branch_name'].' ('.$this->filters['branch_code'].')');

                // Apply bold styling to labels
                $sheet->getStyle('A1:A2')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 11],
                ]);

                // Header row styling
                $sheet->getStyle('A5:D5')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '366092']
                    ],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);

                // Get last row with data
                $rowCount = $sheet->getHighestRow();

                // Data row styling
                for ($row = 6; $row <= $rowCount; $row++) {
                    $sheet->getStyle('A' . $row . ':D' . $row)->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['rgb' => 'CCCCCC'],
                            ],
                        ],
                    ]);

                    // Format numbers
                    $sheet->getStyle('D' . $row)->applyFromArray([
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
                        'numberFormat' => ['formatCode' => '#,##0'],
                    ]);
                }

                // Column widths
                $sheet->getColumnDimension('A')->setWidth(25);
                $sheet->getColumnDimension('B')->setWidth(18);
                $sheet->getColumnDimension('C')->setWidth(18);
                $sheet->getColumnDimension('D')->setWidth(18);

                // Freeze panes
                $sheet->freezePane('A6');
            }
        ];
    }
}
