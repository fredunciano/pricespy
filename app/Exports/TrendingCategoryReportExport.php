<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Sheet;

Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
    $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
});

class TrendingCategoryReportExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{

    /**
     * @return \Illuminate\Support\Collection
     */
    private $heading;
    private $datasets;

    public function __construct($data, $heading)
    {
        $this->datasets = $data;
        return $this->heading = $heading;
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

                $cellRange = 'A5:C5'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true);
                $event->sheet->mergeCells('A1:G1');
                $event->sheet->mergeCells('A2:G2');
                $event->sheet->mergeCells('A3:G3');
                $event->sheet->mergeCells('A4:G4');
//                $event->sheet->mergeCells('A5:G5');

                $cellRange = 'B5:C1000';
                $event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setHorizontal('center');
            }
        ];
    }
}
