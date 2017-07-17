<?php

use app\assets\PaymentAsset;

PaymentAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\Payment */
/* @var $errors string */

$this->title = 'Изменить счет #' . $model->id;
if ($model->ext_id > 0) {
    //$this->title
}
?>
<div class="payment-update">

    <?= $this->render('_form', [
        'model' => $model,
        'errors' => $errors
    ]) ?>

</div>
