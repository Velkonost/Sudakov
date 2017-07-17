<?php
/**
 * Created by PhpStorm.
 * User: coder
 * Date: 19.12.16
 * Time: 18:33
 */
use yii\helpers\Url;
?>

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
<?php if ($user->hasRole(['superadmin', 'admin'])) { ?>
    <div class="col col-xs-6 col-sm-2">
        <a class="tail tail-5" href="<?= Url::toRoute(['storage/index']) ?>" title="подпись">
            &nbsp;
        </a>
    </div>
<?php } ?>
<?php if ($user->hasRole('superadmin')) { ?>
    <div class="col col-xs-6 col-sm-2">
        <a class="tail tail-6" href="<?= Url::toRoute(['/it/index']) ?>" title="подпись2">
            &nbsp;
        </a>
    </div>
<?php } ?>
</div>