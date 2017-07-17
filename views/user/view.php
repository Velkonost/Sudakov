<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$roles = ['superadmin' => 'Супер администратор', 'admin' => 'Администратор', 'worker' => 'Сотрудник', 'acc_manager' => 'Аккаунт менеджер'];
$role = isset($roles[$model->role]) ? $roles[$model->role] : $model->role;
$statuses = [0 => '---', User::STATUS_ACTIVE => 'Активен', User::STATUS_INACTIVE => 'Неактивен'];
$status = $statuses[$model->status];

?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Удалить пользователя?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            ['label' => 'ID', 'value' => $model->id],
            ['label' => 'Логин', 'value' => $model->username],
            ['label' => 'Email', 'value' => $model->email],
            ['label' => 'Роль', 'value' => $role],
            ['label' => 'Статус', 'value' => $status],
            ['label' => 'Зарегистрирован', 'value' => date('d.m.Y', $model->created_at)],
        ],
    ]) ?>

</div>
