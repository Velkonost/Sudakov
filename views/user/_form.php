<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\SignupUser */
/* @var $form yii\widgets\ActiveForm */

$loginOptions = $model->isNewRecord ? [] : ['disabled' => 'disabled'];

?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput($loginOptions)->label('Логин' . ($model->isNewRecord ? ' <b>*</b>' : '')) ?>

    <?= $form->field($model, 'password')->textInput()->label('Пароль' . ($model->isNewRecord ? ' <b>*</b>' : '')) ?>

    <?= $form->field($model, 'fio')->textInput()->label('ФИО') ?>

    <?= $form->field($model, 'email')->textInput()->label('Email <b>*</b>') ?>

    <?= $form->field($model, 'role')->dropDownList(User::roles())->label('Роль <b>*</b>') ?>

    <?= $form->field($model, 'status')->dropDownList([
        User::STATUS_ACTIVE => 'Активен',
        User::STATUS_INACTIVE => 'Неактивен'
    ])->label('Статус <b>*</b>') ?>

    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
