<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $models \app\models\Feedback */
/* @var $pagination \yii\data\Pagination */

$this->title = 'Отзывы клиентов';
?>
<div class="feedback-index">

    <h1 class="text-muted"><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <?php foreach ($feedbacks as $feedback) { ?>

            <div class="col-md-8 col-xs-12">
                <hr /><hr />
            </div>

            <div class="col-md-6">

                <h4>Отзыв</h4>
                <p><?php echo $feedback->text; ?></p>

                <hr />

                <h4>Эскиз</h4>
                <img style="width: 100%; border: 1px solid gray" src="<?php echo $feedback->thumbnail; ?>" alt="">
            </div>

            <div class="col-md-6">

                <h5 class="text-muted">Телефон</h5>
                <div style="font-size: 18px"><?= $feedback->phone ?></div>

                <h5 class="text-muted">Ссылка на сделку</h5>
                <div style="font-size: 18px"><a href="https://jbyss.amocrm.ru/leads/detail/<?= $feedback->ext_id ?>" target="_blank">https://jbyss.amocrm.ru/leads/detail/<?= $feedback->ext_id; ?></a></div>

                <h5 class="text-muted">Дата отзыва</h5>
                <div style="font-size: 18px"><?php echo date('d.m.Y', $feedback->date); ?></div>

                <h5 class="text-muted">Клиент</h5>
                <div style="font-size: 18px;"><?php echo $feedback->fio; ?></div>

                <h5 class="text-muted">Бюджет финальный</h5>
                <div style="font-size: 18px;"><?php echo $feedback->budget; ?></div>

            </div>

        <?php } ?>

    </div>
    <div class="row">
        <div class="col-xs-12">
            <?= \yii\widgets\LinkPager::widget(['pagination' => $pagination]) ?>
        </div>
    </div>


</div>
