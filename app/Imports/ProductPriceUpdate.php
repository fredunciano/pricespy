<?php

namespace App\Imports;

use App\Category;
use App\Product;
use App\Source;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductPriceUpdate implements ToCollection, WithBatchInserts, WithHeadingRow
{
    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    protected $solutionType;

    public function __construct($solutionType)
    {
        return $this->solutionType = $solutionType;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $categoryId = Category::where('name', $row['category'])->value('id');
            $row['category_id'] = $categoryId;
            if ($this->solutionType == 2) {
                $product = Product::where(['name' => $row['name'], 'category_id' => $categoryId])->first();
                $row['product_id'] = $product ? $product->id : null;
                $row['manual_override'] = $this->setManualOverrideValue($row['manual_override']);
            }
            $source = Source::where('name', $row['store'])->first();
            $row['source_id'] = $source ? $source->id : null;
            $vatDivisor = $source ? $source->vat / 100 + 1 : 19 / 100 + 1;
            if ($row['netto'] == null && $row['brutto'] != null) {
                $row['netto'] = round((float)priceToFloat($row['brutto']) / $vatDivisor, 2);
            }
            $vatPrice = (float)priceToFloat($row['netto']) * $vatDivisor;

            $row['price'] = round(priceToFloat($row['netto']), 2);
            $row['vat_price'] = ($row['brutto'] != '' && $row['brutto'] != null) ? round(priceToFloat($row['brutto']), 2) : round($vatPrice, 2);
            $row['system_calculated_vat_price'] = round($vatPrice, 2);

            if ($row['product_id'] != null && $row['netto'] != null || $row['brutto'] != null) {
                $validateResult = $this->validateProduct($row);
                if ($validateResult) {
                    $this->productUpdate($row);
                }
            }
        }

        return null;
    }

    public function validateProduct($data)
    {
        return Product::validateUpdatePriceDataRequest($data);
    }

    public function productUpdate($data)
    {
        return Product::updatePrice($data);
    }

    public function setManualOverrideValue(string $value = null)
    {
        $value = strtoupper($value);
        if ($value == 'YES' || $value == 'TRUE' || $value == '1') {
            return true;
        } else if ($value == 'NO' || $value == 'FALSE' || $value == '0') {
            return false;
        } else {
            return false;
        }
    }
}
