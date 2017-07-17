<?php
/**
 * Checkout page
 *
 * @var $model \app\models\Payment
 * @var $invoiceId string
 */

use app\assets\PaymentAsset;

PaymentAsset::register($this);

$this->title = 'Оплата заказа';

?><div class="checkout"><?php
    $csrfName = Yii::$app->request->csrfParam;
    $csrfValue = Yii::$app->request->csrfToken;
    $time = time();
    $hash = md5($model->id . '&' . $model->ext_id); // для верификаци на следующей странице
    $paid = '';
    $paymentButton = '';
    if ($model->status != \app\models\PaymentSearch::STATUS_PAID) {
        $paymentButton = '<form action="/payment/gateway" method="post">' .
            "<input name=\"id\" value=\"{$invoiceId}\" type=\"hidden\">" .
            "<input name=\"hash\" value=\"{$hash}\" type=\"hidden\"/>" .
            "<input name=\"{$csrfName}\" value=\"{$csrfValue}\" type=\"hidden\"/>" .
            "<input class='payment-button' type='submit' value=''></form>";
    } else {
        $paid = '<span class="label label-success">Оплачено</span>';
    }
    $items = json_decode($model->items, true);
    ?>
    <div class="logo">
        <img src="/images/logo.png" alt=""/>
        <h1>Оплата заказа</h1>
    </div>
    <div class="products">
        <div class="row items"><?php
            foreach ($items as $k => $item) {
                if ($k > 0 && $k%4 == 0) {
                    ?></div><div class="row"><?php
                }
                $noImg = 'no-image';
                $image = '';
//                if (!empty($item['image'])) {
//                    $image = '<div class="image"><img src="' .  $baseUrl . '/products_images/' . $item['image'] . '" alt="" width="100%" /></div>';
//                    $noImg = '';
//                }
                $price = str_replace(',00', '', number_format($item['price'], 2, ',', ' '));
                ?><div class="column col-md-3 col-sm-6 col-xs-12">
                    <div class="item <?= $noImg ?>">
                        <?= $image ?>
                        <h4><?= $item['product'] ?></h4>
                        <div class="description"><?= $item['description'] ?></div>
                        <p class="price">Цена: <?= $price ?> <img src="/images/rub.png"></p>
                        <p class="count">Количество: <?= $item['count'] ?></p>
                    </div>
                </div><?php
            }
            ?></div>
    </div>
    <div class="total tot1">
        <div class="sum">Сумма заказа: <?= str_replace(',00', '', number_format($model->sum, 2, ',', ' ')); ?> <img src="/images/rub.png"/> <?= $paid ?></div>
        <?= $paymentButton ?>
    </div>
    <?php if (!empty($paymentButton)) { ?>
    <div class="info">
        Оплачивая этот заказ, Вы соглашаетесь с <a href="http://sergeysudakov.ru/zaponki/offerta.html" target="_blank" title="">договором оферты</a>
    </div>
    <?php } ?>
    <div class="about-company">
        <h4>О компании</h4>
        <p><b>Sudakov Jewellery Atelier</b> - премиальный российский ювелирный бренд, созданный художником-ювелиром Сергеем Судаковым.
            Основная идея бренда заключается в уникальности каждого эксклюзивного изделия. Линия украшений, рожденная сквозь восприятие многогранной красоты мира.
            Укращения, созданные из материалов высочайшего качества, будут переходить из одного поколения в другое.</p>
        <p></p>
        <p>Вид оказываемых услуг: Дизайн и разработка ювелирных изделий и бижутерии.</p>
        <p></p>
        <p>ИНН организации: 550505666359</p>
    </div>
</div>

