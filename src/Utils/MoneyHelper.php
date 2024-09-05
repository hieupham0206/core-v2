<?php

namespace Cloudteam\CoreV2\Utils;

use Cloudteam\CoreV2\Enums\VATRate;

class MoneyHelper
{
    /**
     * @param $amountAfterTax : Số tiền sau thuế
     * @param $vatRate : Thuế suất [0,5,8,10]
     * @param $precision : Số phần thập phân, default là 0
     *
     * @return float
     */
    public static function getAmountBeforeTax($amountAfterTax, $vatRate, $precision = 0): float
    {
        if (! is_numeric($vatRate) || ! in_array($vatRate, [5, 8, 10])) {
            $vatRate = 0;
        }

        return round($amountAfterTax / (1 + $vatRate / 100), $precision);
    }

    /**
     * @param $amountBeforeTax : Số tiền trước thuế
     * @param $vatRate : Thuế suất [0,5,8,10]
     * @param $precision : Số phần thập phân, default là 0
     *
     * @return float
     */
    public static function getAmountAfterTax($amountBeforeTax, $vatRate, $precision = 1): float
    {
        if (! is_numeric($vatRate)) {
            $vatRate = 0;
        }

        $taxValue = VATRate::getTaxValue($vatRate);

        $tmpValue = $amountBeforeTax * $taxValue;
        $amount   = round($tmpValue, $precision);

        if (substr($amount, -1) == 5) {
            if ($amount % 10 >= 5) {
                return ceil($amount);
            }

            return floor($amount);
        }

        return substr($amount, -1) < 5 ? floor($amount) : ceil($amount);
    }

    /**
     * @param $amountAfterTax : Số tiền sau thuế
     * @param $vatRate : Thuế suất [0,5,8,10]
     * @param int $precision : Số phần thập phân, default là 0
     *
     * @return float
     */
    public static function getTaxAmount($amountAfterTax, $vatRate, int $precision = 0): float
    {
        if (! is_numeric($vatRate)) {
            $vatRate = 0;
        }

        $amountBeforeTax = self::getAmountBeforeTax($amountAfterTax, $vatRate, $precision);

        return round($amountAfterTax - $amountBeforeTax, $precision);
    }
}