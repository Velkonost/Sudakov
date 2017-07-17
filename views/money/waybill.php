<?php
/**
 * waybill
 *
 * @var $money \app\models\Money
 */

use app\models\Money;
use app\assets\MoneyAsset;

MoneyAsset::register($this);

$this->title = 'Товарный чек №' . $money->goods_bill_num;

$count = empty($money->count) ? 1 : $money->count;
$totalSum = number_format($money->total_amount, 0, ',', ' ');
?>
<div class="waybill">
    <div class="w-wrap">
        <div class="left-side">
            <h1>Товарный чек №<b><?= $money->goods_bill_num ?></b></h1>
            <div class="client-row">
                <table>
                    <tr class="titles">
                        <td>Клиент</td>
                        <td>Дата</td>
                    </tr>
                    <tr class="names">
                        <td><?= $money->client_name ?></td>
                        <td><?= date('d.m.Y', $money->goods_bill_date) ?></td>
                    </tr>
                </table>
            </div>
            <div class="items">
                <table>
                    <tr>
                        <th class="th1">Наименование</th>
                        <th class="th2">Кол-во</th>
                        <th class="th3">Единица</th>
                        <th class="th4">Стоимость, <i class="fa fa-rub" aria-hidden="true"></i></th>
                        <th class="th5">Сумма, <i class="fa fa-rub" aria-hidden="true"></i></th>
                    </tr>
                    <tr>
                        <td class="td1"><?= $money->collection ?></td>
                        <td class="td2"><?= $count ?></td>
                        <td class="td3"><?= $money->units ?></td>
                        <td class="td4"><?= number_format($money->total_amount / $count, 0, ',', ' ') ?></td>
                        <td class="td5"><?= $totalSum ?></td>
                    </tr>
                </table>
            </div>
            <div class="total-string">
                <div class="caption">Итого</div>
                <div class="amount">
                    <b><?= $totalSum ?></b>
                    (<?= trim(\app\models\Money::amountToStr($money->total_amount, false)) ?>)
                    рублей
                </div>
            </div>
            <div class="sign">
                <div class="left">
                    ________________ ИП Судаков С.Е.
                </div>
                <div class="right">
                    Получил: ____________&nbsp;&nbsp;&nbsp;____________&nbsp;&nbsp;&nbsp;___.___._____
                    <img src="/images/check.jpg" class="l-check"/>
                    <span class="l1">подпись</span>
                    <span class="l2">расшифровка</span>
                    <span class="l3">дата</span>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="cp-footer">
                <img src="/images/logo-gray.png" />
                <span class="copy">
                    ИП Судаков Сергей Евгеньевич<br>
                    ОГРНИП 311774617300067<br>
                    ИНН 550505666359
                </span>
            </div>

        </div>

        <div class="right-side">
            <div class="caption">Клиент</div>
            <div class="text">
                <?= $money->client_name ?><br>
                <?= $money->phone ?>
            </div>
            <div class="caption">1-я оплата</div>
            <div class="text">
                <?php if ($money->first_payment_amount != 0/* && $money->first_payment_status == 1*/) { ?>
                    <?= number_format($money->first_payment_amount, 0, ',', ' ') ?>
                    <i class="fa fa-rub" aria-hidden="true"></i>
                <?php } else { ?>
                    ______________________
                <?php } ?>
            </div>
            <div class="caption">Как внесли</div>
            <div class="text"><?= Money::getMethodLabel($money->first_payment_method) ?></div>
            <div class="caption">2-я оплата</div>
            <div class="text">
                <?php if ($money->second_payment_amount != 0/* && $money->second_payment_status == 1*/) { ?>
                <?= number_format($money->second_payment_amount, 0, ',', ' ') ?>
                <i class="fa fa-rub" aria-hidden="true"></i>
                <?php } else { ?>
                    ______________________
                <?php } ?>
            </div>
            <div class="caption">Как внесли</div>
            <div class="text"><?= Money::getMethodLabel($money->second_payment_method) ?></div>

            <div class="caption-last">К доплате</div>
            <div class="cp-footer">
                <div class="remain-amount">
                    <b>
                    <?php
                    $remain = $money->total_amount;
                    if ($money->first_payment_amount != 0/*$money->first_payment_status == 1*/) {
                        $remain -= $money->first_payment_amount;
                    }
                    if ($money->second_payment_amount != 0/*$money->second_payment_status == 1*/) {
                        $remain -= $money->second_payment_amount;
                    }
                    echo number_format($remain, 0, ',', ' ');
                    ?>
                    </b>
                    <i class="fa fa-rub" aria-hidden="true"></i>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>
    </div>
    <div class="w-wrap">
        <div class="left-side">
            <h1>Товарный чек №<b><?= $money->goods_bill_num ?></b></h1>
            <div class="client-row">
                <table>
                    <tr class="titles">
                        <td>Клиент</td>
                        <td>Дата</td>
                    </tr>
                    <tr class="names">
                        <td><?= $money->client_name ?></td>
                        <td><?= date('d.m.Y', $money->goods_bill_date) ?></td>
                    </tr>
                </table>
            </div>
            <div class="items">
                <table>
                    <tr>
                        <th class="th1">Наименование</th>
                        <th class="th2">Кол-во</th>
                        <th class="th3">Единица</th>
                        <th class="th4">Стоимость, <i class="fa fa-rub" aria-hidden="true"></i></th>
                        <th class="th5">Сумма, <i class="fa fa-rub" aria-hidden="true"></i></th>
                    </tr>
                    <tr>
                        <td class="td1"><?= $money->collection ?></td>
                        <td class="td2"><?= $count ?></td>
                        <td class="td3"><?= $money->units ?></td>
                        <td class="td4"><?= number_format($money->total_amount / $count, 0, ',', ' ') ?></td>
                        <td class="td5"><?= $totalSum ?></td>
                    </tr>
                </table>
            </div>
            <div class="total-string">
                <div class="caption">Итого</div>
                <div class="amount">
                    <b><?= $totalSum ?></b>
                    (<?= trim(\app\models\Money::amountToStr($money->total_amount, false)) ?>)
                    рублей
                </div>
            </div>
            <div class="sign">
                <div class="left">
                    ________________ ИП Судаков С.Е.
                </div>
                <div class="right">
                    Получил: ____________&nbsp;&nbsp;&nbsp;____________&nbsp;&nbsp;&nbsp;___.___._____
                    <img src="/images/check.jpg" class="l-check"/>
                    <span class="l1">подпись</span>
                    <span class="l2">расшифровка</span>
                    <span class="l3">дата</span>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="cp-footer">
                <img src="/images/logo-gray.png" />
                <span class="copy">
                    ИП Судаков Сергей Евгеньевич<br>
                    ОГРНИП 311774617300067<br>
                    ИНН 550505666359
                </span>
            </div>
        </div>
        <div class="right-side"> </div>
        <div class="clearfix"></div>
    </div>
</div>
