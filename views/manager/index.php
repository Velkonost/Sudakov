<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use app\assets\DiagramAsset;
use app\assets\ManagerAsset;
use app\assets\AirAsset;

AirAsset::register($this);
DiagramAsset::register($this);
ManagerAsset::register($this);
/* @var $this yii\web\View */
/* @var $searchModel app\models\ManagerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$buttons = [
    'today' => 'Сегодня',
    'yesterday' => 'Вчера',
    'week' => 'Неделя',
    'month' => 'Месяц',
    '3month' => '3 Месяца',
    'year' => 'Год',
];

$groupDropList = [
    'gr_day' => 'день',
    'gr_3days' => 'три дня',
    'gr_week' => 'неделя',
    'gr_month' => 'месяц',
];

$infoBlockData = $statisticsData;
$this->title = 'Managers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row intro-logo">
    <div class="col-xs-12">
        <a href="<?= Yii::$app->homeUrl ?>" title="">
            <img src="/images/index/logo-intro-sistem.jpg">
        </a>
    </div>
</div>

<div class="manager-index">
    <div class="row home-tails">
        <?php if ($user->hasRole(['superadmin', 'manager-payment'])) { ?>
            <div class="col col-xs-6 col-sm-2">
                <a class="tail tail-1" href="<?= Url::toRoute(['lead/add']) ?>" title="Внести лид">
                    &nbsp;
                </a>
            </div>
        <?php } ?>
        <?php if ($user->hasRole(['superadmin', 'manager-payment', 'acc_manager'])) { ?>
            <div class="col col-xs-6 col-sm-2">
                <a class="tail tail-2" href="<?= Url::toRoute(['payment/index']) ?>" title="Счета">
                    &nbsp;
                </a>
            </div>
        <?php } ?>
        <?php if ($user->hasRole(['superadmin', 'admin', 'worker', 'acc_manager'])) { ?>
            <div class="col col-xs-6 col-sm-2">
                <a class="tail tail-3" href="<?= Url::toRoute(['erp/index']) ?>" title="Производство">
                    &nbsp;
                </a>
            </div>
        <?php } ?>
        <?php if ($user->hasRole(['superadmin', 'buh'])) { ?>
            <div class="col col-xs-6 col-sm-2">
                <a class="tail tail-4" href="<?= Url::toRoute(['money/index']) ?>" title="Фин. мониторинг">
                    &nbsp;
                </a>
            </div>
        <?php } ?>
        <?php if ($user->hasRole('superadmin')) { ?>
            <div class="col col-xs-6 col-sm-2">
                <a class="tail tail-5" href="<?= '#' //Url::toRoute(['money/index']) ?>" title="подпись">
                    &nbsp;
                </a>
            </div>
        <?php } ?>
        <?php if ($user->hasRole('superadmin')) { ?>
            <div class="col col-xs-6 col-sm-2">
                <a class="tail tail-6" href="<?= '#' //Url::toRoute(['money/index']) ?>" title="подпись">
                    &nbsp;
                </a>
            </div>
        <?php } ?>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <h2>Статистика по менеджерам</h2>

    <?php if ($user->hasRole(['superadmin'])) { ?>
        <!-- Diagram-->
        <div class="row diagram-container" data-url="<?= Url::to(['manager/diagram']) ?>">
            <div class="col-xs-12 col-sm-6 col-md-8">
                <div class="filters row">
                    <div class="col-xs-12 col-md-3">
                        <div class="btn-group calendar-input" role="group">
                            <input value="<?= $calendar ? $period : '' ?>"  id="custom-period" name="custom_period" data-date="<?= $calendar ? $period : '' ?>">
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-9">
                        <div class="btn-group diagram_buttons" role="group" aria-label="...">
                            <div class="btn-group fixed-periods">
                                <?php foreach ($buttons as $id => $name) { ?>
                                    <button type="button" class="btn btn-default period-buttons <?= $id == $period ? 'active' : false ?>" period="<?= $id ?>"><?= $name ?></button>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn grouping-btn btn-default dropdown-toggle diagram-dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                день <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <?php foreach($groupDropList as $id => $item) { ?>
                                    <li><a href="javascript:void(0)" class="group_by" id="group_by_<?= $id ?>"><?= $item ?></a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="main_chart">

                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class=" row">

                    <div class="col-xs-6 caption"><a  href="<?= Url::toRoute(['site/']) ?>">Основные данные</a></div>

                    <div class="col-xs-4 caption"><a  href="#">Менеджеры</a></div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="main-page-right_block-caption row">
                    <div class="col-xs-6"></div>
                    <div class="fact col-xs-2 caption">факт</div>
                    <div class="col-xs-2"></div>
                    <div class="plan col-xs-2 caption">план</div>
                </div>
                <!-- 1 block -->
                <form id="right_block_form" data-url="<?= Url::to(['manager/get-stat-info']) ?>">
                    <?php $i = 0;
                    foreach ($infoBlockData as $type => $data) { ?>
                        <div class="main-page-right_block">
                            <input type="checkbox" class="caption-checkbox" id="diagram_param_caption_<?= $type ?>"/>
                            <div class="main-page-right_block-header bg-color-<?= $type ?>">
                                <?= $data['label'] ?> <i class="fa fa-caret-down" aria-hidden="true"></i>
                                <?php if ($type == 'cities') { ?>
                                    <div class="main-page-right_block-header-citiesLids">Лиды</div>
                                    <div class="main-page-right_block-header-citiesTrade">Продажи</div>
                                <?php } ?>
                            </div>
                            <div class="main-page-right_block-body">
                                <?php
                                foreach ($data['rows'] as $row_key => $row) {
                                    if (isset($row['for_day'])) { $i++;
                                        ?>
                                        <div class="main-page-right_block-body-line row">
                                            <div class="main-page-right_block-body-line-label col-xs-6">
                                                <div class="main-page-right_block-body-line-label-name id-<?= $i?>">
                                                    <input type="checkbox" class="mainPage-rightBlock-body-Checkbox ch-<?=$i?> cb-<?= $type ?>" value="<?= $type ?>_<?= $row_key ?>"
                                                           name="<?= $type ?>_<?= $row_key ?>"
                                                           id="diagram_item_params_<?= $type ?>_<?= $row_key ?>"
                                                           color ="<?= $i ?>"
                                                    />
                                                    <span><?= $row['name'] ?></span>
                                                </div>
                                                <div class="main-page-right_block-body-line-label-comments">
                                                    <div>Среднее за период: <span class="av_<?= $type ?>_<?= $row_key ?>"><?= $row['for_day'] ?></span></div>
                                                    <div>Всего за 30 дней: <span class=""><?= $row['for30days'] ?></span></div>
                                                    <?php if ($type == 'money' && $row_key == 'summary') { ?>
                                                        <div >1я оплата: <span class="fv_summary_first_payment"><?= $row['first_payments'] ?></span></div>
                                                        <div >2я оплата: <span class="fv_summary_second_payment"><?= $row['second_payments'] ?></span></div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="main-page-right_block-body-line-fact col-xs-2">
                                                <div class="fact-value fv_<?= $type ?>_<?= $row_key ?>">
                                                    0
                                                </div>
                                            <span class="main-page-right_block-body-line-fact-status fc_<?= $type ?>_<?= $row_key ?>">
                                                <?= $row['fact']['change'] ?>
                                            </span>
                                            </div>
                                            <div class="main-page-right_block-body-line-percent ratio_<?= $type ?>_<?= $row_key ?> col-xs-2"><?= $row['ratio'] ?></div>
                                            <?php if ($type != 'cities') { ?>
                                                <div class="main-page-right_block-body-line-plan col-xs-2"><?= $row['plan'] ?></div>
                                            <?php  } else { ?>
                                                <div class="main-page-right_block-body-line-fact col-xs-2">
                                                    <div class="fact-value fpv_<?= $type ?>_<?= $row_key ?>">
                                                        0
                                                    </div>
                                                <span class="main-page-right_block-body-line-fact-status fpc_<?= $type ?>_<?= $row_key ?>">
                                                        <?= $row['plan']['change'] ?>
                                                    </span>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    <?php } ?>
                </form>
                <!-- end one block-->
            </div>
        </div>
    <?php } ?>

</div>
