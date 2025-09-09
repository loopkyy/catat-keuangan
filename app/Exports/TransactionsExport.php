<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithColumnFormatting, WithEvents
{
    protected $transactions, $totalIncome, $totalExpense, $saldoAwal, $saldoAkhir, $type;

    public function __construct($transactions, $totalIncome, $totalExpense, $saldoAwal, $saldoAkhir, $type)
    {
        $this->transactions = $transactions;
        $this->totalIncome  = $totalIncome;
        $this->totalExpense = $totalExpense;
        $this->saldoAwal    = $saldoAwal;
        $this->saldoAkhir   = $saldoAkhir;
        $this->type         = $type;
    }

    public function collection()
    {
        return $this->transactions;
    }

    public function headings(): array
    {
        return ['Tanggal','Judul','Deskripsi','Jenis','Kategori / Sumber','Jumlah'];
    }

    public function map($trx): array
    {
        return [
            Carbon::parse($trx->date)->format('d/m/Y'),
            $trx->title,
            $trx->description ?? '-',
            $trx->type == 'income' ? 'Pemasukan' : 'Pengeluaran',
            $trx->category ? $trx->category->name : ($trx->source ? $trx->source->name : '-'),
            $trx->amount,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:F1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => 'solid', 'color' => ['rgb' => '4F81BD']],
            'alignment' => ['horizontal' => 'center','vertical' => 'center'],
        ]);
        return [];
    }

    public function columnFormats(): array
    {
        return ['F' => '"Rp"#,##0'];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $rowCount = $this->transactions->count() + 2;

                // TOTAL
                $sheet->setCellValue('E' . $rowCount, 'TOTAL');
                $sheet->getStyle('E' . $rowCount)->getFont()->setBold(true);
                $sheet->setCellValue('F' . $rowCount, '=SUM(F2:F' . ($rowCount-1) . ')');
                $sheet->getStyle('F' . $rowCount)->getFont()->setBold(true);

                // RINGKASAN
                $summaryRow = $rowCount + 2;
                $sheet->setCellValue('E' . $summaryRow, 'Ringkasan');
                $sheet->getStyle('E' . $summaryRow)->getFont()->setBold(true);

                $sheet->setCellValue('E' . ($summaryRow + 1), 'Saldo Awal');
                $sheet->setCellValue('F' . ($summaryRow + 1), $this->saldoAwal);

                if ($this->type === 'all') {
                    $sheet->setCellValue('E' . ($summaryRow + 2), 'Total Pemasukan');
                    $sheet->setCellValue('F' . ($summaryRow + 2), $this->totalIncome);

                    $sheet->setCellValue('E' . ($summaryRow + 3), 'Total Pengeluaran');
                    $sheet->setCellValue('F' . ($summaryRow + 3), $this->totalExpense);

                    $sheet->setCellValue('E' . ($summaryRow + 4), 'Saldo Akhir');
                    $sheet->setCellValue('F' . ($summaryRow + 4), $this->saldoAkhir);

                    $sheet->getStyle('E' . ($summaryRow + 1) . ':F' . ($summaryRow + 4))->getFont()->setBold(true);

                } elseif ($this->type === 'income') {
                    $sheet->setCellValue('E' . ($summaryRow + 2), 'Total Pemasukan');
                    $sheet->setCellValue('F' . ($summaryRow + 2), $this->totalIncome);

                    $sheet->setCellValue('E' . ($summaryRow + 3), 'Saldo Akhir');
                    $sheet->setCellValue('F' . ($summaryRow + 3), $this->saldoAkhir);

                    $sheet->getStyle('E' . ($summaryRow + 1) . ':F' . ($summaryRow + 3))->getFont()->setBold(true);

                } elseif ($this->type === 'expense') {
                    $sheet->setCellValue('E' . ($summaryRow + 2), 'Total Pengeluaran');
                    $sheet->setCellValue('F' . ($summaryRow + 2), $this->totalExpense);

                    $sheet->setCellValue('E' . ($summaryRow + 3), 'Saldo Akhir');
                    $sheet->setCellValue('F' . ($summaryRow + 3), $this->saldoAkhir);

                    $sheet->getStyle('E' . ($summaryRow + 1) . ':F' . ($summaryRow + 3))->getFont()->setBold(true);
                }
            },
        ];
    }
}
