<?php

use app\assets\AppAsset;

AppAsset::register($this);

/* @var $this yii\web\View */
/* @var $statuses array */

$this->title = 'Reload AMO Leads Statuses';

?>
<div class="amo-statuses row">
    <div class="col-xs-12">
        <h1><?= $this->title ?></h1>
    </div>

    <div class="col-xs-12">
        <ul style="display: block; list-style: none; width: 300px;">
        <?php
        foreach ($statuses as $status) {
            ?><li style="background-color: <?= $status['color'] ?>;padding: 4px;"><?= $status['label'] ?></li><?php
        }
        ?>
        </ul>
    </div>

</div>
