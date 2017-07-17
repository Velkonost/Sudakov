<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Авторизация';
$this->params['breadcrumbs'][] = $this->title;

switch (Yii::$app->params['subdomain']) {
    case 'erp':
        $header = 'ERP';
        break;
    case 'payment':
        $header = 'Управление счетами';
        break;
    case 'money':
        $header = 'Бухгалтерия';
        break;
    default:
        $header = 'CRM';
}

?>
<div class="site-login row">

    <div class="login-form col-md-offset-4 col-md-4 col-sm-offset-2 col-sm-8 col-xs-12">
        <img src="/images/logo.png" alt="">

        <h1><?= $header ?></h1>

        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'options' => ['class' => 'form-horizontal'],
            'fieldConfig' => [
                'template' => "<div class=\"col-lg-8 col-sm-offset-2\">{input}</div>\n<div class=\" col-sm-offset-2 col-lg-8\">{error}</div>",
                'labelOptions' => ['class' => 'col-lg-1 control-label'],
            ],
        ]); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => 'Логин'])->label(false) ?>

            <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Пароль'])->label(false) ?>

            <?php /*= $form->field($model, 'rememberMe')->checkbox([
                'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
            ]) */ ?>

            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-8">
                    <?= Html::submitButton('Авторизоваться', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>
