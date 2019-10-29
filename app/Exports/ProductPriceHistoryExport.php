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

class ProductPriceHistoryExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{

    /**
     * @return \Illuminate\Support\Collection
     */
    private $heading;
    private $datasets;
    private $history;

    public function __construct($history)
    {
        $this->history = $history;
        return $this->setData();
    }

    public function setData()
    {
        $rowsData = [];
        $headingRow = ['Store', 'Product'];
        $headingRow = array_merge($headingRow, $this->history['labels']);
        array_push($rowsData, $headingRow);

        foreach ($this->history['datasets'] as $item) {
            $nameArr = explode(': ', $item['label']);
            $storeName = $nameArr[0];
            $productName = $nameArr[1];
            $prices = collect($item['data'])->map(function ($price) {
                return $price == null ? '-' : formatMoney($price);
            })->toArray();
            $rowData = [$storeName, $productName];
            $rowData = array_merge($rowData, $prices);
            array_push($rowsData, $rowData);
        }

        $finalData = [];

        array_push($finalData, [null]);
        array_push($finalData, ['A Table Comparing My Shop\'s Product Price Compared to the Competitors Product Price']);
        $linked = $this->history['linked'];

        array_push($finalData, ["Total Product Linked: $linked"]);
        array_push($finalData, [date('d.m.Y')]);
        array_push($finalData, [null]);

        foreach ($rowsData as $item) {
            array_push($finalData, $item);
        }
        $productName = $this->history['product_name'];
        $this->heading = ["Product Price Comparison Report For: $productName"];
        $this->datasets = $finalData;

        return ['headings' => $this->heading[0], 'datasets' => $rowsData];
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

                $cellRange = 'A7:AZ7'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true);
                $event->sheet->mergeCells('A1:G1');
                $event->sheet->mergeCells('A2:G2');
                $event->sheet->mergeCells('A3:G3');
                $event->sheet->mergeCells('A4:G4');
                $event->sheet->mergeCells('A5:G5');

                $cellRange = 'C7:Z100';
                $event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setHorizontal('center');
            }
        ];
    }
}
