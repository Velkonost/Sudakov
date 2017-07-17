<?php
/* @var $models \app\models\Money */

use app\models\Money;
use app\models\Payment;

$sum = [Money::METHOD_YANDEX => 0, Money::METHOD_CARD => 0, Money::METHOD_BSO => 0, Money::METHOD_CASH => 0, Money::METHOD_BANK_RS => 0];

$method = [0=>"нет", Money::METHOD_YANDEX => "Эквайринг", Money::METHOD_BANK => "Банк", Money::METHOD_BANK_RS => "р/с", Money::METHOD_BSO => "БСО",
    Money::METHOD_CARD => "Карта", Money::METHOD_CASH => "Наличные"];

$header = '"Имя Клиента";"Телефон";"Город";"Статус";"Бюджет финальный";"1-я оплата";"Как внесли 1-ю оплату";"Дата 1-й оплаты";"2-я оплата";"Как внесли 2-ю оплату";"Дата 2-й оплаты";"Комментарий";"Эквайринг";"Карта (НПК)";"БСО";"Нал";"Р/C";"1-я оплата";"Дата 1-й оплаты";"2-я оплата";"Дата 2-й оплаты";"Сверка с реестром";"№";"Дата";"Комментарий";"Коллекция";"Кол-во";"Единицы";"Дедлайн";"Успешно реализовано";"Предоплаты с прошлых месяцев";"Должны в текущем месяце";"Должны в следующих месяцах";"Дата добавления"' . "\n";
echo mb_convert_encoding($header, 'Windows-1251', 'UTF-8');

foreach ($models as $row) {
    $first_payment = 0;
    $first_payment_date = '';
    $second_payment = 0;
    $second_payment_date ="";
    $payments_before = 0;
    $payments_present = 0;
    $payments_next = 0;
    if (empty($row->status->label)) {
        $status = '';
    } else {
        $status = $row->status->label;
    }
    $days = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
    $fromDate = strtotime(date('Y-m-01 00:00:00'));
    $toDate = strtotime(date('Y-m-' . $days . ' 23:59:59'));

    $total = 0;
    if ($row->first_payment_date < $fromDate) {
        $total += $row->first_payment_amount;
    }
    if ($row->second_payment_date < $fromDate) {
        $total += $row->second_payment_amount;
    }
    $payments_before =  number_format($total, 0, ',', ' ');

    $total = 0;
    if ($row->total_amount > 0 && $row->deadline <= $toDate && $row->deadline >= $fromDate) {
        $total = $row->total_amount - $row->first_payment_amount;
        if ($row->second_payment_date > 0 &&  $row->second_payment_amount > 0) {
            $total -= $row->second_payment_amount;
        }
    }
    $payments_present =  number_format($total, 0, ',', ' ');
    $total = 0;
    if ($row->total_amount > 0 && $row->deadline > $toDate) {
        $total = $row->second_payment_amount;
        if ($row->second_payment_date > 0 &&  $row->second_payment_amount > 0) {
            $total -= $row->second_payment_amount;
        }
    }
    $payments_next =  number_format($total, 0, ',', ' ');

    foreach ($row->payments as $payment) {
        if ($payment->pnum == 1 && $payment->status == Payment::STATUS_PAID){
            $first_payment =  number_format($payment->sum, 0, ',', ' ');
        }
        if ($payment->pnum == 1 && $payment->status == Payment::STATUS_PAID && $payment->paid_at > 0) {
            $first_payment_date =  date('d.m.y', $payment->paid_at);
        }
        if ($payment->pnum == 2 && $payment->status == Payment::STATUS_PAID) {
            $second_payment = number_format($payment->sum, 0, ',', ' ');
        }
        if ($payment->pnum == 2 && $payment->status == Payment::STATUS_PAID && $payment->paid_at > 0) {
            $second_payment_date = date('d.m.y', $payment->paid_at);
        }
    }
    $line = [$row->client_name, $row->phone, $row->city, $status, $row->total_amount, $row->first_payment_amount,
        $method[$row->first_payment_method], (empty($row->first_payment_date) ? '' : date('d.m.y', $row->first_payment_date)),
        $row->second_payment_amount, $method[$row->second_payment_method], date("d-m-Y", $row->second_payment_date),
        $row->comment_fin, $sum[Money::METHOD_YANDEX], $sum[Money::METHOD_CARD], $sum[Money::METHOD_BSO], $sum[Money::METHOD_CASH],
        $sum[Money::METHOD_BANK_RS], $first_payment, $first_payment_date, $second_payment, $second_payment_date,
        $row->registry_check, (empty($row->goods_bill_num) ? '' : $row->goods_bill_num),
        (empty($row->goods_bill_date) ? '' : date('d.m.y', $row->goods_bill_date)), $row->goods_bill_comment,
        $row->collection, $row->count, $row->units, $row->deadline, (empty($row->finished_at) ? '' : date('d.m.y', $row->finished_at)),
        $payments_before, $payments_before, $payments_present, $payments_next, date('d.m.y H:i', $row->created_at)
    ];

    // конвертируем в cp1251
    foreach ($line as $k => $column) {
        if (substr($column, 0, 1) == '-' || substr($column, 0, 1) == '+' || substr($column, 0, 1) == '=') {
            $line[$k] = "'" . $line[$k];
        }
        if (!is_numeric($column)) {
            $line[$k] = mb_convert_encoding($column, 'Windows-1251', 'UTF-8');
        }
    }

    echo '"' . implode('";"', $line) . '"' . "\n";

}

