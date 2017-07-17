<?php

use yii\helpers\Url;
use app\models\Job;
use app\assets\ErpAsset;

ErpAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\Job */
/* @var $user app\models\User */
/* @var $images array */
/* @var $drawsAI array */
/* @var $drawsDXF array */
/* @var $planDescription array */
/* @var $logs app\models\Log[] */

$this->title = $model->name;
//$this->params['breadcrumbs'][] = ['label' => 'Jobs', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;

?>
<div class="job-view row">
    <div class="col-xs-12">
        <h1><?= $this->title ?></h1>
    </div>

    <!-- для мобилы -->
    <div class="col-md-6 col-xs-12 visible-xs-block visible-sm-block hidden-lg hidden-md">
        <div class="details row">
            <div class="col-xs-6">
                <h4>Статус</h4>
                <div class="status-selector-wrap" data-job_id="<?= $model->id ?>" data-status_url="<?= Url::toRoute(['erp/update-status']) ?>">
                    <div class="select-status <?= ($user->hasRole('superadmin') || $user->hasRole('admin')) ? 'selector' : '' ?>">
                        <?php
                        if (!$user->hasRole('superadmin') && !$user->hasRole('admin')) {
                            ?><span class="big-status status-<?= $model->status ?>"><?= Job::getStatusCaption($model->status) ?></span><?php
                        } else {
                            foreach (Job::getStatuses() as $key => $title) {
                                ?><a href="#" data-status="<?= $key ?>" class="big-status status-<?= $key ?> <?= ($model->status == $key ? 'selected' : 'hide') ?>">
                                <?= $title ?>
                                </a><?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-xs-6">
                <h4>Deadline</h4>
                <div class="value"><?= !empty($model->deadline) ? date('d.m.Y', $model->deadline) : '' ?></div>
            </div>
            <div class="col-xs-12">
                <h4>Описание</h4>
                <div class="value"><?= !empty($model->description) ? $model->description : '-----' ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xs-12 visible-xs-block visible-sm-block hidden-lg hidden-md">
        <div class="row">
            <p>
                <b class="type"><?= $model->collection ?></b>
            </p>
            <?php
            if (empty($images)) {
                ?><p class="no-images">Нет эскизов</p><?php
            } else {
                ?><h4>Эскизы</h4><?php
            }
            foreach (['k1', 'k2'] as $key) {
                if (isset($images[$key])) {
                    ?><div class="image"><img src="<?= $images[$key] ?>" alt=""/></div><?php
                }
                if (isset($planDescription[$key])) {
                    ?><div class="plan-descr"><?= $planDescription[$key] ?></div><?php
                }
                if (isset($drawsDXF[$key])) {
                    ?><div class="download-link">
                    <a href="<?= $drawsDXF[$key][1] ?>" title="Скачать" target="_blank"><?= $drawsDXF[$key][0] ?> <i class="fa fa-download" aria-hidden="true"></i></a>
                    </div><?php
                }
                if (isset($drawsAI[$key])) {
                    ?><div class="download-link">
                    <a href="<?= $drawsAI[$key][1] ?>" title="Скачать" target="_blank"><?= $drawsAI[$key][0] ?> <i class="fa fa-download" aria-hidden="true"></i></a>
                    </div><?php
                }
                echo '<hr>';
            }
            if (!empty($logs)) {
                ?><h5>Журнал событий</h5>
                <table class="logs-table table-striped">
                    <?php foreach ($logs as $log) { /* @var $log \app\models\Log */ ?>
                        <tr>
                            <td><?= date('d.m.Y H:i', $log->created_at) ?></td>
                            <td><?= $log->username ?> изменил статус на</td>
                            <td><?= '<span class="status-' . $log->new_status . '">' . Job::getStatusCaption($log->new_status) . '</span>' ?></td>
                        </tr>
                    <?php } ?>
                </table>
                <?php
            }
            ?>
        </div>
        <div class="col-xs-6">
            <h4>Клиент</h4>
            <div class="value"><?= !empty($model->client) ? $model->client : 'не указан' ?></div>
        </div>
        <div class="col-xs-6">
            <h4>Дата поступления</h4>
            <div class="value"><?= !empty($model->created_at) ? date('d.m.Y H:i', $model->created_at) : '-----' ?></div>
        </div>
        <div class="col-xs-6">
            <h4>Дата начала работ</h4>
            <div class="value"><?= !empty($model->started_at) ? date('d.m.Y H:i', $model->started_at) : '-----' ?></div>
        </div>
        <div class="col-xs-6">
            <h4>Дата завершения</h4>
            <div class="value"><?= !empty($model->finished_at) ? date('d.m.Y H:i', $model->finished_at) : '-----' ?></div>
        </div>
    </div>

    <!-- для ПК -->
    <div class="col-md-6 col-xs-12 hidden-xs hidden-sm visible-md-block visible-lg-block">
        <p>
            <b class="type"><?= $model->collection ?></b>
        </p>
        <?php
        if (empty($images)) {
            ?><p class="no-images">Нет эскизов</p><?php
        } else {
            ?><h4>Эскизы</h4><?php
        }
        foreach (['k1', 'k2'] as $key) {
            if (isset($images[$key])) {
                ?><div class="image"><img src="<?= $images[$key] ?>" alt=""/></div><?php
            }
            if (isset($planDescription[$key])) {
                ?><div class="plan-descr"><?= $planDescription[$key] ?></div><?php
            }
            if (isset($drawsDXF[$key])) {
                ?><div class="download-link">
                <a href="<?= $drawsDXF[$key][1] ?>" title="Скачать" target="_blank"><?= $drawsDXF[$key][0] ?> <i class="fa fa-download" aria-hidden="true"></i></a>
                </div><?php
            }
            if (isset($drawsAI[$key])) {
                ?><div class="download-link">
                <a href="<?= $drawsAI[$key][1] ?>" title="Скачать" target="_blank"><?= $drawsAI[$key][0] ?> <i class="fa fa-download" aria-hidden="true"></i></a>
                </div><?php
            }
            echo '<hr>';
        }
        if (!empty($logs)) {
            ?><h5>Журнал событий</h5>
            <table class="logs-table table-striped">
                <?php foreach ($logs as $log) { /* @var $log \app\models\Log */ ?>
                    <tr>
                        <td><?= date('d.m.Y H:i', $log->created_at) ?></td>
                        <td><?= $log->username ?> изменил статус на</td>
                        <td><?= '<span class="status-' . $log->new_status . '">' . Job::getStatusCaption($log->new_status) . '</span>' ?></td>
                    </tr>
                <?php } ?>
            </table>
            <?php
        }
        ?>
    </div>
    <div class="col-md-6 col-xs-12 hidden-xs hidden-sm visible-md-block visible-lg-block">
        <div class="details">
            <h4>Статус</h4>
            <div class="status-selector-wrap" data-job_id="<?= $model->id ?>" data-status_url="<?= Url::toRoute(['erp/update-status']) ?>">
                <div class="select-status <?= ($user->hasRole('superadmin') || $user->hasRole('admin')) ? 'selector' : '' ?>">
                    <?php
                    if (!$user->hasRole('superadmin') && !$user->hasRole('admin')) {
                        ?><span class="big-status status-<?= $model->status ?>"><?= Job::getStatusCaption($model->status) ?></span><?php
                    } else {
                        foreach (Job::getStatuses() as $key => $title) {
                            ?><a href="#" data-status="<?= $key ?>" class="big-status status-<?= $key ?> <?= ($model->status == $key ? 'selected' : 'hide') ?>">
                            <?= $title ?>
                            </a><?php
                        }
                    }
                    ?>
                </div>
            </div>
            <h4>Deadline</h4>
            <div class="value"><?= !empty($model->deadline) ? date('d.m.Y', $model->deadline) : '' ?></div>

            <h4>Клиент</h4>
            <div class="value"><?= !empty($model->client) ? $model->client : 'не указан' ?></div>

            <h4>Дата поступления</h4>
            <div class="value"><?= !empty($model->created_at) ? date('d.m.Y H:i', $model->created_at) : '-----' ?></div>

            <h4>Дата начала работ</h4>
            <div class="value"><?= !empty($model->started_at) ? date('d.m.Y H:i', $model->started_at) : '-----' ?></div>

            <h4>Дата завершения</h4>
            <div class="value"><?= !empty($model->finished_at) ? date('d.m.Y H:i', $model->finished_at) : '-----' ?></div>

            <h4>Описание</h4>
            <div class="value"><?= !empty($model->description) ? $model->description : '-----' ?></div>
        </div>
    </div>

</div>
