<?php
namespace app\components;

/**
 * Money helper
 */
class MoneyHelper
{

    /**
     * Возвращает сумму оплат соответствующих методу оплаты и периоду (месяцу)
     *
     * @param \app\models\Money $money
     * @param int $method
     * @param string $monthYear
     * @return float
     */
    public static function isSameMethodAndDate($money, $method, $monthYear)
    {
        $total = 0;
        if ($money->first_payment_method == $method) {
            if(!(date('Y-m', $money->first_payment_date) != $monthYear)) {
                $total += $money->first_payment_amount;
            }
        }
        if ($money->second_payment_method == $method) {
            if(!(date('Y-m', $money->second_payment_date) != $monthYear)) {
                $total += $money->second_payment_amount;
            }
        }
        return $total;
    }


}