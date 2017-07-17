<?php
/**
 * Top nav for layout
 *
 * @var $user \app\models\User
 */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

$menuItems = [];
if ($user->hasRole(['superadmin', 'manager-payment'])) {
    $menuItems[] = ['label' => 'Внести лид', 'url' => ['/lead/add']];
}
if ($user->hasRole(['superadmin', 'manager-payment', 'acc_manager'])) {
    $menuItems[] = ['label' => 'Счета', 'url' => ['/payment/index']];
}
if ($user->hasRole(['superadmin', 'admin', 'worker', 'acc_manager'])) {
    $menuItems[] = ['label' => 'Производство', 'url' => ['/erp/index']];
}
if ($user->hasRole(['superadmin', 'buh'])) {
    $menuItems[] = ['label' => 'Фин. мониторинг', 'url' => ['/money/index']];
}
if ($user->hasRole('superadmin')) {
    $menuItems[] = ['label' => 'Пользователи', 'url' => ['/user/index']];
}

$menuItems[] = Yii::$app->user->isGuest ? (['label' => 'Login', 'url' => ['/site/login']]) : (
    '<li>'
    . Html::beginForm(['/site/logout'], 'post', ['class' => 'navbar-form'])
    . Html::submitButton('Выйти (' . $user->username . ')', ['class' => 'btn btn-link'])
    . Html::endForm()
    . '</li>'
);

NavBar::begin([
    'brandLabel' => '&nbsp;',
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $menuItems,
]);
NavBar::end();