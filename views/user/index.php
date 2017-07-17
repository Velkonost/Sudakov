<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\User;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Создать пользователя', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            ['label' => 'Логин', 'attribute' => 'username'],
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            ['label' => 'Email', 'attribute' => 'email'],
            ['label' => 'ФИО', 'attribute' => 'fio'],
            ['label' => 'Статус', 'value' => function($model) {
                $statuses = [0 => '---', User::STATUS_ACTIVE => 'Активен', User::STATUS_INACTIVE => 'Неактивен'];
                return $statuses[$model->status];
            }],
            ['label' => 'Дата регистрации', 'value' => function($model) {
                return date('d.m.Y', $model->created_at);
            }],
            ['label' => 'Роль', 'value' => function($model) {
                $roles = User::roles();
                return isset($roles[$model->role]) ? $roles[$model->role] : $model->role;
            }],
            // 'updated_at',
            ['class' => 'yii\grid\ActionColumn'],
            //['label' => '', ]
        ],
    ]); ?>

    <p>
        <a class="btn btn-success" href="manager/create">Create Manager</a>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProviderManager,
        'filterModel' => $searchModelManager,
        'columns' => [


            'id',
            'responsible_user_id',
            'name',


        ],
    ]); ?>
</div>
