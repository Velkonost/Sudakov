<?php

use app\assets\PaymentAsset;
PaymentAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\Payment */
/* @var $errors string */

$this->title = 'Создать счет';
//$this->params['breadcrumbs'][] = ['label' => 'Payments', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-create">

    <?= $this->render('_form', [
        'model' => $model,
        'errors' => $errors
    ]) ?>

</div>
