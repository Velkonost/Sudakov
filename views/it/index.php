<?php
/* @var $this yii\web\View */
/* @var $managers app\models\QueueLeads[] */

/* @var $user app\models\User */
/* @var $method string */

use app\assets\ItAsset;
use yii\helpers\Url;

ItAsset::register($this);

echo $this->render('/site/main_menu', ['user' => $user]);

?>
<ul class="it-tabs nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="<?= Url::to(['/it'])?>" aria-controls="home" role="tab" data-toggle="tab">Пользователи AMOCRM</a></li>
    <!--<li role="presentation"><a href="<?= Url::to(['/it/end'])?>" aria-controls="profile" role="tab" data-toggle="tab">Страница 2</a></li>-->
    <li id="saved_status" class="hide">Сохранено</li>
</ul>

<form action="<?= Url::toRoute(['it/update-managers']) ?>" method="get">
    <input type="submit" value="Обновить список менеджеров"
           class="submitBtn" id="it-memberUpload" style="float: right;"/>
</form>

<form id="it-memberAllocationForm" data-url="<?= Url::toRoute(['it/manager-options-save']) ?>">

    <table class="managersOptions">
        <tr>
            <th>Имя</th>
            <th>Менеджер</th>
            <th>Распределение заявок</th>
            <th>Коефициент распределения</th>
        </tr>
        <?php foreach($managers as $manager){  ?>
            <tr class="it-managerFields" id="user_id-<?= $manager->manager_id ?>">
                <td><?= $manager->user_name; ?></td>
                <td><input class="it-isManager" type="checkbox" name="is_manager" <?= $manager->is_manager ? 'checked' : '' ?>></td>
                <td><input class="it-memberAllocation" type="checkbox" name="member_allocation" <?= $manager->member_allocation ? 'checked' : '' ?>></td>
                <td><input class='it-coefficient' type="text" name="coefficient"' value='<?= $manager->coefficient ?>'></td>
            </tr>
        <?php  } ?>
    </table>

    <!-- <input type="button" value="Изменить" class="submitBtn"> -->
</form>

<form id="it-methodAssigmentChecks">
    <div class="it-methodAssigmentChecks-label">Метод распределения новых заявок</div>
    <div>
        <label>
            <input id="it-methodAssigmentCheck-flow" name="it-methodAssigmentCheck"
                   value="flow" type="radio" <?= $method == 'flow' ? 'checked' : '' ?> />
            Поочерёдное
        </label>
    </div>
    <div>
        <label>
            <input id="it-methodAssigmentCheck-co" name="it-methodAssigmentCheck"
                   value="co" type="radio" <?= $method == 'co' ? 'checked' : '' ?> />
            Поочерёдное с коэффициентом
        </label>
    </div>
</form>

