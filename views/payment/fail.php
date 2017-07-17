<?php
/**
 * Fail page
 *
 * @var $message string
 */
 
use app\assets\PaymentAsset;
PaymentAsset::register($this);

?>
<div class="well">
    <div class="header">
        <h1 class="text-muted">Ошибка</h1>
    </div>
    <div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>  <?= $message ?></div>
</div>
