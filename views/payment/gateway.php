<?php
/**
 * @var $model \app\models\Payment
 * @var $invoiceId string
 */
 
use app\assets\PaymentAsset;
PaymentAsset::register($this);

$paymentUrl = Yii::$app->params['yandex']['paymentUrl'];
$gateways = Yii::$app->params['yandex']['gateways'];
$shopID = Yii::$app->params['yandex']['shopID'];
$cSID = Yii::$app->params['yandex']['cSID'];
$shopDoc = Yii::$app->params['yandex']['shopDoc'];
?>
<div class="checkout">
    <div class="logo">
        <img src="/images/logo.png" alt=""/>
        <h1>Способ оплаты</h1>
    </div>
    <form action="<?= $paymentUrl ?>" method="post">
        <div class="row gateways">
            <?php
            foreach ($gateways as $code => $gateway) {
                ?><div class="col-xs-12 col-sm-6 col-md-3 gt-col"><?php
                if ($code == 'AC') {
                    ?>
                    <label>
                        <input name="paymentType" value="<?= $code ?>" type="radio" checked />
                        Банковские карты
                    </label>
                    <table>
                        <tr>
                            <td><img src="/images/pay/payVisa.png" alt="" width="62" height="21" /></td>
                            <td>Visa, Visa Electron</td>
                        </tr>
                        <tr>
                            <td><img src="/images/pay/payMaster.png" alt="" width="62" height="31" /></td>
                            <td>MasterCard</td>
                        </tr>
                        <tr>
                            <td><img src="/images/pay/payMaestro.png" alt="" width="62" height="31" /></td>
                            <td>Maestro</td>
                        </tr>
                    </table>
                    <?php
                } else if ($code == 'PC') {
                    ?>
                    <label>
                        <input name="paymentType" value="<?= $code ?>" type="radio" />
                        Электронные деньги
                    </label>
                    <table>
                        <tr>
                            <td><img src="/images/pay/payYandex.png" alt="" width="30" height="30" /></td>
                            <td>Яндекс.Деньги</td>
                        </tr>
                        <!--tr>
                            <td><img src="/images/pay/payWebmoney.png" alt="" width="30" height="31" /></td>
                            <td>WebMoney</td>
                        </tr-->
                    </table>
                    <?php
                } else if ($code == 'GP') {
                    ?>
                    <label>
                        <input name="paymentType" value="<?= $code ?>" type="radio" />
                        Наличные
                    </label>
                    <table>
                        <tr>
                            <td><img src="/images/pay/payRouble.png" alt="" width="32" height="29" /></td>
                            <td>Оплата наличными</td>
                        </tr>
                    </table>
                    <?php
                } else if ($code == 'AB') {
                    ?>
                    <label>
                        <input name="paymentType" value="<?= $code ?>" type="radio" />
                        Интернет-банкинг
                    </label>
                    <table>
                        <!--tr>
                            <td><img src="/images/pay/paySber.png" alt="" width="32" height="30" /></td>
                            <td>Сбербанк Онлайн</td>
                        </tr-->
                        <tr>
                            <td><img src="/images/pay/payAlpha.png" alt="" width="32" height="34" /></td>
                            <td>Альфа-Клик</td>
                        </tr>
                        <!--tr>
                            <td><img src="/images/pay/payMasterPass.png" alt="" width="50" height="31" /></td>
                            <td>MasterPass</td>
                        </tr>
                        <tr>
                            <td><img src="/images/pay/payPSB.png" alt="" width="50" height="50" /></td>
                            <td>ПромСвязьБанк</td>
                        </tr-->
                    </table>
                    <?php
                }
                ?></div><?php
            }
            ?>
        </div>
        <div class="total">
            <div class="sum">Сумма заказа: <?= str_replace(',00', '', number_format($model->sum,2,',',' ')); ?> <img src="/images/rub.png"/></div>
            <input name="shopId" value="<?= $shopID ?>" type="hidden"/>
            <input name="scid" value="<?= $cSID ?>" type="hidden"/>
            <input name="sum" value="<?= $model->sum ?>" type="hidden"/>
            <input name="customerNumber" value="<?= $shopDoc ?>" type="hidden"/>
            <input name="orderNumber" value="<?= $invoiceId ?>" type="hidden"/>
            <input class="payment-button" type="submit" value="">
        </div>
    </form>
</div>
