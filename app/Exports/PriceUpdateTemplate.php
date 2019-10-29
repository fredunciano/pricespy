<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Sheet;

Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
    $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
});

class PriceUpdateTemplate implements FromCollection, WithHeadings, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    private $heading;
    private $datasets;

    public function __construct($heading, $dataSet)
    {
        $this->heading = $heading;
        return $this->datasets = $dataSet;
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
                $headCell = 'A1:F1'; // All headers
                $event->sheet->getDelegate()->getStyle($headCell)->getFont()->setSize(12);
                $event->sheet->getDelegate()->getStyle($headCell)->getFont()->setBold(true);
                $event->sheet->styleCells(
                    'C1:C5000',
                    [
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        ],
                    ]
                );
            }
        ];
    }


}
