<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);

$pageId = Yii::$app->controller->id . '-' . Yii::$app->controller->action->id;
$controller = Yii::$app->controller->id;
$user = Yii::$app->user->identity;

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= 'ru'//Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <script>var BASE_URL = "/<?= ltrim(Yii::$app->getRequest()->getBaseUrl(), '/') ?>";</script>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    if ($pageId != 'site-login') {
        echo $this->render('_top_nav', ['user' => $user]);
    }
    ?>

    <div class="container container-money">
        <?php
        if ($controller == 'user') {
            echo Breadcrumbs::widget([
                'homeLink' => false,
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]);
        }
        ?>

        <?= $content ?>

    </div>
</div>

<footer class="footer">
    <div class="container">

    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
