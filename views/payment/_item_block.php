<?php

use yii\helpers\Html;

/**
 * trum purum pum pum
 *
 * @var $product string
 * @var $price string
 * @var $count string
 * @var $description string
 */

$isPaid = (isset($isPaid) && $isPaid) ? true : false;
$disabled = (isset($tmpl) || $isPaid) ? 'disabled' : '';
$tmpl = isset($tmpl) ? 'add-form-template' : '';
$first = isset($first) ? 'hide' : '';

?>
<div class="<?= $tmpl ?> col-xs-4 item-block">
    <div class="panel panel-default add-form-item">
        <div class="panel-heading">
            Товар
            <span class="<?= $isPaid ? 'hide' : '' ?>">
                <?= Html::a('Удалить', ['#'], ['class' => 'btn btn-danger btn-xs delete-item '.$first,
                    'onclick' => new \yii\web\JsExpression("return paymentDeleteItem(this);")]) ?>
            </span>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon"><i class="glyphicon glyphicon-font"></i></div>
                    <input type="text" <?= $disabled ?> class="form-control require" name="Item[product][]" value="<?= $product ?>" placeholder="Название">
                    <div class="input-group-addon">*</div>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon"><i class="glyphicon glyphicon-tag"></i></div>
                    <input type="text" <?= $disabled ?> class="form-control require price-value" name="Item[price][]" value="<?= $price ?>" placeholder="Цена">
                    <div class="input-group-addon">10,00 *</div>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon"><i class="glyphicon glyphicon-th"></i></div>
                    <input <?= $disabled ?> type="text" class="form-control require count-value" name="Item[count][]" value="<?= $count ?>" placeholder="Количество">
                    <div class="input-group-addon">1 *</div>
                </div>
            </div>
            <!--div class="form-group">
                <div class="input-group upload-file">
                    <div class="input-group-addon"><i class="glyphicon glyphicon-camera"></i></div>
                    <input disabled type="file" class="form-control" name="image" title="Изображение"/>
                    <div class="input-group-addon">400x370</div>
                </div>
            </div-->
            <div class="form-group">
                <textarea <?= $disabled ?> class="form-control" rows="3" name="Item[description][]" placeholder="Описание"><?= $description ?></textarea>
            </div>
        </div>
    </div>
</div>
