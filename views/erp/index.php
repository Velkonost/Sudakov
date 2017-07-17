
<?php

use yii\grid\GridView;
use yii\helpers\Url;
use app\models\Job;
use yii\helpers\Html;
use app\assets\ErpAsset;

use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $models app\models\Job[] */
/* @var $user app\models\User */

ErpAsset::register($this);

$this->title = 'Заявки';
$hideAmo = ($user->hasRole('superadmin') || $user->hasRole('acc_manager')) ? '' : 'hide';
$superAmo = $user->hasRole('superadmin') ? true : false;
$linkParams = $_GET;
$linkParams[0] = 'erp/index'

?>
<?php
if($superAmo){
    ?>
    <table class="job-table">
    <tr>
        <th>Сейчас в производстве -  </th>
        <th> &nbsp <?php echo $countjobs ?> сделок</th>
    </tr>
        <tr>
            <th colspan="2">В производстве по статусам:  </th>
        </tr>
        <tr>
            <?php foreach($jobsstatuscount as $key => $value){ ?>
            <th class="col-status group-last"> <?php echo $key ?> - <?php echo $value ?></th>
            <?php } ?>
        </tr>
    </table>
    <?php
}
?>
<div class="job-index">
    <form id="job-search-form" action="" method="get">
    <?= Html::hiddenInput(\Yii::$app->getRequest()->csrfParam, \Yii::$app->getRequest()->getCsrfToken(), []) ?>
    <table class="job-table">
        <tr class="header">
            <th class="col-deadline col-full light-header"><div>Deadline -</div></th>
            <th class="col-deadline-min col-min hide" rowspan="2000">
                <div class="box-40">&nbsp;</div>
                <div class="col-wrap">
                    <div>Deadline +</div>
                </div>
            </th>
            <th class="col-lead col-full" colspan="<?= empty($hideAmo) ? '4' : '2' ?>"><div>Сделки -</div></th>
            <th class="col-lead-min col-min hide" rowspan="2000">
                <div class="box-40">&nbsp;</div>
                <div class="col-wrap">
                    <div>Сделки +</div>
                </div>
            </th>
            <th class="col-status col-full"><div>Статусы -</div></th>
            <th class="col-status-min col-min hide" rowspan="2000">
                <div class="box-40">&nbsp;</div>
                <div class="col-wrap">
                    <div>Статусы +</div>
                </div>
            </th>
            <th class="col-dates col-full" colspan="2"><div>Даты -</div></th>
            <th class="col-dates-min col-min hide" rowspan="2000">
                <div class="box-40">&nbsp;</div>
                <div class="col-wrap">
                    <div>Даты +</div>
                </div>
            </th>
            <th class="col-prints col-full" colspan="1"><div>Печать -</div></th>
            <th class="col-prints-min col-min hide" rowspan="2000">
                <div class="box-40">&nbsp;</div>
                <div class="col-wrap">
                    <div>Печать -</div>
                </div>
            </th>

            <th class="col-adminchek"  colspan="1"><div>Админ</div></th>
            <th class="col-space" rowspan="2000" width="*"><div>&nbsp;</div></th>
        </tr>
        <tr class="labels">
            <th class="col-deadline group-last">
                <div>
                    <?php
                    $direction = (@$_GET['direction']=='ASC' && @$_GET['sort']=='deadline') ? 'DESC' : 'ASC';
                    $arrow = '';
                    if (@$_GET['sort'] == 'deadline') {
                        $arrow = ($direction=='DESC') ? 'fa fa-arrow-down' : 'fa fa-arrow-up';
                    }
                    $params = ['sort' => 'deadline', 'direction' => $direction] + $linkParams;
                    echo Html::a('Deadline <i class="' . $arrow . '"></i>', $params, ['class' => 'sort']);
                    ?>
                </div>
            </th>
            <th class="col-lead col-lead-collection">
                <div>
                    <?php
                    $direction = (@$_GET['direction']=='ASC' && @$_GET['sort']=='ext_id') ? 'DESC' : 'ASC';
                    $arrow = '';
                    if (@$_GET['sort'] == 'ext_id') {
                        $arrow = ($direction=='DESC') ? 'fa fa-arrow-down' : 'fa fa-arrow-up';
                    }
                    $params = ['sort' => 'ext_id', 'direction' => $direction] + $linkParams;
                    echo Html::a('ID <i class="' . $arrow . '"></i>', $params, ['class' => 'sort']);
                    ?>
                </div>
            </th>
            <th class="col-lead col-lead-collection">
                <div>
                    <?php
                    $direction = (@$_GET['direction']=='ASC' && @$_GET['sort']=='collection') ? 'DESC' : 'ASC';
                    $arrow = '';
                    if (@$_GET['sort'] == 'collection') {
                        $arrow = ($direction=='DESC') ? 'fa fa-arrow-down' : 'fa fa-arrow-up';
                    }
                    $params = ['sort' => 'collection', 'direction' => $direction] + $linkParams;
                    echo Html::a('Коллекция <i class="' . $arrow . '"></i>', $params, ['class' => 'sort']);
                    ?>
                </div>
            </th>
            <th class="col-lead col-lead-amo <?= $hideAmo ?>">
                <div>CRM</div>
            </th>
            <th class="col-lead col-lead-name group-last">
                <div>
                    <?php
                    $direction = (@$_GET['direction']=='ASC' && @$_GET['sort']=='name') ? 'DESC' : 'ASC';
                    $arrow = '';
                    if (@$_GET['sort'] == 'name') {
                        $arrow = ($direction=='DESC') ? 'fa fa-arrow-down' : 'fa fa-arrow-up';
                    }
                    $params = ['sort' => 'name', 'direction' => $direction] + $linkParams;
                    echo Html::a('Название сделки <i class="' . $arrow . '"></i>', $params, ['class' => 'sort']);
                    ?>
                </div>
            </th>
            <th class="col-status group-last">
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
            <th class="col-dates">
                <div>
                    <?php
                    $direction = (@$_GET['direction']=='ASC' && @$_GET['sort']=='created_at') ? 'DESC' : 'ASC';
                    $arrow = '';
                    if (@$_GET['sort'] == 'created_at') {
                        $arrow = ($direction=='DESC') ? 'fa fa-arrow-down' : 'fa fa-arrow-up';
                    }
                    $params = ['sort' => 'created_at', 'direction' => $direction] + $linkParams;
                    echo Html::a('Дата<br>добавления <i class="' . $arrow . '"></i>', $params, ['class' => 'sort']);
                    ?>
                </div>
            </th>
            <th class="col-dates group-last">
                <div>
                    <?php
                    $direction = (@$_GET['direction']=='ASC' && @$_GET['sort']=='finished_at') ? 'DESC' : 'ASC';
                    $arrow = '';
                    if (@$_GET['sort'] == 'finished_at') {
                        $arrow = ($direction=='DESC') ? 'fa fa-arrow-down' : 'fa fa-arrow-up';
                    }
                    $params = ['sort' => 'finished_at', 'direction' => $direction] + $linkParams;
                    echo Html::a('Дата<br>завершения <i class="' . $arrow . '"></i>', $params, ['class' => 'sort']);
                    ?>
                </div>
            </th>
            <th class="col-prints group-last"><div><input type="checkbox" name="printjob"  class="chk-all"/>&nbsp;<img src="images/printjob.png" onclick="getCheckedBoxes('print_chek');"></div></th>
            <?php if ($user->hasRole('superadmin')) { ?>
                <th class="col-operations"><div>&nbsp;</div></th>
            <th class="col-operations"><div>&nbsp;</div></th>
            <?php } ?>
        </tr>
        <tr class="filters">
            <th class="col-deadline group-last">
                <div><input type="text" class="form-control" name="JobSearch[deadline]" value="<?= @$_GET['JobSearch']['deadline'] ?>"></div>
            </th>
            <th class="col-lead">
                <div><input type="text" class="form-control" name="JobSearch[ext_id]" value="<?= @$_GET['JobSearch']['ext_id'] ?>"></div>
            </th>
            <th class="col-lead">
                <div><input type="text" class="form-control" name="JobSearch[collection]" value="<?= @$_GET['JobSearch']['collection'] ?>"></div>
            </th>
            <th class="col-lead <?= $hideAmo ?>"><div>&nbsp;</th>
            <th class="col-lead group-last">
                <div><input type="text" class="form-control" name="JobSearch[name]" value="<?= @$_GET['JobSearch']['name'] ?>"></div>
            </th>
            <th class="col-status group-last">
                <div>
                <?= Html::dropDownList('JobSearch[status]', @$_GET['JobSearch']['status'],
                    Job::getStatuses(true), ['class'=>'form-control', 'multiple' => 'multiple', 'id' => 'jobsearch-status']) ?>
                </div>
            </th>
            <th class="col-dates">
                <div><input type="text" class="form-control" name="JobSearch[created_at]" value="<?= @$_GET['JobSearch']['created_at'] ?>"></div>
            </th>
            <th class="col-dates group-last">
                <div><input type="text" class="form-control" name="JobSearch[finished_at]" value="<?= @$_GET['JobSearch']['finished_at'] ?>"></div>
            </th>
            <th class="col-prints"><div>&nbsp;</div></th>
            <th class="col-operations"><div>&nbsp;</div></th>
            <?php if ($user->hasRole('superadmin')) { ?>
            <th class="col-operations"><div>&nbsp;</div></th>
            <?php } ?>
        </tr>
        <?php foreach($models as $k => $model) { ?>
            <tr class="tr-row <?= $k%2==0 ? 'row-1' : 'row-2' ?>">
                <td class="col-deadline group-last">
                    <div>
                        <span class="date"><?= (empty($model->deadline) ? '---' : date("d.m.Y", $model->deadline)) ?></span>
                    </div>
                </td>
                <td class="col-lead col-text-value">
                    <div>
                        <?= '<a href="' . Url::toRoute(['erp/view', 'id' => $model->id]) . '" title="">' . $model->ext_id . '</a>'; ?>
                    </div>
                </td>
                <td class="col-lead col-text-value">
                    <div>
                        <?= '<a href="' . Url::toRoute(['erp/view', 'id' => $model->id]) . '" title="">' . $model->collection . '</a>'; ?>
                    </div>
                </td>
                <td class="col-lead <?= $hideAmo ?>">
                    <div>
                        <?= '<a href="https://jbyss.amocrm.ru/leads/detail/' . $model->ext_id
                        . '" title="Перейти в сделку AMOCRM" target="_blank">'
                        . '<img src="/images/money_arr.png"></a>' ?>
                    </div>
                </td>
                <td class="col-lead col-text-value group-last">
                    <div>
                        <?= '<a href="' . Url::toRoute(['erp/view', 'id' => $model->id]) . '" title="">' . $model->name . '</a>'; ?>
                    </div>
                </td>
                <td class="col-status group-last">
                    <div><?php
                        $user = Yii::$app->user->identity;
                        $html = '<div class="status-selector-wrap" data-job_id="'
                            . $model->id.'" data-status_url="' . Url::toRoute(['erp/update-status']) . '">'
                            . '<div class="select-status '
                            . (($user->hasRole('superadmin') || $user->hasRole('admin')) ? 'selector' : '').'">';
                        if (!$user->hasRole('superadmin') && !$user->hasRole('admin')) {
                            $html .= '<span class="status-'.$model->status.'">'.Job::getStatusCaption($model->status).'</span>';
                        } else {
                            foreach (Job::getStatuses() as $key => $title) {
                                $html .= '<a href="#" data-status="' . $key . '" class="status-sm status-' . $key . ' '
                                    . ($model->status == $key ? 'selected' : 'hide') . '">'
                                    . $title . '</a>';
                            }
                        }
                        $html .= '</div></div>';
                        echo $html;
                    ?></div>
                </td>
                <td class="col-dates">
                    <div><?= empty($model->created_at) ? '---' : '<span class="date">' . date("d.m.Y", $model->created_at)
                        . '<br><i class="time">' . date("H:i", $model->created_at) . '</span>'
                    ?></div>
                </td>
                <td class="col-dates group-last">
                    <div><?= empty($model->finished_at) ? '---' : '<span class="date">' . date("d.m.Y", $model->finished_at)
                        . '<br><i class="time">' . date("H:i", $model->finished_at) . '</span>'
                    ?></div>
                </td>
                <td class="col-prints group-last">
                    <div><input type="checkbox" id="print_chek" class="print_chek" name="printjob" value="<?php echo $model->id ?>"/> <a target="_blank" href="<?php echo Url::toRoute(['erp/printjob', 'id' => $model->id])?>"><img src="images/printjob.png"></a></div>
                </td>
                <td class="col-adminchek group-last">
                    <div><input type="checkbox" id="adminchek" data-adm_id="<?php echo $model->id ?>" data-adm_url="<?php echo Url::toRoute(['erp/update-adminchek']) ?>" class="adminchek" name="adminchek" <?php if($model->adminchek == 1) echo 'checked';?>/> </div>
                </td>
                <?php if ($user->hasRole('superadmin')) { ?>
                <td class="col-operations">
                    <div>
                        <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::toRoute(['erp/delete', 'id' => $model->id]), [
                            'title' => Yii::t('yii', 'Удаление'),
                            'aria-label' => Yii::t('yii', 'Delete'),
                            'data-confirm' => Yii::t('yii', 'Удалить выбранную заявку?'),
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
    <?=LinkPager::widget([
        'pagination' => $pages,
    ]);?>
</div>
<?php

