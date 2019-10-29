<?php

namespace App\Services;

use Clicknow\Money\Money;

class FormatMoney extends Money
{
    /**
     * Function overridden for Money class inside vendor
     * @return string
     */
    public function format()
    {
        $negative = $this->isNegative();
        $value = $this->getValue();
        $amount = $negative ? -$value : $value;
        $thousands = $this->currency->getThousandsSeparator();
        $decimals = $this->currency->getDecimalMark();
        $symbolFirst = $this->currency->isSymbolFirst();
        $symbol = $this->currency->getSymbol();

        $prefix = ($negative ? '-' : '').($symbolFirst ? $symbol.' ' : '');
        $value = number_format($amount, 2, $decimals, $thousands);
        $suffix = ! $symbolFirst ? $symbol : '';

        return $suffix.$value.$prefix;
    }
}
