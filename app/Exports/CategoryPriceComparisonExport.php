<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Sheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
    $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
});

class CategoryPriceComparisonExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithColumnFormatting
{

    /**
     * @return \Illuminate\Support\Collection
     */
    private $heading;
    private $datasets;

    public function __construct($heading, $datasets)
    {
        $this->heading = $heading;
        return $this->datasets = $datasets;
    }

    public function collection()
    {
        return collect($this->datasets);
    }


    public function headings(): array
    {
        return $this->heading;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $headCell = 'A1'; // All headers
                $event->sheet->getDelegate()->getStyle($headCell)->getFont()->setSize(12);
                $event->sheet->getDelegate()->getStyle($headCell)->getFont()->setBold(true);

                $cellRange = 'A6:AZ6'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true);
                $event->sheet->mergeCells('A1:G1');
                $event->sheet->mergeCells('A2:G2');
                $event->sheet->mergeCells('A3:G3');
                $event->sheet->mergeCells('A4:G4');
                $event->sheet->mergeCells('A5:G5');
            }
        ];
    }


    /**
     * @return array
     */
    public function columnFormats(): array
    {
        $column = $this->toAlpha().'7';
        return [
            "B7:$column" => NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE,
        ];
    }

    public function toAlpha() {
        $total = count($this->datasets[5]);

        $alphabet = array( 'a', 'b', 'c', 'd', 'e',
            'f', 'g', 'h', 'i', 'j',
            'k', 'l', 'm', 'n', 'o',
            'p', 'q', 'r', 's', 't',
            'u', 'v', 'w', 'x', 'y',
            'z'
        );
        return $alphabet[$total-1];
    }
}
