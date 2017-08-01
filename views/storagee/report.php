<head>
    <meta charset="utf-8">
</head>
<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Things;
use yii\helpers\Url;
use yii\helpers;
use yii\web\helpers\CHtml;
/* @var $this yii\web\View */

$this->title = 'Склад';
$user = Yii::$app->user->identity;

?>
<?php 
if (!$user->hasRole(['admin', 'superadmin'])) { 
    Yii::$app->response->redirect(Url::to(['site/index']));
}
?>
<?php


    $names = ['Щит под дерево с просветом', 'Квадрат под дерево с просветом', 'Круг под дерево с просветом', 'Щит под дерево с орнаментом', 'Квадрат под дерево с орнаментом', 'Круг под дерево с орнаментом', '8 граней с орнаментом', '8 граней с желобом', '8 граней под гравировку', 'Спаси и сохрани с надписью', 'Спаси и сохрани основа с орнаментом', 'Спаси и сохрани под гравировку', 'Щит европа стандартный', 'Щит европа с орнаментом', 'Круг косичка', 'Квадрат косичка', 'Прямоугольная косичка', 'Прямоугольник готика под бриллиант', 'под премиум круглый', 'под премиум квадратный', 'Щит ФСБ', 'Омниа квадрат', 'Омниа круг', 'Щит облегченный', 'Фантом', 'Созвездие круг большой', 'Созвездие фон', 'Круг малый', 'Пупырки', 'под винтажный куб', 'Геральдика под монограмму', 'Геральдика классическая', 'Геральдика ребристая с камнями', 'Геральдика под эмаль со сферами по периметру', 'Геральдика под эмаль с орнаментом по ободку', 'Геральдика Щит и меч', 'Круг орел', 'под премиум круглый', 'под премиум квадратный', 'Лев плоский (царь зверей)', 'Щит под гравировку', 'Лев классический (царь зверей)', 'Лев античный (царь зверей)', 'Тигр (царь зверей)', 'Лис (царь зверей)', 'Бульдог (царь зверей)', 'Волк (царь зверей)', 'Медведь (царь зверей)', '8 граней под гравировку большая', '8 граней под гравировку малая', 'Грани характера под гравировку круглая', 'Грани характера Звери', 'Грани характера Георгий победоносец', 'Грани характера Рыбы', 'Грани характера Оружие', 'Созвездие Круг большой', 'Созвездие Круг малый', 'под винтажный куб', 'Лев плоский (царь зверей)', 'Цельнолитая рефленая', 'малая поворотная', 'Задняя часть малой поворотной ножки', 'Пружина малой поворотной ножки', 'Большая поворотная', 'Задняя часть большой поворотной ножки', 'Пружина большой поворотной ножки'];

    $names2 = ['Фантом (задняя часть с малой поворотной ножкой)','Фантом основа с покрытием','Созвездие (основа + задняя часть с малой поворотной ножкой)','Круг малый  (основа + задняя часть с малой поворотной ножкой)','Щит под дерево с орнаментом (основа + ножка)','Щит под дерево с орнаментом (основа + поворотная ножка)','Круг под дерево с орнаментом (основа + ножка)','Круг под дерево с орнаментом (основа + поворотная ножка)','Квадрат под дерево с орнаментом (основа + ножка)','Квадрат под дерево с орнаментом (основа + поворотная ножка)','Щит под дерево с просветом  (основа + ножка)','Щит под дерево с просветом  (основа + поворотная ножка)','Круг под дерево с просветом (основа + ножка)','Круг под дерево с просветом (основа + поворотная ножка)', 'Квадрат под дерево с просветом (основа + ножка)','Квадрат под дерево с просветом (основа + поворотная ножка)', '8 граней с орнаментом (основа + ножка)', '8 граней с орнаментом (основа + поворотная ножка)','8 граней с орнаментом (основа + ножка)','8 граней с орнаментом (основа + поворотная ножка)', '8 граней с орнаментом (основа + ножка)','8 граней с орнаментом (основа + поворотная ножка)','Щит европа стандартный (основа + ножка)', 'Щит европа стандартный (основа + поворотная ножка)','Щит европа стандартный (основа + ножка)','Щит европа стандартный (основа + поворотная ножка)','Щит европа стандартный (основа + ножка)','Щит европа стандартный (основа + поворотная ножка)','Прямоугольник косичка (основа + ножка)','Прямоугольник косичка (основа + поворотная ножка)', 'Круг косичка (основа + ножка)','Круг косичка (основа + поворотная ножка)', 'Спаси и сохрани с орнаментом (основа + ножка)','Спаси и сохрани с орнаментом (основа + поворотная ножка)','Спаси и сохрани под гравировку (основа + ножка)','Спаси и сохрани под гравировку (основа + поворотная ножка)','Спаси и сохрани с надписью (основа + ножка)','Спаси и сохрани с надписью (основа + поворотная ножка)', 'Премиум квадратный (основа + ножка)','Премиум квадратный (основа + поворотная ножка)', 'Накладка под премиум квадратный (отполированная)','Премиум круглый (основа + ножка)','Премиум круглый (основа + поворотная ножка)','Накладка под премиум круглый (отполированная)', 'Винтажный куб (основа + ножка)','Винтажный куб (основа + поворотная ножка)','Омниа круг (основа + ножка)','Омниа круг (основа + поворотная ножка)', 'Омниа квадрат (основа + ножка)','Омниа квадрат (основа + поворотная ножка)', 'Прямоугольник готика под бриллиант (основа + ножка)', 'Прямоугольник готика под бриллиант (основа + поворотная ножка)'];
?>

<script src="http://code.jquery.com/jquery-latest.min.js"></script>

<style type="text/css">
    .hide {
        display: none;
    }

    .inputTable {
        margin: 0 auto; 
        text-align: left;
        border-collapse: separate; 
        border-spacing: 2px;
        
    }

    .inputTable td {
        background-color: #fff8ca;
        padding-left: 5px;
        padding-right: 5px;

        min-height: 73px;
        max-height: 73px;
        height: 73px;
    }

    .types td img {
        max-width: 110px;
        min-width: 110px;

        min-height: 110px;
        max-height: 110px;   
    }



    .types {
        border-collapse: separate; 
        border-spacing: 1px;
        margin-top: 20px;
        /* margin-left: 8%; */
    }

    .types td{
        font-size: 11px;
        line-height: 12px;
        /* padding-bottom: 20px; */
    }
  
    h2 {
        color: black;
        font-weight: normal;
        margin-bottom: 5px;
        letter-spacing: 3px;
        font-style: normal;

    }
    .type {
        margin-bottom: 20px;
    }

    .wrap_types {
        min-width: 1170px;
        width: 1170px;      


        display: none;
        
        margin-top: 30px;
        width: 100%;
        position: relative;
        left: 0;
    }
    .wrap_names {
        min-width: 1170px;
        width: 1170px;

        display: none;
        
        margin-top: 30px;
        
        position: relative;
        left: 0;
    }

    div[name="grey_table_types"], div[name="grey_table_names"] {

        /* width: 100%; */
        background-color: #f1f2f3;
    }

    td[name="name"], td[name="type_of_name"], td[name="desc"] {
        max-width: 100px;
        
    }

    td[name="name"] {
        height: 37px;
    }

    #arrow {
        display: inline-block;
    }

    #arrow.rotated {
    -webkit-transform : rotate(180deg); 
    -moz-transform : rotate(180deg); 
    -ms-transform : rotate(180deg); 
    -o-transform : rotate(180deg); 
    transform : rotate(180deg); 
    }

    #arroww {
        display: inline-block;
    }

    #arroww.rotated {
        -webkit-transform : rotate(180deg); 
        -moz-transform : rotate(180deg); 
        -ms-transform : rotate(180deg); 
        -o-transform : rotate(180deg); 
        transform : rotate(180deg); 
    }

    .hidden {
        display: none;
    }

    .select_tp {
        padding-left: 0;
        padding-right: 0;
        width: 215px;
        min-width: 215px;
        max-width: 215px;
    }

    #nonselected_type {
        width:215px; 
        min-width: 215px;
        max-width: 215px;
    }
    
    #selectType {
        width:215px;
        text-align: center;
    }

    .in_selected_type {
        display: inline-block;
        max-height: 73px; 
        width: 100%;
    }
    .selected_type_img {
        height: 73px; 
        width: 73px; 
        display: inline-block; 
        vertical-align: top;
    }

    #type_selected{
        margin: 5px;

        width: 130px;
        display: inline-block; 
        font-size: 14px;
        margin-left: 5px;
        line-height: 14px;
    }

    #nonselected_name {
        width:215px; 
        min-width: 215px;
        max-width: 215px;
        text-align: center;
    }


    .select_nm {
        padding-left: 0;
        padding-right: 0;
        width: 215px;
        min-width: 215px;
        max-width: 215px;
    }
    
    #selectName {
        width:215px;
        text-align: center;
    }

    .in_selected_name {
        display: inline-block;
        max-height: 73px; 
        width: 100%;
    }
    .selected_name_img {
        height: 73px; 
        width: 73px; 
        display: inline-block; 
        vertical-align: top;
    }

    #name_selected{
        margin: 2px;
        width: 135px;
        display: inline-block; 
        font-size: 12px;
        margin-left: 5px;
        line-height: 14px;
    }

    .btn_submit {
        margin-left: 45%;
        margin-top: 45px;
        font-family: inherit;
        font-size: 18px;
        background-color: #FCDA33;
        width: 150px;
        height: 50px;
        text-align: center;
        display: inline-block;

        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .name_td {
        height: 38px;
    }
</style>

<table class="inputTable" id="main_table" style="margin-left: -90px">
    <tbody  style="min-width: 1170px; width: 1170px; max-width: 1170px">
                <tr class='hidden-row'>
                    <td style ='text-align: center;width:200px;min-width: 200px;max-width: 200px'>Тип</td>
                    <td style ='text-align: center;width:200px;min-width: 200px;max-width: 200px'>Наименование</td>
                    <td style="text-align: center; padding: 0; width: 100px;min-width: 100px;max-width: 100px">Родитель</td>
                    <td style="text-align: center; padding: 0; width: 100px">Склад

                    <table><tr><td>Приход</td><td>Расход</td><td>Баланс</td></tr></table>
                    </td>
                    <td style="text-align: center; padding: 0;width: 100px">Петр

                    <table><tr><td>Приход</td><td>Расход</td><td>Баланс</td></tr></table>
                    </td>
                    <td style="text-align: center; padding: 0;width: 100px">Галина

                    <table><tr><td>Приход</td><td>Расход</td><td>Баланс</td></tr></table>
                    </td>
                    <td style="text-align: center; padding: 0;width: 100px">Жоомарт

                    <table><tr><td>Приход</td><td>Расход</td><td>Баланс</td></tr></table>
                    </td>
                </tr>
                <tr>
                    <td style ='text-align: center;width:200px;min-width: 200px;max-width: 200px'><select onchange="filter()" id="types" class = "form-control"></select></td>
                    <td style ='text-align: center;width:200px;min-width: 200px;max-width: 200px'><input onchange="filter()" id="names" type="text" name=""></td>
                    <td style="text-align: center; padding: 0; width: 100px;min-width: 100px;max-width: 100px"><select onchange="filter()" id="parents" class = "form-control"></select></td>
                    <td style="text-align: center; padding: 0; width: 100px">
                    <table><tr><td><input onchange="filter()" id="storage_plus" style="width:60px" type="number" name=""></td><td><input id="storage_minus" onchange="filter()" style="width:60px" type="number" name=""></td><td><input onchange="filter()" id="storage_diff" style="width:60px" type="number" name=""></td></tr></table>
                    </td>
                    <td style="text-align: center; padding: 0;width: 100px">
                    <table><tr><td><input id="petr_plus" onchange="filter()" style="width:60px" type="number" name=""></td><td><input onchange="filter()" id="petr_minus" type="number" style="width:60px" name=""></td><td><input onchange="filter()" id="petr_diff" type="number" style="width:60px" name=""></td></tr></table>
                    </td>
                    <td style="text-align: center; padding: 0;width: 100px">
                    <table><tr><td><input onchange="filter()" id="galina_plus" style="width:60px" type="number" name=""></td><td><input onchange="filter()" id="galina_minus" style="width:60px" type="number" name=""></td><td><input onchange="filter()" id="galina_diff" style="width:60px" type="number" name=""></td></tr></table>
                    </td>
                    <td style="text-align: center; padding: 0;width: 100px">
                    <table><tr><td><input id="zhoomart_plus" onchange="filter()" style="width:60px" type="number" name=""></td><td><input onchange="filter()" id="zhoomart_minus" style="width:60px" type="number" name=""></td><td><input onchange="filter()" id="zhoomart_diff" style="width:60px" type="number" name=""></td></tr></table>
                    </td>

                </tr>
                <tr name="row">
                    <td name="type">Бронза чистая</td>
                    <td name="name">Бронза чистая</td>
                    <td name="parent">Бронза чистая</td>
                    <td>
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;
                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Металл Бронза чистая') == 0 && strcmp($name[$j], 'Бронза чистая') == 0) {
                                       if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr name="row">
                    <td name="type">Бронза вторичная</td>
                    <td name="name">Бронза вторичная</td>
                    <td name="parent">Бронза чистая</td>
                      <td>
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;
                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Металл Бронза вторичная') == 0 && strcmp($name[$j], 'Бронза вторичная') == 0) {
                                        if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr name="row">
                    <td name="type">Серебро 999 чистое</td>
                    <td name="name">Серебро 999 чистое</td>
                    <td name="parent">Серебро 999 чистое</td>
                      <td >
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;
                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Металл Серебро 999 чистое') == 0 && strcmp($name[$j], 'Серебро 999 чистое') == 0) {
                                        if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr name="row">
                    <td name="type">Серебро 925 вторичное</td>
                    <td name="name">Серебро 925 вторичное</td>
                    <td name="parent">Серебро 999 чистое</td>
                      <td>
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;
                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Металл Серебро 925 вторичное') == 0 && strcmp($name[$j], 'Серебро 925 вторичное') == 0) {
                                       if (strcmp($from[$j], 'Склад') == 0 && strcmp($operation[$j], 'Расход')) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0 && strcmp($operation[$j], 'Приход')) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0 && strcmp($operation[$j], 'Расход')) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0 && strcmp($operation[$j], 'Приход')) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0 && strcmp($operation[$j], 'Расход')) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0 && strcmp($operation[$j], 'Приход')) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0 && strcmp($operation[$j], 'Расход')) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0 && strcmp($operation[$j], 'Приход')) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr name="row">
                    <td name="type">Золото 999 чистое</td>
                    <td name="name">Золото 999 чистое</td>
                    <td name="parent">Золото 999 чистое</td>
                      <td >
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;
                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Металл Золото 999 чистое') == 0 && strcmp($name[$j], 'Золото 999 чистое') == 0) {
                                        if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr name="row">
                    <td name="type">Золото белое 585 вторичное</td>
                    <td name="name">Золото белое 585 вторичное</td>
                    <td name="parent">Золото 999 чистое</td>
                    <td >
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;
                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Металл Золото белое 585 вторичное') == 0 && strcmp($name[$j], 'Золото белое 585 вторичное') == 0) {

                                        if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr name="row">
                    <td name="type">Золото белое 750 вторичное</td>
                    <td name="name">Золото белое 750 вторичное</td>
                    <td name="parent">Золото 999 чистое</td>
                      <td >
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;
                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Металл Золото белое 750 вторичное') == 0 && strcmp($name[$j], 'Золото белое 750 вторичное') == 0) {
                                        if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr name="row">
                    <td name="type">Золото желтое 585 вторичное</td>
                    <td name="name">Золото желтое 585 вторичное</td>
                    <td name="parent">Золото 999 чистое</td>
                      <td >
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;
                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Металл Золото желтое 585 вторичное') == 0 && strcmp($name[$j], 'Золото желтое 585 вторичное') == 0) {
                                        if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr name="row">
                    <td name="type">Золото желтое 750 вторичное</td>
                    <td name="name">Золото желтое 750 вторичное</td>
                    <td name="parent">Золото 999 чистое</td>
                      <td>
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;
                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Металл Золото желтое 750 вторичное') == 0 && strcmp($name[$j], 'Золотое желтое 750 вторичное') == 0) {
                                        if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr name="row">
                    <td name="type">Золото розовое 585 вторичное</td>
                    <td name="name">Золото розовое 585 вторичное</td>
                    <td name="parent">Золото 999 чистое</td>
                      <td>
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;
                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Металл Золото розовое 585 вторичное') == 0 && strcmp($name[$j], 'Золото розовое 585 вторичное') == 0) {
                                        if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr name="row">
                    <td name="type">Золото розовое 750 вторичное</td>
                    <td name="name">Золото розовое 750 вторичное</td>
                    <td name="parent">Золото 999 чистое</td>
                      <td>
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;
                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Металл Золото розовое 750 вторичное') == 0 && strcmp($name[$j], 'Золото розовое 750 вторичное') == 0) {
                                        if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr name="row">
                    <td name="type">Лигатура серебро</td>
                    <td name="name">Лигатура серебро</td>
                    <td name="parent">Серебро 999 чистое</td>
                    <td>
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;
                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Лигатура серебро') == 0 && strcmp($name[$j], 'серебро') == 0) {
                                        if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr name="row">
                    <td name="type">Лигатура белое золото</td>
                    <td name="name">Лигатура белое золото</td>
                    <td name="parent">Золото 999 чистое</td>
                    <td>
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;
                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Лигатура белое золото') == 0 && strcmp($name[$j], 'белое золото') == 0) {
                                        if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr name="row">
                    <td name="type">Лигатура желтое золото</td>
                    <td name="name">Лигатура желтое золото</td>
                    <td name="parent">Золото 999 чистое</td>
                    <td>
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;
                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Лигатура желтое золото') == 0 && strcmp($name[$j], 'желтое золото') == 0) {
                                        if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr name="row">
                    <td name="type">Лигатура розовое золото</td>
                    <td name="name">Лигатура розовое золото</td>
                    <td name="parent">Золото 999 чистое</td>
                    <td>
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;
                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Лигатура розовое золото') == 0 && strcmp($name[$j], 'розовое золото') == 0) {
                                        if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!--  -->
                <tr name="row">
                    <td name="type">Деталь Бронза</td>
                    <td name="name">Деталь, Деталь Бронза</td>
                    <td name="parent">Бронза чистая</td>
                    <td>
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;
                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Деталь Бронза') == 0 && strcmp($name[$j], 'Детали Бронза') == 0) {
                                        if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php for($i = 0; $i < sizeof($names); $i++) { ?>
                <tr name="row">
                    <td name="type">Деталь Бронза</td>
                    <td name="name"><?=$names[$i] . ', Деталь Бронза'?></td>
                    <td name="parent">Бронза чистая</td>
                    <td>
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;


                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Деталь Бронза') == 0 && strcmp($name_desc[$j], $names[$i]) == 0) {
                                        if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php }  ?>
                <!--  -->
                <!--  -->

                <tr name="row">
                    <td name="type">Деталь Серебро 925</td>
                    <td name="name">Деталь, Деталь Серебро 925</td>
                    <td name="parent">Серебро 999 чистое</td>
                    <td>
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;


                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Деталь Серебро 925') == 0 && strcmp($name_desc[$j], 'Детали Серебро 925') == 0) {
                                        if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr name="row">
                <?php for($i = 0; $i < sizeof($names); $i++) { ?>
                <tr name="row">
                    <td name="type">Деталь Серебро 925</td>
                    <td name="name"><?=$names[$i] . ', Деталь Серебро 925'?></td>
                    <td name="parent">Серебро 999 чистое</td>
                    <td>
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;


                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Деталь Серебро 925') == 0 && strcmp($name_desc[$j], $names[$i]) == 0) {
                                        if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr name="row">
                <?php }  ?>
                <!--  -->
                <!--  -->
                <tr name="row">
                    <td name="type">Деталь Золото белое 585</td>
                    <td name="name">Деталь, Деталь Золото белое 585</td>
                    <td name="parent">Золото 999 чистое</td>
                    <td>
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;


                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Деталь Золото белое 585') == 0 && strcmp($name_desc[$j], 'Детали Золото белое 585') == 0) {
                                        if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php for($i = 0; $i < sizeof($names); $i++) { ?>
                <tr name="row">
                    <td name="type">Деталь Золото белое 585</td>
                    <td name="name"><?=$names[$i] . ', Деталь Золото белое 585'?></td>
                    <td name="parent">Золото 999 чистое</td>
                    <td>
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;


                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Деталь Золото белое 585') == 0 && strcmp($name_desc[$j], $names[$i]) == 0) {
                                        if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php }  ?>
                <!--  -->
                <!--  -->
                <tr name="row">
                    <td name="type">Деталь Золото желтое 585</td>
                    <td name="name">Деталь, Деталь Золото желтое 585</td>
                    <td name="parent">Золото 999 чистое</td>
                    <td>
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;


                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Деталь Золото желтое 585') == 0 && strcmp($name_desc[$j], 'Детали Золото желтое 585') == 0) {
                                        if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php for($i = 0; $i < sizeof($names); $i++) { ?>
                <tr name="row">
                    <td name="type">Деталь Золото желтое 585</td>
                    <td name="name"><?=$names[$i] . ', Деталь Золото желтое 585'?></td>
                    <td name="parent">Золото 999 чистое</td>
                    <td>
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;


                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Деталь Золото желтое 585') == 0 && strcmp($name_desc[$j], $names[$i]) == 0) {
                                        if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php }  ?>
                <!--  -->
                <!--  -->
                <tr name="row">
                    <td name="type">Деталь Золото розовое 585</td>
                    <td name="name">Деталь, Деталь Золото розовое 585</td>
                    <td name="parent">Золото 999 чистое</td>
                    <td>
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;


                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Деталь Золото розовое 585') == 0 && strcmp($name_desc[$j], 'Детали Золото розовое 585') == 0) {
                                        if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php for($i = 0; $i < sizeof($names); $i++) { ?>
                <tr name="row">
                    <td name="type">Деталь Золото розовое 585</td>
                    <td name="name"><?=$names[$i] . ', Деталь Золото розовое 585'?></td>
                    <td name="parent">Золото 999 чистое</td>
                    <td>
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;


                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Деталь Золото розовое 585') == 0 && strcmp($name_desc[$j], $names[$i]) == 0) {
                                        if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php }  ?>
                <!--  -->
                <!--  -->
                <tr name="row">
                    <td name="type">Деталь Золото белое 750</td>
                    <td name="name">Деталь, Деталь Золото белое 750</td>
                    <td name="parent">Золото 999 чистое</td>
                    <td>
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;


                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Деталь Золото белое 750') == 0 && strcmp($name_desc[$j], 'Детали Золото белое 750') == 0) {
                                        if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php for($i = 0; $i < sizeof($names); $i++) { ?>
                <tr name="row">
                    <td name="type">Деталь Золото белое 750</td>
                    <td name="name"><?=$names[$i] . ', Деталь Золото белое 750'?></td>
                    <td name="parent">Золото 999 чистое</td>
                    <td>
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;


                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Деталь Золотое белое 750') == 0 && strcmp($name_desc[$j], $names[$i]) == 0) {
                                        if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php }  ?>
                <!--  -->
                <!--  -->
                <tr name="row">
                    <td name="type">Деталь Золото желтое 750</td>
                    <td name="name">Деталь, Деталь Золото желтое 750</td>
                    <td name="parent">Золото 999 чистое</td>
                    <td>
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;


                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Деталь Золото желтое 750') == 0 && strcmp($name_desc[$j], 'Детали Золото желтое 750') == 0) {
                                        if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php for($i = 0; $i < sizeof($names); $i++) { ?>
                <tr name="row">
                    <td name="type">Деталь Золото желтое 750</td>
                    <td name="name"><?=$names[$i] . ', Деталь Золото желтое 750'?></td>
                    <td name="parent">Золото 999 чистое</td>
                    <td>
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;


                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Деталь Золото желтое 750') == 0 && strcmp($name_desc[$j], $names[$i]) == 0) {
                                        if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php }  ?>
                <!--  -->
                <!--  -->
                <tr name="row">
                    <td name="type">Деталь Золото розовое 750</td>
                    <td name="name">Деталь, Деталь Золото розовое 750</td>
                    <td name="parent">Золото 999 чистое</td>
                    <td>
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;


                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Деталь Золото розовое 750') == 0 && strcmp($name_desc[$j], 'Детали Золото розовое 750') == 0) {
                                        if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php for($i = 0; $i < sizeof($names); $i++) { ?>
                <tr name="row">
                    <td name="type">Деталь Золото розовое 750</td>
                    <td name="name"><?=$names[$i] . ', Деталь Золото розовое 750'?></td>
                    <td name="parent">Золото 999 чистое</td>
                    <td>
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;


                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Деталь Золото розовое 750') == 0 && strcmp($name_desc[$j], $names[$i]) == 0) {
                                        if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php }  ?>
                <!--  -->
                <!--  -->
                <tr name="row">
                    <td name="type">Полуфабрикат Бронза</td>
                    <td name="name">Полуфабрикат, Полуфабрикат Бронза</td>
                    <td name="parent">Бронза чистая</td>
                    <td>
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;


                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Полуфабрикат Бронза') == 0 && strcmp($name_desc[$j], 'Полуфабрикаты Бронза') == 0) {
                                        if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php for($i = 0; $i < sizeof($names2); $i++) { ?>
                <tr name="row">
                    <td name="type">Полуфабрикат Бронза</td>
                    <td name="name"><?=$names2[$i] . ', Полуфабрикат Бронза'?></td>
                    <td name="parent">Бронза чистая</td>
                    <td>
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;


                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Полуфабрикат Бронза') == 0 && strcmp($name[$j], $names2[$i]) == 0) {
                                        if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php }  ?>
                <!--  -->
                <!--  -->
                <tr name="row">
                    <td name="type">Полуфабрикат Серебро 925</td>
                    <td name="name">Полуфабрикат, Полуфабрикат Серебро 925</td>
                    <td name="parent">Серебро 999 чистое</td>
                    <td>
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;


                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Полуфабрикат Серебро 925') == 0 && strcmp($name[$j], 'Полуфабрикаты Серебро 925') == 0) {
                                        if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php for($i = 0; $i < sizeof($names2); $i++) { ?>
                <tr name="row">
                    <td name="type">Полуфабрикат Серебро 925</td>
                    <td name="name"><?=$names2[$i] . ', Полуфабрикат Серебро 925'?></td>
                    <td name="parent">Серебро 999 чистое</td>
                    <td>
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;


                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Полуфабрикат Серебро 925') == 0 && strcmp($name[$j], $names2[$i]) == 0) {
                                        if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php }  ?>
                <!--  -->
                <!--  -->
                <tr name="row">
                    <td name="type">Полуфабрикат Золото белое 585</td>
                    <td name="name">Полуфабрикат, Полуфабрикат Золото белое 585</td>
                    <td name="parent">Золото 999 чистое</td>
                    <td>
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;


                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Полуфабрикат Золото белое 585') == 0 && strcmp($name[$j], 'Полуфабрикаты Золото белое 585') == 0) {
                                        if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php for($i = 0; $i < sizeof($names2); $i++) { ?>
                <tr name="row">
                    <td name="type">Полуфабрикат Золото белое 585</td>
                    <td name="name"><?=$names2[$i] . ', Полуфабрикат Золото белое 585'?></td>
                    <td name="parent">Золото 999 чистое</td>
                    <td>
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;


                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Полуфабрикат Золото белое 585') == 0 && strcmp($name[$j], $names2[$i]) == 0) {
                                        if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php }  ?>
                <!--  -->
                <!--  -->
                <tr name="row">
                    <td name="type">Полуфабрикат Золото желтое 585</td>
                    <td name="name">Полуфабрикат, Полуфабрикат Золото желтое 585</td>
                    <td name="parent">Золото 999 чистое</td>
                    <td>
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;


                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Полуфабрикат Золото желтое 585') == 0 && strcmp($name[$j], 'Полуфабрикаты Золото желтое 585') == 0) {
                                        if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php for($i = 0; $i < sizeof($names2); $i++) { ?>
                <tr name="row">
                    <td name="type">Полуфабрикат Золото желтое 585</td>
                    <td name="name"><?=$names2[$i] . ', Полуфабрикат Золото желтое 585'?></td>
                    <td name="parent">Золото 999 чистое</td>
                    <td>
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;


                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Полуфабрикат Золото желтое 585') == 0 && strcmp($name[$j], $names2[$i]) == 0) {
                                        if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php }  ?>
                <!--  -->
                <!--  -->
                <tr name="row">
                    <td name="type">Полуфабрикат Золото розовое 585</td>
                    <td name="name">Полуфабрикат, Полуфабрикат Золото розовое 585</td>
                    <td name="parent">Золото 999 чистое</td>
                    <td>
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;


                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Полуфабрикат Золото розовое 585') == 0 && strcmp($name[$j], 'Полуфабрикаты Золото розовое 585') == 0) {
                                        if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php for($i = 0; $i < sizeof($names2); $i++) { ?>
                <tr name="row">
                    <td name="type">Полуфабрикат Золото розовое 585</td>
                    <td name="name"><?=$names2[$i] . ', Полуфабрикат Золото розовое 585'?></td>
                    <td name="parent">Золото 999 чистое</td>
                    <td>
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;


                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Полуфабрикат Золото розовое 585') == 0 && strcmp($name[$j], $names2[$i]) == 0) {
                                        if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php }  ?>
                <!--  -->
                <!--  -->
                <tr name="row">
                    <td name="type">Полуфабрикат Золото белое 750</td>
                    <td name="name">Полуфабрикат, Полуфабрикат Золото белое 750</td>
                    <td name="parent">Золото 999 чистое</td>
                    <td>
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;


                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Полуфабрикат Золото белое 750') == 0 && strcmp($name[$j], 'Полуфабрикаты Золото белое 750') == 0) {
                                        if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php for($i = 0; $i < sizeof($names2); $i++) { ?>
                <tr name="row">
                    <td name="type">Полуфабрикат Золото белое 750</td>
                    <td name="name"><?=$names2[$i] . ', Полуфабрикат Золото белое 750'?></td>
                    <td name="parent">Золото 999 чистое</td>
                    <td>
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;


                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Полуфабрикат Золото белое 750') == 0 && strcmp($name[$j], $names2[$i]) == 0) {
                                        if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php }  ?>
                <!--  -->
                 <!--  -->
                <tr name="row">
                    <td name="type">Полуфабрикат Золото желтое 750</td>
                    <td name="name">Полуфабрикат, Полуфабрикат Золото желтое 750</td>
                    <td name="parent">Золото 999 чистое</td>
                    <td>
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;


                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Полуфабрикат Золото желтое 750') == 0 && strcmp($name[$j], 'Полуфабрикаты Золото желтое 750') == 0) {
                                        if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php for($i = 0; $i < sizeof($names2); $i++) { ?>
                <tr name="row">
                    <td name="type">Полуфабрикат Золото желтое 750</td>
                    <td name="name"><?=$names2[$i] . ', Полуфабрикат Золото желтое 750'?></td>
                    <td name="parent">Золото 999 чистое</td>
                    <td>
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;


                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Полуфабрикат Золото желтое 750') == 0 && strcmp($name[$j], $names2[$i]) == 0) {
                                        if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php }  ?>
                <!--  -->
                 <!--  -->
                <tr name="row">
                    <td name="type">Полуфабрикат Золото розовое 750</td>
                    <td name="name">Полуфабрикат, Полуфабрикат Золото розовое 750</td>
                    <td name="parent">Золото 999 чистое</td>
                    <td>
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;


                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Полуфабрикат Золото розовое 750') == 0 && strcmp($name[$j], 'Полуфабрикаты Золото розовое 750') == 0) {
                                        if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php for($i = 0; $i < sizeof($names2); $i++) { ?>
                <tr name="row">
                    <td name="type">Полуфабрикат Золото розовое 750</td>
                    <td name="name"><?=$names2[$i] . ', Полуфабрикат Золото розовое 750'?></td>
                    <td name="parent">Золото 999 чистое</td>
                    <td>
                        <table class="hidden-row" style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?php
                                $plusStorage = 0;
                                $minusStorage = 0;

                                $plusPetr = 0;
                                $minusPetr = 0;

                                $plusGalina = 0;
                                $minusGalina = 0;

                                $plusZhoomart = 0;
                                $minusZhoomart = 0;


                                for ($j = 0; $j < sizeof($from); $j ++) {
                                    if (strcmp($type[$j], 'Полуфабрикат Золото розовое 750') == 0 && strcmp($name[$j], $names2[$i]) == 0) {
                                        if (strcmp($from[$j], 'Склад') == 0) $minusStorage += $massa[$j];
                                        if (strcmp($to[$j], 'Склад') == 0) $plusStorage += $massa[$j];
                                        if (strcmp($from[$j], 'Петр') == 0) $minusPetr += $massa[$j];
                                        if (strcmp($to[$j], 'Петр') == 0) $plusPetr += $massa[$j];
                                        if (strcmp($from[$j], 'Галина') == 0) $minusGalina += $massa[$j];
                                        if (strcmp($to[$j], 'Галина') == 0) $plusGalina += $massa[$j];
                                        if (strcmp($from[$j], 'Жоомарт') == 0) $minusZhoomart += $massa[$j];
                                        if (strcmp($to[$j], 'Жоомарт') == 0) $plusZhoomart += $massa[$j];
                                    }
                                }
                                echo $plusStorage;
                                ?></td>
                                <td name="minusStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusStorage?></td>
                                <td name="diffStorage" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusStorage-$minusStorage?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr?></td>
                                <td name="minusPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusPetr?></td>
                                <td name="diffPetr" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusPetr-$minusPetr?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina?></td>
                                <td name="minusGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusGalina?></td>
                                <td name="diffGalina" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusGalina-$minusGalina?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%; text-align: center">
                            <tr>
                                <td name="plusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart?></td>
                                <td name="minusZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$minusZhoomart?></td>
                                <td name="diffZhoomart" style="width: 33%; max-width: 33%; min-width: 33%"><?=$plusZhoomart-$minusZhoomart?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php }  ?>
                <!--  -->


    </tbody>
</table>

<script type="text/javascript">
    generateSelectTypes();
    generateSelectParents();


    function generateSelectTypes() {
        var opt = document.createElement('option');
        opt.innerHTML = 'Все';
        opt.backgroundColor = "";
        opt.value = 'all';
        $('#types').append(opt);

        var opt = document.createElement('option');
        opt.innerHTML = 'Бронза чистая';
        opt.backgroundColor = "";
        opt.value = 'Бронза чистая';
        $('#types').append(opt);

        var opt = document.createElement('option');
        opt.innerHTML = 'Бронза вторичная';
        opt.backgroundColor = "";
        opt.value = 'Бронза вторичная';
        $('#types').append(opt);

        var opt = document.createElement('option');
        opt.innerHTML = 'Серебро 999 чистое';
        opt.backgroundColor = "";
        opt.value = 'Серебро 999 чистое';
        $('#types').append(opt);

        var opt = document.createElement('option');
        opt.innerHTML = 'Серебро 925 вторичное';
        opt.backgroundColor = "";
        opt.value = 'Серебро 925 вторичное';
        $('#types').append(opt);

        var opt = document.createElement('option');
        opt.innerHTML = 'Золото 999 чистое';
        opt.backgroundColor = "";
        opt.value = 'Золото 999 чистое';
        $('#types').append(opt);

        var opt = document.createElement('option');
        opt.innerHTML = 'Золото белое 585 вторичное';
        opt.backgroundColor = "";
        opt.value = 'Золото белое 585 вторичное';
        $('#types').append(opt);

        var opt = document.createElement('option');
        opt.innerHTML = 'Золото белое 750 вторичное';
        opt.backgroundColor = "";
        opt.value = 'Золото белое 750 вторичное';
        $('#types').append(opt);

        var opt = document.createElement('option');
        opt.innerHTML = 'Золото желтое 585 вторичное';
        opt.backgroundColor = "";
        opt.value = 'Золото желтое 585 вторичное';
        $('#types').append(opt);

        var opt = document.createElement('option');
        opt.innerHTML = 'Золото желтое 750 вторичное';
        opt.backgroundColor = "";
        opt.value = 'Золото желтое 750 вторичное';
        $('#types').append(opt);

        var opt = document.createElement('option');
        opt.innerHTML = 'Золото розовое 585 вторичное';
        opt.backgroundColor = "";
        opt.value = 'Золото розовое 585 вторичное';
        $('#types').append(opt);

        var opt = document.createElement('option');
        opt.innerHTML = 'Золото розовое 750 вторичное';
        opt.backgroundColor = "";
        opt.value = 'Золото розовое 750 вторичное';
        $('#types').append(opt);

        var opt = document.createElement('option');
        opt.innerHTML = 'Лигатура серебро';
        opt.backgroundColor = "";
        opt.value = 'Лигатура серебро';
        $('#types').append(opt);

        var opt = document.createElement('option');
        opt.innerHTML = 'Лигатура белое золото';
        opt.backgroundColor = "";
        opt.value = 'Лигатура белое золото';
        $('#types').append(opt);

        var opt = document.createElement('option');
        opt.innerHTML = 'Лигатура желтое золото';
        opt.backgroundColor = "";
        opt.value = 'Лигатура желтое золото';
        $('#types').append(opt);

        var opt = document.createElement('option');
        opt.innerHTML = 'Лигатура розовое золото';
        opt.backgroundColor = "";
        opt.value = 'Лигатура розовое золото';
        $('#types').append(opt);

        var opt = document.createElement('option');
        opt.innerHTML = 'Деталь Бронза';
        opt.backgroundColor = "";
        opt.value = 'Деталь Бронза';
        $('#types').append(opt);

        var opt = document.createElement('option');
        opt.innerHTML = 'Деталь Серебро 925';
        opt.backgroundColor = "";
        opt.value = 'Деталь Серебро 925';
        $('#types').append(opt);

        var opt = document.createElement('option');
        opt.innerHTML = 'Деталь Золото белое 585';
        opt.backgroundColor = "";
        opt.value = 'Деталь Золото белое 585';
        $('#types').append(opt);

        var opt = document.createElement('option');
        opt.innerHTML = 'Деталь Золото желтое 585';
        opt.backgroundColor = "";
        opt.value = 'Деталь Золото желтое 585';
        $('#types').append(opt);

        var opt = document.createElement('option');
        opt.innerHTML = 'Деталь Золото розовое 585';
        opt.backgroundColor = "";
        opt.value = 'Деталь Золото розовое 585';
        $('#types').append(opt);

        var opt = document.createElement('option');
        opt.innerHTML = 'Деталь Золото белое 750';
        opt.backgroundColor = "";
        opt.value = 'Деталь Золото белое 750';
        $('#types').append(opt);

        var opt = document.createElement('option');
        opt.innerHTML = 'Деталь Золото желтое 750';
        opt.backgroundColor = "";
        opt.value = 'Деталь Золото желтое 750';
        $('#types').append(opt);

        var opt = document.createElement('option');
        opt.innerHTML = 'Деталь Золото розовое 750';
        opt.backgroundColor = "";
        opt.value = 'Деталь Золото розовое 750';
        $('#types').append(opt);

        var opt = document.createElement('option');
        opt.innerHTML = 'Полуфабрикат Бронза';
        opt.backgroundColor = "";
        opt.value = 'Полуфабрикат Бронза';
        $('#types').append(opt);

        var opt = document.createElement('option');
        opt.innerHTML = 'Полуфабрикат Серебро 925';
        opt.backgroundColor = "";
        opt.value = 'Полуфабрикат Серебро 925';
        $('#types').append(opt);

        var opt = document.createElement('option');
        opt.innerHTML = 'Полуфабрикат Золото белое 585';
        opt.backgroundColor = "";
        opt.value = 'Полуфабрикат Золото белое 585';
        $('#types').append(opt);

        var opt = document.createElement('option');
        opt.innerHTML = 'Полуфабрикат Золото желтое 585';
        opt.backgroundColor = "";
        opt.value = 'Полуфабрикат Золото желтое 585';
        $('#types').append(opt);

        var opt = document.createElement('option');
        opt.innerHTML = 'Полуфабрикат Золото розовое 585';
        opt.backgroundColor = "";
        opt.value = 'Полуфабрикат Золото розовое 585';
        $('#types').append(opt);

        var opt = document.createElement('option');
        opt.innerHTML = 'Полуфабрикат Золото белое 750';
        opt.backgroundColor = "";
        opt.value = 'Полуфабрикат Золото белое 750';
        $('#types').append(opt);

        var opt = document.createElement('option');
        opt.innerHTML = 'Полуфабрикат Золото желтое 750';
        opt.backgroundColor = "";
        opt.value = 'Полуфабрикат Золото желтое 750';
        $('#types').append(opt);

        var opt = document.createElement('option');
        opt.innerHTML = 'Полуфабрикат Золото розовое 750';
        opt.backgroundColor = "";
        opt.value = 'Полуфабрикат Золото розовое 750';
        $('#types').append(opt);

        var opt = document.createElement('option');
        opt.innerHTML = 'Полуфабрикат Золото желтое 585';
        opt.backgroundColor = "";
        opt.value = 'Полуфабрикат Золото желтое 585';
        $('#types').append(opt);
    }

    function generateSelectParents() {

        var opt = document.createElement('option');
        opt.innerHTML = 'Все';
        opt.backgroundColor = "";
        opt.value = 'all';
        $('#parents').append(opt);

        var opt = document.createElement('option');
        opt.innerHTML = 'Бронза чистая';
        opt.backgroundColor = "";
        opt.value = 'Бронза чистая';
        $('#parents').append(opt);

        var opt = document.createElement('option');
        opt.innerHTML = 'Серебро 999 чистое';
        opt.backgroundColor = "";
        opt.value = 'Серебро 999 чистое';
        $('#parents').append(opt);

        var opt = document.createElement('option');
        opt.innerHTML = 'Золото 999 чистое';
        opt.backgroundColor = "";
        opt.value = 'Золото 999 чистое';
        $('#parents').append(opt);

        var opt = document.createElement('option');
        opt.innerHTML = 'Бронза чистая';
        opt.backgroundColor = "";
        opt.value = 'Бронза чистая';
        $('#parents').append(opt);
    }

    function filter() {
        var rows = document.getElementsByName('row');

        var types = document.getElementsByName('type');
        var names = document.getElementsByName('name');
        var parents = document.getElementsByName('parent');

        var plusStorage = document.getElementsByName('plusStorage');
        var minusStorage = document.getElementsByName('minusStorage');
        var diffStorage = document.getElementsByName('diffStorage');

        var plusPetr = document.getElementsByName('plusPetr');
        var minusPetr = document.getElementsByName('minusPetr');
        var diffPetr = document.getElementsByName('diffPetr');

        var plusGalina = document.getElementsByName('plusGalina');
        var minusGalina = document.getElementsByName('minusGalina');
        var diffGalina = document.getElementsByName('diffGalina');

        var plusZhoomart = document.getElementsByName('plusZhoomart');
        var minusZhoomart = document.getElementsByName('minusZhoomart');
        var diffZhoomart = document.getElementsByName('diffZhoomart');

        ///////////////////////////////////// 

        var selectTypes = document.getElementById('types');
        var selectParents = document.getElementById('parents');
        var selectNames = document.getElementById('names');

        var queryStoragePlus = document.getElementById('storage_plus');
        var queryStorageMinus = document.getElementById('storage_minus');
        var queryStorageDiff = document.getElementById('storage_diff');

        var queryPetrPlus = document.getElementById('petr_plus');
        var queryPetrMinus = document.getElementById('petr_minus');
        var queryPetrDiff = document.getElementById('petr_diff');

        var queryGalinaPlus = document.getElementById('galina_plus');
        var queryGalinaMinus = document.getElementById('galina_minus');
        var queryGalinaDiff = document.getElementById('galina_diff');

        var queryZhoomartPlus = document.getElementById('zhoomart_plus');
        var queryZhoomartMinus = document.getElementById('zhoomart_minus');
        var queryZhoomartDiff = document.getElementById('zhoomart_diff');

        for (var i = 0; i < rows.length; i++) {
            rows[i].setAttribute('class', '');
        }

        for (var i = 0; i < rows.length; i++) {
            
            var isType = false, isName = false, isParent = false, isStoragePlus = false, isStorageMinus = false, isStorageDiff = false, isPetrPlus = false, isPetrMinus = false, isPetrDiff = false, isGalinaPlus = false, isGalinaMinus = false, isGalinaDiff = false, isZhoomartPlus = false, isZhoomartMinus = false, isZhoomartDiff = false;

            if (selectTypes.value == 'all' || selectTypes.value == types[i].innerHTML) isType = true;
            if (selectNames.value == '' || ((names[i].innerHTML).toLowerCase()).indexOf((selectNames.value).toLowerCase()) != -1) isName = true;
            if (selectParents.value == 'all' || selectParents.value == parents[i].innerHTML) isParent = true;

            if (queryStoragePlus.value == '' || queryStoragePlus.value == plusStorage[i].innerHTML) isStoragePlus = true;
            if (queryStorageMinus.value == '' || queryStorageMinus.value == minusStorage[i].innerHTML) isStorageMinus = true;
            if (queryStorageDiff.value == '' || queryStorageDiff.value == diffStorage[i].innerHTML) isStorageDiff = true;

            if (queryPetrPlus.value == '' || queryPetrPlus.value == plusPetr[i].innerHTML) isPetrPlus = true;
            if (queryPetrMinus.value == '' || queryPetrMinus.value == minusPetr[i].innerHTML) isPetrMinus = true;
            if (queryPetrDiff.value == '' || queryPetrDiff.value == diffPetr[i].innerHTML) isPetrDiff = true;

            if (queryGalinaPlus.value == '' || queryGalinaPlus.value == plusGalina[i].innerHTML) isGalinaPlus = true;
            if (queryGalinaMinus.value == '' || queryGalinaMinus.value == minusGalina[i].innerHTML) isGalinaMinus = true;
            if (queryGalinaDiff.value == '' || queryGalinaDiff.value == diffGalina[i].innerHTML) isGalinaDiff = true;

            if (queryZhoomartPlus.value == '' || queryZhoomartPlus.value == plusZhoomart[i].innerHTML) isZhoomartPlus = true;
            if (queryZhoomartMinus.value == '' || queryZhoomartMinus.value == minusZhoomart[i].innerHTML) isZhoomartMinus = true;
            if (queryZhoomartDiff.value == '' || queryZhoomartDiff.value == diffZhoomart[i].innerHTML) isZhoomartDiff = true;

            console.log(isType, isName, isParent, isStoragePlus, isStorageMinus, isStorageDiff, isPetrPlus, isPetrMinus, isPetrDiff, isGalinaPlus, isGalinaMinus, isGalinaDiff, isZhoomartPlus, isZhoomartMinus, isZhoomartDiff);
            if (!isType || !isName || !isParent || !isStoragePlus || !isStorageMinus || !isStorageDiff || !isPetrPlus || !isPetrMinus || !isPetrDiff || !isGalinaPlus || !isGalinaMinus || !isGalinaDiff || !isZhoomartPlus || !isZhoomartMinus || !isZhoomartDiff) rows[i].setAttribute('class', 'hide');
         
        }

    }

</script>







