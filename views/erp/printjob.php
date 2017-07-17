
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

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Tables</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
    <link rel="stylesheet" href="/css/printjob.css">
</head>
<body>
<div class="wrap">
<?php foreach($lead as $next){?>

    <div class="item">
        <table class="main">
            <col class="main-col1">
            <col class="main-col2">
            <col class="main-col3">
            <tr class="big">
                <td>№</td>
                <td><?php echo $next['id']?></td>
                <td rowspan="5" class="ok"></td>
            </tr>
            <tr>
                <td>Дедлайн</td>
                <td><?php echo date('d.m',strtotime($next['custom_fields']['952428']['values'][0]['value']))?></td>
            </tr>
            <tr>
                <td>Коллекция</td>
                <td><?php echo $next['custom_fields']['1286504']['values'][0]['value']?></td>
            </tr>
            <tr>
                <td>Количество</td>
                <td><?php echo $next['custom_fields']['1286745']['values'][0]['value']?></td>
            </tr>
            <tr>
                <td>Буквы / лого</td>
                <td><?php echo $next['custom_fields']['1288284']['values'][0]['value']?></td>
            </tr>
        </table>
        <table class="secondary osnova">
            <col class="col1">
            <col class="col2">
            <col class="col3">
            <col class="col4">
            <tr class="first">
                <td rowspan="6" class="grey-bg">
                    <div class="vertical-text">Основа</div>
                </td>
                <td>Металл</td>
                <td><?php echo $next['custom_fields']['1288212']['values'][0]['value']?></td>
                <td rowspan="3"></td>
            </tr>
            <tr class="other">
                <td>Покрытие</td>
                <td><?php echo $next['custom_fields']['1288214']['values'][0]['value']?></td>
            </tr>
            <tr class="other">
                <td>Ножки</td>
                <td><?php echo $next['custom_fields']['1288282']['values'][0]['value']?></td>
            </tr>
            <tr class="other">
                <td>Камень</td>
                <td><?php echo $next['custom_fields']['1288220']['values'][0]['value']?></td>
                <td></td>
            </tr>
            <tr class="other">
                <td>Дерево</td>
                <td><?php echo $next['custom_fields']['1288224']['values'][0]['value']?></td>
                <td></td>
            </tr>
            <tr class="other">
                <td>Эмаль</td>
                <td><?php echo $next['custom_fields']['1288304']['values'][0]['value']?></td>
                <td></td>
            </tr>
        </table>
        <table class="secondary nakladnaya">
            <col class="col1">
            <col class="col2">
            <col class="col3">
            <col class="col4">
            <tr class="first">
                <td rowspan="6" class="grey-bg">
                    <div class="vertical-text">Накладная</div>
                </td>
                <td>Тип</td>
                <td><?php echo $next['custom_fields']['1288286']['values'][0]['value']?></td>
                <td rowspan="3"></td>
            </tr>
            <tr class="other">
                <td>Металл</td>
                <td><?php echo $next['custom_fields']['1288222']['values'][0]['value']?></td>
            </tr>
            <tr class="other">
                <td>Покрытие</td>
                <td><?php echo $next['custom_fields']['1288226']['values'][0]['value']?></td>
            </tr>
            <tr class="other">
                <td>Камни</td>
                <td><?php echo $next['custom_fields']['1288228']['values'][0]['value']?></td>
                <td></td>
            </tr>
            <tr class="other">
                <td>Эмаль</td>
                <td><?php echo $next['custom_fields']['1288306']['values'][0]['value']?></td>
                <td></td>
            </tr>
        </table>
        <table class="secondary dopolneniya">
            <col class="col1">
            <col class="col2">
            <col class="col3">
            <col class="col4">
            <tr class="first">
                <td rowspan="6" class="grey-bg">
                    <div class="vertical-text">Дополнения</div>
                </td>
                <td>Нестандарт вставки</td>
                <td><?php echo $next['custom_fields']['1288230']['values'][0]['value']?></td>
                <td></td>

            </tr>
            <tr class="other">
                <td>Гравировка</td>
                <td><?php echo $next['custom_fields']['1288288']['values'][0]['value']?></td>
            </tr>
            <tr class="other">
                <td>Коммент</td>
                <td><?php if(isset($next['custom_fields']['1286486']['values'][0]['value'])){?>
                        <?php echo $next['custom_fields']['1286486']['values'][0]['value']?>
                    <?php }?></td>
            </tr>

        </table>
    </div>
  
 <?php }?>
 </div>
</body>
</html>