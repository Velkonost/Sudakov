<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Payment;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\Payment */
/* @var $form yii\widgets\ActiveForm */
/* @var $errors string */

$price = number_format(floatval($model->sum), 2, ',', ' ');
$inputOptions = [];
$isPaid = ($model->status == 1) ? true : false; // если счет оплачен, мы не можем его больше менять
if ($isPaid) {
    $inputOptions = ['readonly' => 'readonly'];
}

?>
<div class="payment-form">

    <?php $form = ActiveForm::begin(); ?>

        <div class="header">
            <h1 class="text-muted">
                <?= Html::encode($this->title) ?>
                <span class="operations <?= $isPaid ? 'hide' : '' ?>">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                </span>
            </h1>
        </div>

        <?= $form->field($model, 'ext_id')->hiddenInput()->label(false) ?>

        <?php if ($model->status == Payment::STATUS_PAID) { ?>
            <div class="form-group field-payment-status">
                <label class="control-label">Тип счета</label>
                <div>
                    <?= Payment::types()[$model->pnum] ?>
                </div>
            </div>
        <?php } else { ?>
            <?= $form->field($model, 'pnum')->dropDownList(Payment::types(false), $inputOptions)->label('Тип счета <b>*</b>') ?>
        <?php } ?>

        <?= $form->field($model, 'client')->textInput(['readonly' => 'readonly'])->label('Клиент') ?>
        <?= ''//$form->field($model, 'comment')->textInput($inputOptions)->label('Комментарий') ?>
        <?php if (!empty($errors)) {
            echo '<div class="error-message">' . $errors . '</div>';
        } ?>

        <?= $form->field($model, 'manager')->hiddenInput()->label(false) ?>

        <?php
        if ($model->status == Payment::STATUS_PAID) {
            ?>
            <div class="form-group field-payment-status">
                <label class="control-label">Статус</label>
                <div>
                    <span class="label label-success">Оплачено</span>
                </div>
            </div>
            <?php
        } else {
            echo $form->field($model, 'status')->hiddenInput()->label(false);
        }
        ?>

        <div class="form-group field-payment-sum">
            <label class="control-label" for="payment-sum">Цена</label>
            <div class="total-price">
                <b><?= $price ?></b><span> руб.</span>
                <?= $form->field($model, 'sum')->hiddenInput()->label(false) ?>
            </div>
        </div>

        <div class="panel panel-default add-form-items-list">
            <div class="panel-heading">
                Товары &nbsp;&nbsp;&nbsp;&nbsp;
                <span class="<?= $isPaid ? 'hide' : '' ?>">
                    <?= Html::a('Добавить товар', ['#'], ['class' => 'btn btn-success btn-xs add-item']) ?>
                </span>
            </div>
            <div class="panel-body">
                <div class="row product-items-list">
                    <?php
                    // {"product":"Тестовый заказ","price":"100","count":"1","image":"818.jpg","description":"Описание"}
                    $items = json_decode($model->items, true);
                    if (!empty($items)) {
                        foreach ($items as $k => $item) {
                            echo Yii::$app->controller->renderPartial('/payment/_item_block', [
                                'product' => $item['product'], 'price' => $item['price'],
                                'count' => $item['count'], 'description' => $item['description'],
                                'first' => (($k==0) ? true : null), 'isPaid' => $isPaid
                            ], true);
                        }
                    } else {
                        $this->registerJs('jQuery(function(){ paymentAddItem(true); });', View::POS_END, 'payment');
                    }
                    ?>
                    <?= Yii::$app->controller->renderPartial('/payment/_item_block', [
                        'tmpl' => true, 'product' => '', 'price' => '', 'count' => '', 'description' => '',
                    ], true) ?>
                    <?php
                    $this->registerJs('jQuery(function(){ $(".price-value, .count-value").on("blur keyup", paymentCalcPrice); });', View::POS_END, 'payment-events');
                    ?>
                </div>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

</div>
