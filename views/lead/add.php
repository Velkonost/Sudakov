<?php

use app\assets\LeadAsset;
LeadAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\Payment */
/* @var $error string */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Внести лид';
?>
<div class="lead-create">

    <?php if (!empty($error)) {
        echo $error;
    } ?>
    
    <div class="lead-form">

        <?php $form = ActiveForm::begin(); ?>

        <div class="header">
            <h1 class="text-muted">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>

        <?= $form->field($model, 'name')->textInput()->label('Фамилия и имя <b>*</b>') ?>

        <?= $form->field($model, 'phone')->textInput()->label('Телефон') ?>

        <?= $form->field($model, 'city')->textInput()->label('Город') ?>

        <?= $form->field($model, 'request')->textInput()->label('Название сделки') ?>

        <?= $form->field($model, 'email')->textInput()->label('Email') ?>

        <?= $form->field($model, 'source')->dropDownList([
            '' => '...',
            'Повторный' => 'Повторный заказ',
            'Ярмарка' => 'Ярмарка мастеров',
            'Инстаграм' => 'Инстаграм',
            'Сарафан' => 'Сарафан',
            'Директ ручной' => 'Директ ручной',
            'Goolge ручной' => 'Goolge ручной',
            'Facebook ручной' => 'Facebook ручной',
            'Активация карты' => 'Активация карты',
            'Реклама' => 'Реклама',
            'Подарок' => 'Подарок',
        ])->label('Источник <b>*</b>') ?>

        <div class="operations">
            <?= Html::submitButton('Внести', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
