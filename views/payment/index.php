<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Payment;
use app\assets\PaymentAsset;
use yii\widgets\LinkPager;

PaymentAsset::register($this);

/* @var $this yii\web\View */
/* @var $models app\models\Payment[] */
/* @var $user app\models\User */
/* @var $pagination \yii\data\Pagination */

$this->title = 'Payments';

$hideAmo = $user->hasRole('superadmin') ? '' : 'hide';

$linkParams = $_GET;
$linkParams[0] = 'payment/index'

//Клиент + ссылка на сделку в AmoCRM = сворачивается
//Тип счета + Сумма + Статус + Дата оплаты = сворачивается
//Дата создания + Менеджер + Ссылка на оплату = сворачивается

?>
<div class="payment-index">
    <form id="payment-search-form" action="" method="get">
        <?= Html::hiddenInput(\Yii::$app->getRequest()->csrfParam, \Yii::$app->getRequest()->getCsrfToken(), []) ?>
        <table class="payment-table">
            <tr class="header">
                <th class="col-lead col-full" colspan="<?= empty($hideAmo) ? '2' : '1' ?>"><div>Сделки -</div></th>
                <th class="col-lead-min col-min hide" rowspan="2000">
                    <div class="box-40">&nbsp;</div>
                    <div class="col-wrap">
                        <div>Сделки +</div>
                    </div>
                </th>
                <th class="col-account col-full" colspan="4"><div>Оплаты -</div></th>
                <th class="col-account-min col-min hide" rowspan="2000">
                    <div class="box-40">&nbsp;</div>
                    <div class="col-wrap">
                        <div>Оплаты +</div>
                    </div>
                </th>
                <th class="col-manager col-full" colspan="3"><div>Инфо -</div></th>
                <th class="col-manager-min col-min hide" rowspan="2000">
                    <div class="box-40">&nbsp;</div>
                    <div class="col-wrap">
                        <div>Инфо +</div>
                    </div>
                </th>
                <?php if ($user->hasRole('superadmin')) { ?>
                    <th class="col-operations"><div>&nbsp;</div></th>
                <?php } ?>
                <th class="col-space" rowspan="2000" width="*"><div>&nbsp;</div></th>
            </tr>
            <tr class="labels">
                <th class="col-lead col-lead-client <?= empty($hideAmo) ? '' : 'group-last' ?>">
                    <div>
                        <?php
                        $direction = (@$_GET['direction']=='ASC' && @$_GET['sort']=='client') ? 'DESC' : 'ASC';
                        $arrow = '';
                        if (@$_GET['sort'] == 'client') {
                            $arrow = ($direction=='DESC') ? 'fa fa-arrow-down' : 'fa fa-arrow-up';
                        }
                        $params = ['sort' => 'client', 'direction' => $direction] + $linkParams;
                        echo Html::a('Клиент <i class="' . $arrow . '"></i>', $params, ['class' => 'sort']);
                        ?>
                    </div>
                </th>
                <th class="col-lead col-lead-amo <?= $hideAmo ?> group-last"><div>CRM</div></th>
                <th class="col-account col-account-type">
                    <div>
                        <?php
                        $direction = (@$_GET['direction']=='ASC' && @$_GET['sort']=='pnum') ? 'DESC' : 'ASC';
                        $arrow = '';
                        if (@$_GET['sort'] == 'pnum') {
                            $arrow = ($direction=='DESC') ? 'fa fa-arrow-down' : 'fa fa-arrow-up';
                        }
                        $params = ['sort' => 'pnum', 'direction' => $direction] + $linkParams;
                        echo Html::a('Тип счета <i class="' . $arrow . '"></i>', $params, ['class' => 'sort']);
                        ?>
                    </div>
                </th>
                <th class="col-account col-account-sum">
                    <div>
                        <?php
                        $direction = (@$_GET['direction']=='ASC' && @$_GET['sort']=='sum') ? 'DESC' : 'ASC';
                        $arrow = '';
                        if (@$_GET['sort'] == 'sum') {
                            $arrow = ($direction=='DESC') ? 'fa fa-arrow-down' : 'fa fa-arrow-up';
                        }
                        $params = ['sort' => 'sum', 'direction' => $direction] + $linkParams;
                        echo Html::a('Сумма <i class="' . $arrow . '"></i>', $params, ['class' => 'sort']);
                        ?>
                    </div>
                </th>
                <th class="col-account col-account-status">
                    <div>
                        <?php
                        $direction = (@$_GET['direction']=='ASC' && @$_GET['sort']=='status') ? 'DESC' : 'ASC';
                        $arrow = '';
                        if (@$_GET['sort'] == 'status') {
                            $arrow = ($direction=='DESC') ? 'fa fa-arrow-down' : 'fa fa-arrow-up';
                        }
                        $params = ['sort' => 'status', 'direction' => $direction] + $linkParams;
                        echo Html::a('Статус <i class="' . $arrow . '"></i>', $params, ['class' => 'sort']);
                        ?>
                    </div>
                </th>
                <th class="col-account col-account-date group-last">
                    <div>
                        <?php
                        $direction = (@$_GET['direction']=='ASC' && @$_GET['sort']=='paid_at') ? 'DESC' : 'ASC';
                        $arrow = '';
                        if (@$_GET['sort'] == 'paid_at') {
                            $arrow = ($direction=='DESC') ? 'fa fa-arrow-down' : 'fa fa-arrow-up';
                        }
                        $params = ['sort' => 'paid_at', 'direction' => $direction] + $linkParams;
                        echo Html::a('Дата<br>оплаты <i class="' . $arrow . '"></i>', $params, ['class' => 'sort']);
                        ?>
                    </div>
                </th>

                <th class="col-manager col-manager-date">
                    <div>
                        <?php
                        $direction = (@$_GET['direction']=='ASC' && @$_GET['sort']=='created_at') ? 'DESC' : 'ASC';
                        $arrow = '';
                        if (@$_GET['sort'] == 'created_at') {
                            $arrow = ($direction=='DESC') ? 'fa fa-arrow-down' : 'fa fa-arrow-up';
                        }
                        $params = ['sort' => 'created_at', 'direction' => $direction] + $linkParams;
                        echo Html::a('Дата<br>создания <i class="' . $arrow . '"></i>', $params, ['class' => 'sort']);
                        ?>
                    </div>
                </th>
                <th class="col-manager col-manager-name">
                    <div>
                        <?php
                        $direction = (@$_GET['direction']=='ASC' && @$_GET['sort']=='manager') ? 'DESC' : 'ASC';
                        $arrow = '';
                        if (@$_GET['sort'] == 'manager') {
                            $arrow = ($direction=='DESC') ? 'fa fa-arrow-down' : 'fa fa-arrow-up';
                        }
                        $params = ['sort' => 'manager', 'direction' => $direction] + $linkParams;
                        echo Html::a('Менеджер <i class="' . $arrow . '"></i>', $params, ['class' => 'sort']);
                        ?>
                    </div>
                </th>
                <th class="col-manager col-manager-link group-last">
                    <div>Ссылка на оплату</div>
                </th>

                <?php if ($user->hasRole('superadmin')) { ?>
                    <th class="col-operations"><div>&nbsp;</div></th>
                <?php } ?>
            </tr>
            <tr class="filters">
                <!-- клиент -->
                <th class="col-lead">
                    <div>
                        <input type="text" class="form-control <?= $hideAmo ? '' : 'group-last' ?>"
                           name="PaymentSearch[client]" value="<?= @$_GET['PaymentSearch']['client'] ?>">
                    </div>
                </th>
                <th class="col-lead <?= $hideAmo ?> group-last"><div>&nbsp;</th>
                <!-- Счет -->
                <th class="col-account">
                    <div>
                        <?= Html::dropDownList('PaymentSearch[pnum]', @$_GET['PaymentSearch']['pnum'],
                            ['0' => 'Все'] + Payment::types(false), ['class' => 'form-control', 'id' => 'payment-pnum']) ?>
                    </div>
                </th>
                <th class="col-account">
                    <div>
                        <input type="text" class="form-control" name="PaymentSearch[sum]" value="<?= @$_GET['PaymentSearch']['sum'] ?>">
                    </div>
                </th>
                <th class="col-account">
                    <div>
                        <?= Html::dropDownList('PaymentSearch[status]', @$_GET['PaymentSearch']['status'],
                            Payment::statuses(), ['class'=>'form-control', 'id' => 'payment-status', 'multiple' => 'multiple']) ?>
                    </div>
                </th>
                <th class="col-account group-last">
                    <div>
                        <input type="text" class="form-control" name="PaymentSearch[paid_at]" value="<?= @$_GET['PaymentSearch']['paid_at'] ?>">
                    </div>
                </th>
                <!-- менеджер (Дата создания + Менеджер + Ссылка на оплату) -->
                <th class="col-manager">
                    <div><input type="text" class="form-control" name="PaymentSearch[created_at]" value="<?= @$_GET['PaymentSearch']['created_at'] ?>"></div>
                </th>
                <th class="col-manager">
                    <div><input type="text" class="form-control" name="PaymentSearch[manager]" value="<?= @$_GET['PaymentSearch']['manager'] ?>"></div>
                </th>
                <th class="col-manager group-last">
                    <div>&nbsp;</div>
                </th>
                <?php if ($user->hasRole('superadmin')) { ?>
                    <th class="col-operations"><div>&nbsp;</div></th>
                <?php } ?>
            </tr>
            <?php foreach($models as $k => $model) { ?>
                <tr class="tr-row <?= $k%2==0 ? 'row-1' : 'row-2' ?>">
                    <!-- клиент -->
                    <td class="col-lead">
                        <div><?php
                            $title = empty($model->client) ? $model->comment : $model->client;
                            if (empty($title)) {
                                echo Html::a('нет данных', ['payment/update', 'id' => $model->id], ['class' => 'link']);
                            } else {
                                echo Html::a($title, ['payment/update', 'id' => $model->id], ['class' => 'link']);
                            }
                            ?>
                        </div>
                    </td>
                    <td class="col-lead group-last">
                        <div>
                            <?= '<a href="https://jbyss.amocrm.ru/leads/detail/' . $model->ext_id
                            . '" title="Перейти в сделку AMOCRM" target="_blank">'
                            . '<img src="/images/money_arr.png"></a>' ?>
                        </div>
                    </td>
                    <!-- Счет (Тип счета + Сумма + Статус + Дата оплаты) -->
                    <td class="col-account <?= $hideAmo ?>">
                        <div>
                            <?php
                            $types = Payment::types();
                            echo $types[ intval($model->pnum) ];
                            ?>
                        </div>
                    </td>
                    <td class="col-account">
                        <div>
                            <?= Html::a($model->sum . ' руб.', ['payment/update', 'id' => $model->id], ['class' => 'link']) ?>
                        </div>
                    </td>
                    <td class="col-account">
                        <div><?php
                            $status = '<span class="label label-primary">Ожидает оплаты</span>';
                            if ($model->status == Payment::STATUS_PAID) {
                                $status = '<span class="label label-success">Оплачено</span>';
                            } else if ($model->status == Payment::STATUS_TO_DELETE) {
                                $status = '<span class="label label-warning">Удалить</span>';
                            }
                            echo $status;
                            ?></div>
                    </td>
                    <td class="col-account group-last">
                        <div><?= empty($model->paid_at) ? '---' : '<span class="date">' . date("d.m.Y", $model->paid_at)
                            . '<br><i class="time">' . date("H:i", $model->paid_at) . '</span>'
                        ?></div>
                    </td>
                    <!-- менеджер (Дата создания + Менеджер + Ссылка на оплату) -->
                    <td class="col-manager">
                        <div><?= empty($model->created_at) ? '---' : '<span class="date">' . date("d.m.Y", $model->created_at)
                                . '<br><i class="time">' . date("H:i", $model->created_at) . '</span>'
                            ?></div>
                    </td>
                    <td class="col-manager">
                        <div><?= $model->manager ?></div>
                    </td>
                    <td class="col-manager group-last">
                        <div>
                            <?php
                            $hash = md5($model->id . '&' . $model->ext_id);
                            $url = Yii::$app->getRequest()->getHostInfo();
                            $url .= \yii\helpers\Url::toRoute(['payment/checkout', 'id' => $model->id . '_' . $model->created_at, 'hash' => $hash]);
                            echo '<a class="link" href="'.$url.'" title=""><i class="fa fa-external-link" aria-hidden="true"></i>&nbsp;http://</a>';
                            ?>
                        </div>
                    </td>

                    <?php if ($user->hasRole('superadmin')) { ?>
                        <td class="col-operations">
                            <div>
                                <?= Html::a('<span class="glyphicon glyphicon-trash"></span>',
                                    Url::toRoute(['payment/delete', 'id' => $model->id]), [
                                    'title' => Yii::t('yii', 'Удаление'),
                                    'aria-label' => Yii::t('yii', 'Delete'),
                                    'data-confirm' => Yii::t('yii', 'Удалить выбранный платеж?'),
                                    'data-method' => 'post',
                                    'data-pjax' => '0',
                                ]); ?>
                            </div>
                        </td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </table>
    </form>

    <?= LinkPager::widget(['pagination' => $pagination]) ?>

</div>
<?php


