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
/*if (!$user->hasRole(['admin', 'superadmin'])) { 
    Yii::$app->response->redirect(Url::to(['site/index']));
}*/
?>
<?php $f = ActiveForm::begin(['id' => 'form'])?>

<script src="http://code.jquery.com/jquery-latest.min.js"></script>


<style type="text/css">

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

    td[name="name"], td[name="name_2"], td[name="type_of_name"], td[name="desc"], td[name="type_of_name_2"], td[name="desc_2"] {
        max-width: 100px;
        
    }

    td[name="name"] {
        height: 37px;
    }

    td[name="name_2"] {
        height: 48px;
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
    
    .text_submit {
        margin-left: 46%;
        margin-top: 45px;
        text-align: center;
        color:#008000;
        display: inline-block;
    }

    .name_td {
        height: 38px;
    }

    .field-name_img_name, .field-type_img_name, .field-type_title_send, .field-type_desc_send,
    .field-name_title_send, .field-name_desc_send, .field-name_type_send, .field-date_send, .field-time_send {
        margin: 0 !important;
        height: 0 !important;
    }
    input::-webkit-outer-spin-button,
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
/* display: none; <- Crashes Chrome on hover */
    -webkit-appearance: none;
    margin: 0; /* <— Apparently some margin are still there even though it's hidden */
    }
    </style>
<section>
<table class="inputTable" >
    <tbody  style="min-width: 1170px; width: 1170px; max-width: 1170px">
                <tr class='hidden-row'>
                    <td><?=$f->field($form, 'from')->dropDownList($froms, ['onchange' => 'checkFrom("selectFrom", "selectOperation");', 'onclick'=>'', 'id' => "selectFrom", 'style' => 'box-shadow: inset 0px 0px 0px 0px black;border: 0px;width:100px; background-color: #fff8ca', 'options' => [''=>['selected'=>true]]])->label('');?></td>
                    <td><?=$f->field($form, 'to')->dropDownList($tos, ['onchange' => 'checkTo("selectFrom","selectTo")','id' => "selectTo", 'style' => 'box-shadow: inset 0px 0px 0px 0px black;border: 0px;width:100px; background-color: #fff8ca', 'options' => [''=>['selected'=>true]]])->label('');?></td>

                    <td id="date" style="max-width: 58.5px; min-width: 58.5px;text-align: center; padding: 0"></td>

                    <td style="max-width: 58.5px; min-width: 58.5px;text-align: center; padding: 0"><div id="time"></div></td>

                    
                    <td id="nonselected_type"><div  class="testType" onclick="showFun()" id = "selectType"><span style="display: inline-block;">Тип</span><div id="arrow">&#9660;</div></div></td>

                    <td id="selected_type" class="hidden"><div onclick="showFun()" class="in_selected_type"><img id="img_type" class="selected_type_img"><div id="type_selected"><h6 id="type_selected_title" style="margin-top: 0px"></h6><p id="type_selected_desc"></p> </div></div></td>
                    

                    <td id="nonselected_name"><div onclick="showNames()" id = "selectName"><span style="display: inline-block;">Наименование</span><div id="arroww">&#9660;</div></div></td>

                    <td id="selected_name" class="hidden"><div onclick="showNames()" class="in_selected_name"><img id="img_name" class="selected_name_img"><div id="name_selected"><h6 id="name_selected_title" style="margin-top: 0px"></h6><p style="margin-bottom: 3px; font-size: 11px" id="name_selected_desc"></p><p style="margin: 0;font-size: 11px" id="name_selected_type"></p> </div></div></td>
                    
                    <td><?=$f->field($form, 'operation')->dropDownList($operations, ['onchange' => 'checkFrom("selectFrom", "selectOperation")', 'id' => "selectOperation", 'style' => 'box-shadow: inset 0px 0px 0px 0px black;border: 0px;width:100px;background-color: #fff8ca', 'options' => [''=>['selected'=>true]]])->label('');?></td>


                    <td><?=$f->field($form, 'massa')->textInput(['id'=>'massa', 'style' => 'width:70px', 'type'=>'number', 'step'=> '0.01', 'min'=>'0', 'placeholder' => 'Грамм', "autocomplete"=>"off", 'oninput'=>'checkField()', 'onchange'=>'checkMassaFormat()'])->label('')?></td>
                    <td><?= $f->field($form, 'value')->textInput(['id'=>'value', 'style' => 'width:70px', 'type'=>'number', 'placeholder' => 'Штук', "autocomplete"=>"off", 'oninput'=>'checkField()'])->label('')?></td>

                    <td><div id = "selectStatus_div"><select onchange="selectOnChange()" id="selectStatus" style="box-shadow: inset 0px 0px 0px 0px black;border: 0px;width:100px; background-color: #fff8ca">
                                <option value = ''>Статус</option>
                                <option value = "Годное">Годное</option>
                                <option value = "Брак">Брак</option>
                    </select></div></td>
                    
                </tr>
    </tbody>
</table>
<?=$f->field($form, 'status')->textInput(['id' => "selectStatus_send", 'style' => 'display:none; height:0', 'type'=>'text'])->label('');?>
<?=$f->field($form, 'type_img_name')->textInput(['id' => 'type_img_name', 'style' => 'display:none; height:0', 'type'=>'text'])->label('')?>
<?=$f->field($form, 'name_img_name')->textInput(['id' => 'name_img_name', 'style' => 'display:none; height:0', 'type'=>'text'])->label('')?>
<?=$f->field($form, 'type_title_send')->textInput(['id' => 'type_title_send', 'style' => 'display:none; height:0', 'type'=>'text'])->label('')?>
<?=$f->field($form, 'type_desc_send')->textInput(['id' => 'type_desc_send', 'style' => 'display:none; height:0', 'type'=>'text'])->label('')?>
<?=$f->field($form, 'name_title_send')->textInput(['id' => 'name_title_send', 'style' => 'display:none; height:0', 'type'=>'text'])->label('')?>
<?=$f->field($form, 'name_desc_send')->textInput(['id' => 'name_desc_send', 'style' => 'display:none; height:0', 'type'=>'text'])->label('')?>
<?=$f->field($form, 'name_type_send')->textInput(['id' => 'name_type_send', 'style' => 'display:none; height:0', 'type'=>'text'])->label('')?>
<?=$f->field($form, 'date_send')->textInput(['id' => 'date_send', 'style' => 'display:none; height:0', 'type'=>'text'])->label('')?>
<?=$f->field($form, 'time_send')->textInput(['id' => 'time_send', 'style' => 'display:none; height:0', 'type'=>'text'])->label('')?>

<!-- <?=$f->field($form, 'name_img_name')->dropDownList($froms, ['id' => "name_img_name", 'style' => 'display:none'])->label('') ?> -->

<?= Html::submitButton('Ввод', ['id'=>'future', 'name' => 'button_save','onclick'=>'checkField()', 'class' => 'btn_submit']) ?>
<h5 id="textSave" class = 'text_submit' color="#008000" style="display: none">Успешно сохранено</h5>
<?php ActiveForm::end(); ?>

    <div name="grey_table_types" style="left:0; margin-top:30px;width: 100%; position: absolute; height:260px; z-index: -1"></div>
    <div name="grey_table_types" style="left:0; margin-top:530px;width: 100%; position: absolute; height:260px; z-index: -1"></div>

    <div name="grey_table_names" style="left:0; margin-top:30px;width: 100%; position: absolute; height:260px; z-index: -1"></div>
    <div name="grey_table_names" style="left:0; margin-top:1000px;width: 100%; position: absolute; height:710px; z-index: -1"></div>
    <div name="grey_table_names" style="left:0; margin-top:2000px;width: 100%; position: absolute; height:300px; z-index: -1"></div>
    <div class="wrap_types" id = "wrap_types">
        <div class="">
            <table class="types">
                <caption><h2>Металлы</h2></caption>
                
                <tr>
                    <td>
                        <table class="type" onclick="selectType('Металлы', 'Металл', 'Бронза чистая', 'мбч.png')">
                            <tr><td><img src="../images/storage/мбч.png"></td></tr>
                            <tr><td>Металл</td></tr>
                            <tr><td>Бронза</td></tr>
                            <tr><td>чистая</td></tr>

                        </table>
                       
                    </td>
                    <td>
                        <table class="type" onclick="selectType('Металлы', 'Металл', 'Бронза вторичная', 'мбв.png')">
                            <tr><td><img src="../images/storage/мбв.png"></td></tr>
                            <tr><td>Металл</td></tr>
                            <tr><td>Бронза</td></tr>
                            <tr><td>вторичная</td></tr>

                        </table>
                       
                    </td>
                    <td>
                        <table class="type" onclick="selectType('Металлы', 'Металл', 'Серебро 999 чистое', 'мс999ч.png')">
                            <tr><td><img src="../images/storage/мс999ч.png"></td></tr>
                            <tr><td>Металл</td></tr>
                            <tr><td>Серебро 999</td></tr>
                            <tr><td>чистое</td></tr>

                        </table>
                       
                    </td>
                    <td>
                        <table class="type" onclick="selectType('Металлы', 'Металл', 'Серебро 925 вторичное', 'мс925в.png')">
                            <tr><td><img src="../images/storage/мс925в.png"></td></tr>
                            <tr><td>Металл</td></tr>
                            <tr><td>Серебро 925</td></tr>
                            <tr><td>вторичное</td></tr>

                        </table>
                       
                    </td>
                    <td>
                        <table class="type" onclick="selectType('Металлы', 'Металл', 'Золото 999 чистое', 'мз999ч.png')">
                            <tr><td><img src="../images/storage/мз999ч.png"></td></tr>
                            <tr><td>Металл</td></tr>
                            <tr><td>Золото 999</td></tr>
                            <tr><td>чистое</td></tr>

                        </table>
                       
                    </td>
                   <td>
                        <table class="type" onclick="selectType('Металлы', 'Металл', 'Золото белое 585 вторичное', 'мзб585в.png')">
                            <tr><td><img src="../images/storage/мзб585в.png"></td></tr>
                            <tr><td>Металл</td></tr>
                            <tr><td>Золото белое 585</td></tr>
                            <tr><td>вторичное</td></tr>

                        </table>
                       
                    </td>
                    <td>
                        <table class="type" onclick="selectType('Металлы', 'Металл', 'Золото желтое 585 вторичное', 'мзж585в.png')">
                            <tr><td><img src="../images/storage/мзж585в.png"></td></tr>
                            <tr><td>Металл</td></tr>
                            <tr><td>Золото желтое 585</td></tr>
                            <tr><td>вторичное</td></tr>

                        </table>
                       
                    </td>
                     <td>
                        <table class="type" onclick="selectType('Металлы', 'Металл', 'Золото розовое 585 вторичное', 'мзр585в.png')">
                            <tr><td><img src="../images/storage/мзр585в.png"></td></tr>
                            <tr><td>Металл</td></tr>
                            <tr><td>Золото розовое 585</td></tr>
                            <tr><td>вторичное</td></tr>

                        </table>
                       
                    </td>
                    <td>
                        <table class="type" onclick="selectType('Металлы', 'Металл', 'Золото белое 750 вторичное', 'мзб750в.png')">
                            <tr><td><img src="../images/storage/мзб750в.png"></td></tr>
                            <tr><td>Металл</td></tr>
                            <tr><td>Золото белое 750</td></tr>
                            <tr><td>вторичное</td></tr>

                        </table>
                       
                    </td>
                   <td>
                        <table class="type" onclick="selectType('Металлы', 'Металл', 'Золото желтое 750 вторичное', 'мзж750в.png')">
                            <tr><td><img src="../images/storage/мзж750в.png"></td></tr>
                            <tr><td>Металл</td></tr>
                            <tr><td>Золото желтое 750</td></tr>
                            <tr><td>вторичное</td></tr>

                        </table>
                       
                    </td>
                     <td>
                        <table class="type" onclick="selectType('Металлы', 'Металл', 'Золото розовое 750 вторичное', 'мзр750в.png')">
                            <tr><td><img src="../images/storage/мзр750в.png"></td></tr>
                            <tr><td>Металл</td></tr>
                            <tr><td>Золото розовое 750</td></tr>
                            <tr><td>вторичное</td></tr>

                        </table>
                       
                    </td> 
                </tr>
               
            </table>
        </div>

        
        
        
        
        
        
        
        <table class="types">
                <caption><h2>Лигатуры</h2></caption>
                
                <tr>
                    <td>
                        <table class="type" onclick="selectType('Лигатуры', 'Лигатура', 'серебро', 'лс.png')">
                            <tr><td><img src="../images/storage/лс.png"></td></tr>
                            <tr><td>Лигатура</td></tr>
                            <tr><td>серебро</td></tr>
                        </table>
                       
                    </td>
                    <td>
                        <table class="type" onclick="selectType('Лигатуры', 'Лигатура', 'белое золото', 'лбз.png')">
                            <tr><td><img src="../images/storage/лбз.png"></td></tr>
                            <tr><td>Лигатура</td></tr>
                            <tr><td>белое золото</td></tr>
                        </table>
                       
                    </td>
                    <td>
                        <table class="type" onclick="selectType('Лигатуры', 'Лигатура', 'желтое золото', 'лжз.png')">
                            <tr><td><img src="../images/storage/лжз.png"></td></tr>
                            <tr><td>Лигатура</td></tr>
                            <tr><td>желтое золото</td></tr>

                        </table>
                       
                    </td>
                    <td>
                        <table class="type" onclick="selectType('Лигатуры', 'Лигатура', 'розовое золото', 'лрз.png')">
                            <tr><td><img src="../images/storage/лрз.png"></td></tr>
                            <tr><td>Лигатура</td></tr>
                            <tr><td>розовое золото</td></tr>
                        </table>
                    </td>
                   
                </tr>
        </table>
        <div id="dpol">
        <table class="types">
                <caption><h2>Детали</h2></caption>
                
                <tr>
                    <td>
                        <table class="type" onclick="selectType('Детали', 'Деталь', 'Бронза', 'дб.png')">
                            <tr><td><img src="../images/storage/дб.png"></td></tr>
                            <tr><td>Деталь</td></tr>
                            <tr><td>Бронза</td></tr>
                        </table>
                       
                    </td>
                    <td>
                        <table class="type" onclick="selectType('Детали', 'Деталь', 'Серебро 925', 'дс925.png')">
                            <tr><td><img src="../images/storage/дс925.png"></td></tr>
                            <tr><td>Деталь</td></tr>
                            <tr><td>Серебро 925</td></tr>
                        </table>
                       
                    </td>
                    <td>
                        <table class="type" onclick="selectType('Детали', 'Деталь', 'Золото белое 585', 'дзб585.png')">
                            <tr><td><img src="../images/storage/дзб585.png"></td></tr>
                            <tr><td>Деталь</td></tr>
                            <tr><td>Золото белое 585</td></tr>

                        </table>
                       
                    </td>
                    <td>
                        <table class="type" onclick="selectType('Детали', 'Деталь', 'Золото желтое 585', 'дзж585.png')">
                            <tr><td><img src="../images/storage/дзж585.png"></td></tr>
                            <tr><td>Деталь</td></tr>
                            <tr><td>Золото желтое 585</td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectType('Детали', 'Деталь', 'Золото розовое 585', 'дзр585.png')">
                            <tr><td><img src="../images/storage/дзр585.png"></td></tr>
                            <tr><td>Деталь</td></tr>
                            <tr><td>Золото розовое 585</td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectType('Детали', 'Деталь', 'Золото белое 750', 'дзб750.png')">
                            <tr><td><img src="../images/storage/дзб750.png"></td></tr>
                            <tr><td>Деталь</td></tr>
                            <tr><td>Золото белое 750</td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectType('Детали', 'Деталь', 'Золото желтое 750', 'дзж750.png')">
                            <tr><td><img src="../images/storage/дзж750.png"></td></tr>
                            <tr><td>Деталь</td></tr>
                            <tr><td>Золото желтое 750</td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectType('Детали', 'Деталь', 'Золото розовое 750', 'дзр750.png')">
                            <tr><td><img src="../images/storage/дзр750.png"></td></tr>
                            <tr><td>Деталь</td></tr>
                            <tr><td>Золото розовое 750</td></tr>
                        </table>
                    </td>
                   
                </tr>
        </table>
        <table class="types">
                <caption><h2>Полуфабрикаты</h2></caption>
                
                <tr>
                    <td>
                        <table class="type" onclick="selectType('Полуфабрикаты', 'Полуфабрикат', 'Бронза', 'пб.png')">
                            <tr><td><img src="../images/storage/пб.png"></td></tr>
                            <tr><td>Полуфабрикат</td></tr>
                            <tr><td>Бронза</td></tr>
                        </table>
                       
                    </td>
                    <td>
                        <table class="type" onclick="selectType('Полуфабрикаты', 'Полуфабрикат', 'Серебро 925', 'пc925.png')">
                            <tr><td><img src="../images/storage/пc925.png"></td></tr>
                            <tr><td>Полуфабрикат</td></tr>
                            <tr><td>Серебро 925</td></tr>
                        </table>
                       
                    </td>
                    <td>
                        <table class="type" onclick="selectType('Полуфабрикаты', 'Полуфабрикат', 'Золото белое 585', 'пзб585.png')">
                            <tr><td><img src="../images/storage/пзб585.png"></td></tr>
                            <tr><td>Полуфабрикат</td></tr>
                            <tr><td>Золото белое 585</td></tr>

                        </table>
                       
                    </td>
                    <td>
                        <table class="type" onclick="selectType('Полуфабрикаты', 'Полуфабрикат', 'Золото желтое 585', 'пзж585.png')">
                            <tr><td><img src="../images/storage/пзж585.png"></td></tr>
                            <tr><td>Полуфабрикат</td></tr>
                            <tr><td>Золото желтое 585</td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectType('Полуфабрикаты', 'Полуфабрикат', 'Золото розовое 585', 'пзр585.png')">
                            <tr><td><img src="../images/storage/пзр585.png"></td></tr>
                            <tr><td>Полуфабрикат</td></tr>
                            <tr><td>Золото розовое 585</td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectType('Полуфабрикаты', 'Полуфабрикат', 'Золото белое 750', 'пзб750.png')">
                            <tr><td><img src="../images/storage/пзб750.png"></td></tr>
                            <tr><td>Полуфабрикат</td></tr>
                            <tr><td>Золото белое 750</td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectType('Полуфабрикаты', 'Полуфабрикат', 'Золото желтое 750', 'пзж750.png')">
                            <tr><td><img src="../images/storage/пзж750.png"></td></tr>
                            <tr><td>Полуфабрикат</td></tr>
                            <tr><td>Золото желтое 750</td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectType('Полуфабрикаты', 'Полуфабрикат', 'Золото розовое 750', 'пзр750.png')">
                            <tr><td><img src="../images/storage/пзр750.png"></td></tr>
                            <tr><td>Полуфабрикат</td></tr>
                            <tr><td>Золото розовое 750</td></tr>
                        </table>
                    </td>
                   
                </tr>
        </table>
        </div>
    </div>
    <div class="wrap_names" id = "wrap_names">
            <table class="types">
                <tr>
                    <td>
                        <table class="type" onclick="selectNameOfType('1', (document.getElementById('type_img_name').value).slice(0,-4))" style="margin-top: 75px">
                            <tr><td><img id="select_img_in_name"></td></tr>
                            <tr><td id="select_type_in_name"></td></tr>
                            <tr><td id="select_title_in_name"></td></tr>
                            <tr><td id="select_desc_in_name"></td></tr>

                        </table>
                    </td>
                </tr>          
            </table>
            <table class="types" name="type_1">
                <caption><h2>Основы</h2></caption>
                <tr>
                    <td class="name_td">
                        <table class="type" onclick="selectName('1', '1')">
                            <tr><td><img src="../images/storage/1.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                    <td class="name_td">
                        <table class="type" onclick="selectName('2', '2')">
                            <tr><td><img src="../images/storage/2.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>

                        </table>
                       
                    </td>
                    <td class="name_td">
                        <table class="type" onclick="selectName('3', '3')">
                            <tr><td><img src="../images/storage/3.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                    <td class="name_td">
                        <table class="type" onclick="selectName('4', '4')">
                            <tr><td><img src="../images/storage/4.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                   <td class="name_td">
                        <table class="type" onclick="selectName('5', '5')">
                            <tr><td><img src="../images/storage/5.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                   <td class="name_td">
                        <table class="type" onclick="selectName('6', '6')">
                            <tr><td><img src="../images/storage/6.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                    <td class="name_td">
                        <table class="type" onclick="selectName('7', '7')">
                            <tr><td><img src="../images/storage/7.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                     <td class="name_td">
                        <table class="type" onclick="selectName('8', '8')">
                            <tr><td><img src="../images/storage/8.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                    <td class="name_td">
                        <table class="type" onclick="selectName('9', '9')">
                            <tr><td><img src="../images/storage/9.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                   <td class="name_td">
                        <table class="type" onclick="selectName('10', '10')">
                            <tr><td><img src="../images/storage/10.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                     <td class="name_td">
                        <table class="type" onclick="selectName('11', '11')">
                            <tr><td><img src="../images/storage/11.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="name_td">
                        <table class="type" onclick="selectName('12', '12')">
                            <tr><td><img src="../images/storage/12.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                    <td class="name_td">
                        <table class="type" onclick="selectName('13', '13')">
                            <tr><td><img src="../images/storage/13.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>

                        </table>
                       
                    </td>
                    <td class="name_td">
                        <table class="type" onclick="selectName('14', '14')">
                            <tr><td><img src="../images/storage/14.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                    <td class="name_td">
                        <table class="type" onclick="selectName('15', '15')">
                            <tr><td><img src="../images/storage/15.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                   <td class="name_td">
                        <table class="type" onclick="selectName('16', '16')">
                            <tr><td><img src="../images/storage/16.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                   <td class="name_td">
                        <table class="type" onclick="selectName('17', '17')">
                            <tr><td><img src="../images/storage/17.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                    <td class="name_td">
                        <table class="type" onclick="selectName('18', '18')">
                            <tr><td><img src="../images/storage/18.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                     <td class="name_td">
                        <table class="type" onclick="selectName('19', '19')">
                            <tr><td><img src="../images/storage/19.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                    <td class="name_td">
                        <table class="type" onclick="selectName('20', '20')">
                            <tr><td><img src="../images/storage/20.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                   <td class="name_td">
                        <table class="type" onclick="selectName('21', '21')">
                            <tr><td><img src="../images/storage/21.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                     <td class="name_td">
                        <table class="type" onclick="selectName('22', '22')">
                            <tr><td><img src="../images/storage/22.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="name_td">
                        <table class="type" onclick="selectName('23', '23')">
                            <tr><td><img src="../images/storage/23.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                    <td class="name_td">
                        <table class="type" onclick="selectName('24', '24')">
                            <tr><td><img src="../images/storage/24.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                    <td class="name_td">
                        <table class="type" onclick="selectName('25', '25')">
                            <tr><td><img src="../images/storage/25.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                    <td class="name_td">
                        <table class="type" onclick="selectName('26', '48')">
                            <tr><td><img src="../images/storage/48.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                   <td class="name_td">
                        <table class="type" onclick="selectName('27', '49')">
                            <tr><td><img src="../images/storage/49.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                   <td class="name_td">
                        <table class="type" onclick="selectName('28', '50')">
                            <tr><td><img src="../images/storage/50.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                    <td class="name_td">
                        <table class="type" onclick="selectName('29', '26')">
                            <tr><td><img src="../images/storage/26.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                     <td class="name_td">
                        <table class="type" onclick="selectName('30', '999')">
                            <tr><td><img src="../images/storage/empty.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table class="types" name="type_1">
                <caption><h2>Накладки</h2></caption>
                <tr>
                    <td>
                        <table class="type" onclick="selectName('31', '27')">
                            <tr><td><img src="../images/storage/27.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectName('32', '28')">
                            <tr><td><img src="../images/storage/28.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>

                        </table>
                       
                    </td>
                    <td>
                        <table class="type" onclick="selectName('33', '29')">
                            <tr><td><img src="../images/storage/29.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectName('34', '30')">
                            <tr><td><img src="../images/storage/30.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                   <td>
                        <table class="type" onclick="selectName('35', '31')">
                            <tr><td><img src="../images/storage/31.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                   <td>
                        <table class="type" onclick="selectName('36', '32')">
                            <tr><td><img src="../images/storage/32.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectName('37', '33')">
                            <tr><td><img src="../images/storage/33.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                     <td>
                        <table class="type" onclick="selectName('38', '34')">
                            <tr><td><img src="../images/storage/34.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectName('39', '35')">
                            <tr><td><img src="../images/storage/35.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                   <td>
                        <table class="type" onclick="selectName('40', '36')">
                            <tr><td><img src="../images/storage/36.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                     <td>
                        <table class="type" onclick="selectName('41', '37')">
                            <tr><td><img src="../images/storage/37.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table class="type" onclick="selectName('42', '999')">
                            <tr><td><img src="../images/storage/empty.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectName('43', '51')">
                            <tr><td><img src="../images/storage/51.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>

                        </table>
                       
                    </td>
                    <td>
                        <table class="type" onclick="selectName('44', '999')">
                            <tr><td><img src="../images/storage/empty.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectName('45', '52')">
                            <tr><td><img src="../images/storage/52.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                   <td>
                        <table class="type" onclick="selectName('46', '53')">
                            <tr><td><img src="../images/storage/53.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                   <td>
                        <table class="type" onclick="selectName('47', '54')">
                            <tr><td><img src="../images/storage/54.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectName('48', '55')">
                            <tr><td><img src="../images/storage/55.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                     <td>
                        <table class="type" onclick="selectName('49', '56')">
                            <tr><td><img src="../images/storage/56.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectName('50', '999')">
                            <tr><td><img src="../images/storage/empty.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                   <td>
                        <table class="type" onclick="selectName('51', '999')">
                            <tr><td><img src="../images/storage/empty.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                     <td>
                        <table class="type" onclick="selectName('52', '999')">
                            <tr><td><img src="../images/storage/empty.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table class="type" onclick="selectName('53', '999')">
                            <tr><td><img src="../images/storage/empty.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectName('54', '999')">
                            <tr><td><img src="../images/storage/empty.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>

                        </table>
                       
                    </td>
                    <td>
                        <table class="type" onclick="selectName('55', '999')">
                            <tr><td><img src="../images/storage/empty.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectName('56', '999')">
                            <tr><td><img src="../images/storage/empty.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table class="types" name="type_1">
                <caption><h2>Задние части</h2></caption>  
                <tr>
                    <td>
                        <table class="type" onclick="selectName('57', '38')">
                            <tr><td><img src="../images/storage/38.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectName('58', '39')">
                            <tr><td><img src="../images/storage/39.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>

                        </table>
                       
                    </td>
                    <td>
                        <table class="type" onclick="selectName('59', '40')">
                            <tr><td><img src="../images/storage/40.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectName('60', '41')">
                            <tr><td><img src="../images/storage/41.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                     <td>
                        <table class="type" onclick="selectName('61', '42')">
                            <tr><td><img src="../images/storage/42.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table class="types" name="type_1">
                <caption><h2>Ножки</h2></caption>  
                <tr>
                    <td>
                        <table class="type" onclick="selectName('62', '43')">
                            <tr><td><img src="../images/storage/43.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectName('63', '44')">
                            <tr><td><img src="../images/storage/44.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>

                        </table>
                       
                    </td>
                    <td>
                        <table class="type" onclick="selectName('64' '45')">
                            <tr><td><img src="../images/storage/45.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectName('65', '57')">
                            <tr><td><img src="../images/storage/57.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                     <td>
                        <table class="type" onclick="selectName('66', '46')">
                            <tr><td><img src="../images/storage/46.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectName('67', '47')">
                            <tr><td><img src="../images/storage/47.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectName('68', '57')">
                            <tr><td><img src="../images/storage/57.jpg"></td></tr>
                            <tr><td name="kind_of_name"></td></tr>
                            <tr><td name="name"></td></tr>
                            <tr><td name="desc"></td></tr>
                            <tr><td name="type_of_name"></td></tr>
                        </table>
                    </td>
                </tr>
            </table> 
        <!--    <table class="types" name="type_2">
                <caption><h2></h2></caption>  
                <tr>
                    <td>
                        <table class="type" onclick="selectName2('1')">
                            <tr><td><img src="../images/storage/polu/1p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectName2('2')">
                            <tr><td><img src="../images/storage/empty.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectName2('3')">
                            <tr><td><img src="../images/storage/polu/3p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectName2('4')">
                            <tr><td><img src="../images/storage/polu/4p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
                     <td>
                        <table class="type" onclick="selectName2('5')">
                            <tr><td><img src="../images/storage/polu/5p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectName2('6')">
                            <tr><td><img src="../images/storage/polu/6p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectName2('7')">
                            <tr><td><img src="../images/storage/polu/7p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectName2('8')">
                            <tr><td><img src="../images/storage/polu/8p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectName2('9')">
                            <tr><td><img src="../images/storage/polu/9p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectName2('10')">
                            <tr><td><img src="../images/storage/polu/10p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectName2('11')">
                            <tr><td><img src="../images/storage/polu/11p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table class="type" onclick="selectName2('12')">
                            <tr><td><img src="../images/storage/polu/12p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectName2('13')">
                            <tr><td><img src="../images/storage/polu/13p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectName2('14')">
                            <tr><td><img src="../images/storage/polu/14p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectName2('15')">
                            <tr><td><img src="../images/storage/polu/15p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
                     <td>
                        <table class="type" onclick="selectName2('16')">
                            <tr><td><img src="../images/storage/polu/16p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectName2('17')">
                            <tr><td><img src="../images/storage/polu/17p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectName2('18')">
                            <tr><td><img src="../images/storage/polu/18p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectName2('19')">
                            <tr><td><img src="../images/storage/polu/19p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectName2('20')">
                            <tr><td><img src="../images/storage/polu/20p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectName2('21')">
                            <tr><td><img src="../images/storage/polu/21p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectName2('22')">
                            <tr><td><img src="../images/storage/polu/22p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table class="type" onclick="selectName2('23')">
                            <tr><td><img src="../images/storage/empty.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectName2('24')">
                            <tr><td><img src="../images/storage/polu/24p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectName2('25')">
                            <tr><td><img src="../images/storage/empty.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectName2('26')">
                            <tr><td><img src="../images/storage/empty.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
                     <td>
                        <table class="type" onclick="selectName2('27')">
                            <tr><td><img src="../images/storage/polu/27p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectName2('28')">
                            <tr><td><img src="../images/storage/polu/28p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="type" onclick="selectName2('29')">
                            <tr><td><img src="../images/storage/polu/29p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
                </tr>
            </table>        
    -->
			<table class="types" name = "type 2">
				<caption><h2></h2></caption>  
				<tr>
					<td>
                        <table class="type" onclick="selectName2('1')">
                            <tr><td><img src="../images/storage/polu/1p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
				
					<td>
                        <table class="type" onclick="selectName2('2')">
                            <tr><td><img src="../images/storage/empty.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
					<td>
                        <table class="type" onclick="selectName2('2')">
                            <tr><td><img src="../images/storage/empty.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
					<td>
                        <table class="type" onclick="selectName2('3')">
                            <tr><td><img src="../images/storage/polu/3p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
					<td>
                        <table class="type" onclick="selectName2('4')">
                            <tr><td><img src="../images/storage/polu/4p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
					<td>
                        <table class="type" onclick="selectName2('5')">
                            <tr><td><img src="../images/storage/polu/5p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
					<td>
                        <table class="type" onclick="selectName2('5')">
                            <tr><td><img src="../images/storage/polu/5pRe.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
					<td>
                        <table class="type" onclick="selectName2('6')">
                            <tr><td><img src="../images/storage/polu/6p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
					<td>
                        <table class="type" onclick="selectName2('6')">
                            <tr><td><img src="../images/storage/polu/6pRe.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
					<td>
                        <table class="type" onclick="selectName2('7')">
                            <tr><td><img src="../images/storage/polu/7p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
					</td>
						<td>
                        <table class="type" onclick="selectName2('7')">
                            <tr><td><img src="../images/storage/polu/7pRe.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
                    
				</tr>
				<tr>
					<td>
                        <table class="type" onclick="selectName2('8')">
                            <tr><td><img src="../images/storage/polu/8p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
					</td>
						<td>
                        <table class="type" onclick="selectName2('8')">
                            <tr><td><img src="../images/storage/polu/8pRe.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
					<td>
                        <table class="type" onclick="selectName2('9')">
                            <tr><td><img src="../images/storage/polu/9p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
					</td>
						<td>
                        <table class="type" onclick="selectName2('9')">
                            <tr><td><img src="../images/storage/polu/9pRe.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
					<td>
                        <table class="type" onclick="selectName2('10')">
                            <tr><td><img src="../images/storage/polu/10p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
					</td>
						<td>
                        <table class="type" onclick="selectName2('10')">
                            <tr><td><img src="../images/storage/polu/10pRe.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
					<td>
                        <table class="type" onclick="selectName2('11')">
                            <tr><td><img src="../images/storage/polu/11p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
					</td>
						<td>
                        <table class="type" onclick="selectName2('11')">
                            <tr><td><img src="../images/storage/polu/11pRe.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
					<td>
                        <table class="type" onclick="selectName2('12')">
                            <tr><td><img src="../images/storage/polu/12p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
					</td>
						<td>
                        <table class="type" onclick="selectName2('12')">
                            <tr><td><img src="../images/storage/polu/12pRe.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
				</tr>
				
				<tr>
					<td>
                        <table class="type" onclick="selectName2('13')">
                            <tr><td><img src="../images/storage/polu/13p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
					</td>
						<td>
                        <table class="type" onclick="selectName2('13')">
                            <tr><td><img src="../images/storage/polu/13pRe.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
					<td>
                        <table class="type" onclick="selectName2('14')">
                            <tr><td><img src="../images/storage/polu/14p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
					</td>
						<td>
                        <table class="type" onclick="selectName2('14')">
                            <tr><td><img src="../images/storage/polu/14pRe.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
					<td>
                        <table class="type" onclick="selectName2('15')">
                            <tr><td><img src="../images/storage/polu/15p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
					</td>
						<td>
                        <table class="type" onclick="selectName2('15')">
                            <tr><td><img src="../images/storage/polu/15pRe.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
					<td>
                        <table class="type" onclick="selectName2('16')">
                            <tr><td><img src="../images/storage/polu/16p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
					</td>
						<td>
                        <table class="type" onclick="selectName2('16')">
                            <tr><td><img src="../images/storage/polu/16pRe.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
					<td>
                        <table class="type" onclick="selectName2('17')">
                            <tr><td><img src="../images/storage/polu/17p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
					</td>
						<td>
                        <table class="type" onclick="selectName2('17')">
                            <tr><td><img src="../images/storage/polu/17pRe.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
				</tr>
				<tr>
					<td>
                        <table class="type" onclick="selectName2('18')">
                            <tr><td><img src="../images/storage/polu/18p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
					</td>
						<td>
                        <table class="type" onclick="selectName2('18')">
                            <tr><td><img src="../images/storage/polu/18pRe.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
					<td>
                        <table class="type" onclick="selectName2('19')">
                            <tr><td><img src="../images/storage/polu/19p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
					</td>
						<td>
                        <table class="type" onclick="selectName2('19')">
                            <tr><td><img src="../images/storage/polu/19pRe.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
					<td>
                        <table class="type" onclick="selectName2('20')">
                            <tr><td><img src="../images/storage/polu/20p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
					</td>
						<td>
                        <table class="type" onclick="selectName2('20')">
                            <tr><td><img src="../images/storage/polu/20pRe.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
					<td>
                        <table class="type" onclick="selectName2('21')">
                            <tr><td><img src="../images/storage/polu/21p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
					</td>
						<td>
                        <table class="type" onclick="selectName2('21')">
                            <tr><td><img src="../images/storage/polu/21pRe.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
					<td>
                        <table class="type" onclick="selectName2('22')">
                            <tr><td><img src="../images/storage/polu/22p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
					</td>
						<td>
                        <table class="type" onclick="selectName2('22')">
                            <tr><td><img src="../images/storage/polu/22pRe.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
				</tr>
				<tr>
				</td>
						<td>
                        <table class="type" onclick="selectName2('23')">
                            <tr><td><img src="../images/storage/empty.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
					</td>
						<td>
                        <table class="type" onclick="selectName2('23')">
                            <tr><td><img src="../images/storage/empty.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
					<td>
                        <table class="type" onclick="selectName2('24')">
                            <tr><td><img src="../images/storage/polu/24p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
					</td>
						<td>
                        <table class="type" onclick="selectName2('24')">
                            <tr><td><img src="../images/storage/polu/24pRe.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
					<td>
                        <table class="type" onclick="selectName2('25')">
                            <tr><td><img src="../images/storage/empty.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
					</td>
						<td>
                        <table class="type" onclick="selectName2('25')">
                            <tr><td><img src="../images/storage/empty.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
					<td>
                        <table class="type" onclick="selectName2('26')">
                            <tr><td><img src="../images/storage/empty.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
					</td>
						<td>
                        <table class="type" onclick="selectName2('26')">
                            <tr><td><img src="../images/storage/empty.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
					<td>
                        <table class="type" onclick="selectName2('27')">
                            <tr><td><img src="../images/storage/polu/27p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
					</td>
						<td>
                        <table class="type" onclick="selectName2('27')">
                            <tr><td><img src="../images/storage/polu/27pRe.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
				</tr>
				<tr>
				<td>
                        <table class="type" onclick="selectName2('28')">
                            <tr><td><img src="../images/storage/polu/28p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
					</td>
						<td>
                        <table class="type" onclick="selectName2('28')">
                            <tr><td><img src="../images/storage/polu/28pRe.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
					<td>
                        <table class="type" onclick="selectName2('29')">
                            <tr><td><img src="../images/storage/polu/29p.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
					</td>
						<td>
                        <table class="type" onclick="selectName2('29')">
                            <tr><td><img src="../images/storage/polu/29pRe.jpg"></td></tr>
                            <tr><td name="kind_of_name_2"></td></tr>
                            <tr><td name="name_2"></td></tr>
                            <tr><td name="desc_2"></td></tr>
                            <tr><td name="type_of_name_2"></td></tr>
                        </table>
                    </td>
				</tr>
			</table>
	</div>
</section>

<script>
if (localStorage['success'] == 'true') {
    documentч.getElementById('textSave').style.display = 'inline-block';
    setTimeout(function(){
        // document.getElementById('textSave').style.display = 'none';
        $('#textSave').fadeOut('fast')
    },2000);
}

localStorage['success'] = 'false';
var url = window.location.href;
var pieces = url.split(/[=]+/);
if(pieces[pieces.length-1] == 'true') {
    localStorage['success'] = 'true';
    document.location.href = "http://erp.sergeysudakov.ru/storage/add";

}


// document.getElementById('value').style.color = "#CCCCCC";
// $("#value").prop('disabled', 'disabled');

document.getElementById('selectStatus').style.color = "#CCCCCC";
document.getElementById('selectStatus_send').value = "null";
$("#selectStatus").prop('disabled', 'disabled');


document.getElementById('type_img_name').value = "empty.jpg";
document.getElementById('name_img_name').value = "empty.jpg";
document.getElementById('type_title_send').value = "";
document.getElementById('type_desc_send').value = "";

document.getElementById('name_title_send').value = "";
document.getElementById('name_desc_send').value = "";
document.getElementById('name_type_send').value = "";
document.getElementById('date_send').value = "";
document.getElementById('time_send').value = "";


clock();
var arrow = document.getElementById('arrow');
var arrowName = document.getElementById('arroww');

var visible = false;

var visibleNames = false;

var usingName = true;

var showGreyNamesAllowed = true;

var type_selected = false;
var name_selected = false;

var testStatus = false;

var isSelectedName2;

var greys_types = document.getElementsByName('grey_table_types');
var greys_names = document.getElementsByName('grey_table_names');

isFormFilled = false;

var names = ['Щит под дерево с просветом', 'Квадрат под дерево с просветом', 'Круг под дерево с просветом', 'Щит под дерево с орнаментом', 'Квадрат под дерево с орнаментом', 'Круг под дерево с орнаментом', '8 граней с орнаментом', '8 граней с желобом', '8 граней под гравировку', 'Спаси и сохрани с надписью', 'Спаси и сохрани основа с орнаментом', 'Спаси и сохрани под гравировку', 'Щит европа стандартный', 'Щит европа с орнаментом', 'Круг косичка', 'Квадрат косичка', 'Прямоугольная косичка', 'Прямоугольник готика под бриллиант', 'под премиум круглый', 'под премиум квадратный', 'Щит ФСБ', 'Омниа квадрат', 'Омниа круг', 'Щит облегченный', 'Фантом', 'Созвездие круг большой', 'Созвездие фон', 'Круг малый', 'Пупырки', 'под винтажный куб', 'Геральдика под монограмму', 'Геральдика классическая', 'Геральдика ребристая с камнями', 'Геральдика под эмаль со сферами по периметру', 'Геральдика под эмаль с орнаментом по ободку', 'Геральдика Щит и меч', 'Круг орел', 'Фантом', 'под премиум круглый', 'под премиум квадратный', 'Лев плоский (царь зверей)', 'Щит под гравировку', 'Лев классический (царь зверей)', 'Лев античный (царь зверей)', 'Тигр (царь зверей)', 'Лис (царь зверей)', 'Бульдог (царь зверей)', 'Волк (царь зверей)', 'Медведь (царь зверей)', '8 граней под гравировку большая', '8 граней под гравировку малая', 'Грани характера под гравировку круглая', 'Грани характера Звери', 'Грани характера Георгий победоносец', 'Грани характера Рыбы', 'Грани характера Оружие', 'Созвездие Круг большой', 'Созвездие Круг малый', 'Фантом', 'под винтажный куб', 'Лев плоский (царь зверей)', 'Цельнолитая рефленая', 'малая поворотная', 'Задняя часть малой поворотной ножки', 'Пружина малой поворотной ножки', 'Большая поворотная', 'Задняя часть большой поворотной ножки', 'Пружина большой поворотной ножки'];

var names2 = ['Фантом (задняя часть с малой поворотной ножкой)','Фантом основа с покрытием','Созвездие (основа + задняя часть с малой поворотной ножкой)','Круг малый  (основа + задняя часть с малой поворотной ножкой)','Щит под дерево с орнаментом (основа + ножка)','Круг под дерево с орнаментом (основа + ножка)','Квадрат под дерево с орнаментом (основа + ножка)','Щит под дерево с просветом  (основа + ножка)','Круг под дерево с просветом (основа + ножка)', 'Квадрат под дерево с просветом (основа + ножка)', '8 граней с орнаментом (основа + ножка)', '8 граней с орнаментом (основа + ножка)', '8 граней с орнаментом (основа + ножка)', 'Щит европа стандартный (основа + ножка)','Щит европа стандартный (основа + ножка)','Щит европа стандартный (основа + ножка)', 'Прямоугольник косичка (основа + ножка)', 'Круг косичка (основа + ножка)', 'Спаси и сохрани с орнаментом (основа + ножка)','Спаси и сохрани под гравировку (основа + ножка)','Спаси и сохрани с надписью (основа + ножка)', 'Премиум квадратный (основа + ножка)','Накладка под премиум квадратный (отполированная)','Премиум круглый (основа + ножка)','Накладка под премиум круглый (отполированная)','Винтажный куб (основа + ножка)','Омниа круг (основа + ножка)','Омниа квадрат (основа + ножка)','Прямоугольник готика под бриллиант (основа + ножка)'];

var names_short = ['Щит под дерево', 'Квадрат под дерево', 'Круг под дерево', 'Щит под дерево', 'Квадрат под дерево', 'Круг под дерево', '8 граней', '8 граней', '8 граней', 'Спаси и сохрани', 'Спаси и сохрани', 'Спаси и сохрани', 'Щит европа', 'Щит европа', 'Круг косичка', 'Квадрат косичка', 'Прямоугольная косичка', 'Прямоугольник готика', 'под премиум', 'под премиум', 'Щит ФСБ', 'Омниа квадрат', 'Омниа круг', 'Щит облегченный', 'Фантом', 'Созвездие круг', 'Созвездие фон', 'Круг малый', 'Пупырки', 'под винтажный', 'Геральдика', 'Геральдика классическая', 'Геральдика ребристая', 'Геральдика под эмаль', 'Геральдика под эмаль', 'Геральдика', 'Круг орел', 'Фантом', 'под премиум круглый', 'под премиум квадратный', 'Лев плоский', 'Щит под гравировку', 'Лев классический', 'Лев античный', 'Тигр', 'Лис', 'Бульдог', 'Волк', 'Медведь', '8 граней под гравировку', '8 граней под гравировку', 'Грани характера', 'Грани характера', 'Грани характера', 'Грани характера', 'Грани характера', 'Созвездие', 'Созвездие', 'Фантом', 'под винтажный куб', 'Лев плоский', 'Цельнолитая рефленая', 'малая поворотная', 'Задняя часть малой поворотной ножки', 'Пружина малой поворотной ножки', 'Большая поворотная', 'Задняя часть большой поворотной ножки', 'Пружина большой поворотной ножки'];


var descs = ['с просветом', ' с просветом', 'с просветом', 'с орнаментом', 'с орнаментом', 'с орнаментом', 'с орнаментом', 'с желобом', 'под гравировку', 'с надписью', 'основа с орнаментом', 'под гравировку', 'стандартный', 'с орнаментом', ' ', ' ', ' ', 'под бриллиант', 'круглый', 'квадратный', ' ', ' ', ' ', ' ', ' ', 'большой', ' ', ' ', ' ', ' ', 'куб', 'под монограмму', 'с камнями', 'со сферами по периметру', 'с орнаментом по ободку', 'Щит и меч', ' ', ' ', ' ', ' ', '(царь зверей)', ' ', '(царь зверей)', '(царь зверей)', '(царь зверей)', '(царь зверей)', '(царь зверей)', '(царь зверей)', '(царь зверей)', 'большая', 'малая', 'под гравировку круглая', 'Звери', 'Георгий победоносец', 'Рыбы', 'Оружие', 'Круг большой', 'Круг малый', ' ', ' ', '(царь зверей)', ' ', ' ', ' ', ' ', ' ', ' ', ' '];


hide_greys_types();
hide_greys_names();

function hide_greys_types() {
    for (var i = 0; i <= greys_types.length - 1; i++) {
        greys_types[i].style.display = 'none';
    }
}

function show_greys_types() {
    for (var i = 0; i <= greys_types.length - 1; i++) {
        greys_types[i].style.display = 'block';
    }
}

function hide_greys_names() {
    for (var i = 0; i <= greys_names.length - 1; i++) {
        greys_names[i].style.display = 'none';
    }
}

function show_greys_names() {
    if (showGreyNamesAllowed)
        for (var i = 0; i <= greys_names.length - 1; i++) {
            greys_names[i].style.display = 'block';
        }
}


function checkMassaFormat() {
    var massa = Number(document.getElementById('massa').value);
    document.getElementById('massa').value = massa.toFixed(2);
}


function checkField(){

    isFormFilled = true;
    
    if(document.getElementById("selectTo").value==""){
        document.getElementById("selectTo").style.border = "1px solid #8B0000";
        document.getElementById("selectTo").style.borderRadius = "5px";
        isFormFilled = false;
    } else {
        document.getElementById("selectTo").style.border = "0px";
        document.getElementById("selectTo").style.borderRadius = "0px";
    }
    if(document.getElementById("selectFrom").value==""){
        document.getElementById("selectFrom").style.border = "1px solid #8B0000";
        document.getElementById("selectFrom").style.borderRadius = "5px";
        isFormFilled = false;
    } else {
        document.getElementById("selectFrom").style.border = "0px";
        document.getElementById("selectFrom").style.borderRadius = "0px";

    }
    if(document.getElementById("type_title_send").value==""){
        document.getElementById("selectType").style.border = "1px solid #8B0000";
        document.getElementById("selectType").style.borderRadius = "5px";
        isFormFilled = false;
    } else {
        document.getElementById("selectType").style.border = "0px";
        document.getElementById("selectType").style.borderRadius = "0px";

    }
    if(document.getElementById("selectOperation").value==""){
        document.getElementById("selectOperation").style.border = "1px solid #8B0000";
        document.getElementById("selectOperation").style.borderRadius = "5px";
        isFormFilled = false;
    } else {

        document.getElementById("selectOperation").style.border = "0px";
        document.getElementById("selectOperation").style.borderRadius = "0px";

    }
    if(document.getElementById("name_title_send").value==""){
        document.getElementById("selectName").style.border = "1px solid #8B0000";
        document.getElementById("selectName").style.borderRadius = "5px";
        isFormFilled = false;
    } else {
        document.getElementById("selectName").style.border = "0px";
        document.getElementById("selectName").style.borderRadius = "0px";
    }
    if(document.getElementById("selectStatus_send").value==""){
        document.getElementById("selectStatus").style.border = "1px solid #8B0000";
        document.getElementById("selectStatus").style.borderRadius = "5px";
        isFormFilled = false;
    } else {
        document.getElementById("selectStatus").style.border = "0px";
        document.getElementById("selectStatus").style.borderRadius = "0px";
    }

    if (isFormFilled)
	{
        $('#future').removeAttr('disabled');
	}
        // document.getElementById('future').setAttribute('disabled', 'disabled');
    
}

function selectOnChange(){
    document.getElementById('selectStatus_send').value=document.getElementById('selectStatus').value;
}


function showFun() {
    if(visible) {
        document.getElementById('wrap_types' ).style.display = 'none';
    
        hide_greys_types();

        visible = false;
        arrow.classList.toggle('rotated');
    } else {
        document.getElementById('wrap_types' ).style.display = 'block';
        if(visibleNames) {
            document.getElementById('wrap_names' ).style.display = 'none';
            visibleNames = false;
        }
        
        show_greys_types();
        hide_greys_names();

        if(document.getElementById("dpol").style.display == 'none'){
            hide_greys_types();
            hide_greys_names();
            greys_types[0].style.display = 'block';
        } else {
            show_greys_types();
        }

        visible = true;
        arrow.classList.toggle('rotated');
    }
}

function compareStrings(id1, id2){
    if((document.getElementById(id1).value == document.getElementById(id2).value) && (document.getElementById(id1).value!='') && (document.getElementById(id2).value!='')){
        // console.log(document.getElementById(id1).value);
        // $("#selectName").prop('disabled', 'disabled');
        // $("#selectOperation").prop('disabled', 'disabled');
        // $("#selectType").prop('disabled', 'disabled');
        // document.getElementById("selectType").onclick = function(){};
        // $("#value").prop('disabled', 'disabled');
        // $("#massa").prop('disabled', 'disabled');
    }else{
        
        // $("#selectName").removeAttr("disabled");
        // $("#selectOperation").removeAttr("disabled");
        // $("#selectType").removeAttr("disabled");
        // document.getElementById("selectType").onclick = showFun;
        // $("#value").removeAttr("disabled");
        // $("#massa").removeAttr("disabled");
    }
}

function showNames() {
    if(visibleNames && usingName) {
        document.getElementById('wrap_types' ).style.display = 'none';
        arrowName.classList.toggle('rotated');
        document.getElementById('wrap_names' ).style.display = 'none';

        hide_greys_names();

        visibleNames = false;
    } else if(!visibleNames  && type_selected && usingName){
        arrowName.classList.toggle('rotated');
        document.getElementById('wrap_names' ).style.display = 'block';

        if (visible) {
            document.getElementById('wrap_types' ).style.display = 'none';
            visible = false;
        }
        greys_names[0].style.display = 'block';
        show_greys_names();
        hide_greys_types();

        visibleNames = true;
    }
}

function clock() {
    var d = new Date();
    
    var hours = d.getHours();
    var minutes = d.getMinutes();
    var seconds = d.getSeconds();

    var dd = d.getDate();
    var mm = d.getMonth()+1; //January is 0!
    var yy = d.getFullYear().toString().substr(-2);

    if(dd < 10) {
        dd = '0'+dd
    } 

    if(mm < 10) {
        mm = '0'+mm
    } 

    document.getElementById('date').innerHTML = dd + '.' + mm + '.' + yy;
   
    if (hours <= 9) hours = "0" + hours;
    if (minutes <= 9) minutes = "0" + minutes;
    if (seconds <= 9) seconds = "0" + seconds;

    date_time = hours + ":" + minutes;
    document.getElementById("time").innerHTML = date_time;

    document.getElementById('date_send').value = dd + '.' + mm + '.' + yy;
    document.getElementById('time_send').value = date_time;

    setTimeout("clock()", 1000);
}

function selectType(type, name, desc, src) {

    document.getElementById('type_title_send').value = name;
    document.getElementById('type_desc_send').value = desc;

    $("#img_type").attr("src", "../images/storage/" + src);
    document.getElementById('type_img_name').value = src;

    document.getElementById('type_selected_title').innerText = name;
    document.getElementById('type_selected_desc').innerText = desc;
    
    if(name == "Металл" || name == "Лигатура"){

        document.getElementById('value').value = 0;
        document.getElementById('value').setAttribute('onfocus', 'this.blur()');
        document.getElementById('value').style.color = "#e2e2e2";

        
        //document.getElementById('selectStatus').value = 'null';
        document.getElementById("name_title_send").value = "null";
        
        document.getElementById('selectStatus').style.color = "#CCCCCC";
        $("#selectStatus").prop('disabled', 'disabled');
        document.getElementById('selectStatus_send').value='null';
        
        document.getElementById('nonselected_name').setAttribute('class', '');
        document.getElementById('selected_name').setAttribute('class', 'hidden');

        document.getElementById('selectName').style.color = "#CCCCCC";
        
        document.getElementById("selectName").style.border = "0px solid #fff8ca";
        document.getElementById("selectName").style.borderRadius = "0px";
        
        $("#selectName").prop('disabled', 'disabled');

        selectNameOfType('1', (document.getElementById('type_img_name').value).slice(0,-4));
        
        usingName = false;
    } else {

        $("#value").removeAttr("onfocus");
        document.getElementById('value').style.color = "";
        document.getElementById('selectStatus_send').value=document.getElementById('selectStatus').value;
        document.getElementById("selectStatus").style.border = "0px solid #fff8ca";
        document.getElementById("selectStatus").style.borderRadius = "0px";

        if (document.getElementById('selectFrom').value != "Склад") {
            document.getElementById('selectStatus').style.color = "";
            $("#selectStatus").removeAttr('disabled');
        }
        
        document.getElementById("name_title_send").value = ""; 
        if(testStatus == true){
        //  $("#selectStatus option[value='']").css("display","block");
        //  $("#selectStatus").removeAttr("disabled");
        //  document.getElementById('selectStatus').style.color = "#3d3d3d";
        //document.getElementById('selectStatus_send').value=document.getElementById('selectStatus').value;
        }
        
        usingName = true;
        
        $("#selectName").removeAttr("disabled");
        document.getElementById('selectName').style.color = "#3d3d3d";
    }

    if (name == "Деталь") {
        if (isSelectedName2) {
            document.getElementById('nonselected_name').setAttribute('class', '');
            document.getElementById('selected_name').setAttribute('class', 'hidden');
        } 
        showGreyNamesAllowed = true;
    } else {
        if (!isSelectedName2) {
            document.getElementById('nonselected_name').setAttribute('class', '');
            document.getElementById('selected_name').setAttribute('class', 'hidden');
        } 
        showGreyNamesAllowed = false;
    }
    

    if(document.getElementById('selectFrom').value == 'Склад'){
        document.getElementById('selectStatus_send').value = 'null';
    }
    document.getElementById('wrap_types' ).style.display = 'none';

    hide_greys_types();
    hide_greys_names();

    document.getElementById('nonselected_type').setAttribute('class', 'hidden');
    document.getElementById('selected_type').setAttribute('class', 'select_tp');
    document.getElementById('selected_type').setAttribute('style', 'padding:0');
    visible = false;
    type_selected = true;

    document.getElementById('select_type_in_name').innerText = type;
    document.getElementById('select_title_in_name').innerText = name;
    document.getElementById('select_desc_in_name').innerText = desc;
    if(document.getElementById('select_type_in_name').innerHTML=='Полуфабрикаты'){
        $("#select_img_in_name").attr("src", "../images/storage/pfUnic.jpg");
        $("#img_name").attr("src", "../images/storage/pfUnic.jpg");
    }else if(document.getElementById('select_type_in_name').innerHTML=='Детали'){
        $("#select_img_in_name").attr("src", "../images/storage/dtUnic.jpg");
    }else{
        $("#select_img_in_name").attr("src", "../images/storage/" + src);
    }
    
    generateNames(name, name + "" + desc);
    if(name == "Металл" || name == "Лигатура")
        selectNameOfType('1', (document.getElementById('type_img_name').value).slice(0,-4));
    else resetName();
    
}

function resetName() {
    document.getElementById('nonselected_name').setAttribute('class', '');
    document.getElementById('selected_name').setAttribute('class', 'hidden');

     document.getElementById('name_title_send').value = "";
    document.getElementById('name_desc_send').value = "";
}

function selectNameOfType(number, number_img) {

    if(document.getElementById('select_type_in_name').innerHTML=='Полуфабрикаты'){
        document.getElementById('name_img_name').value = 'pfUnic.jpg';
        $("#img_name").attr("src", "../images/storage/pfUnic.jpg");
    }else if(document.getElementById('select_type_in_name').innerHTML=='Детали'){
        document.getElementById('name_img_name').value = 'dtUnic.jpg';  
        $("#img_name").attr("src", "../images/storage/dtUnic.jpg");
    }else{
        $("#img_name").attr("src", "../images/storage/" + number_img + '.png');
        document.getElementById('name_img_name').value = number_img + '.png';
    }
    
    number--;
    isSelectedName2 = false;
  //  document.getElementById('name_title_send').value = number < 30 ? "Основы" : number < 56 ? "Накладки" : number < 61 ? "Задние части" : "Ножки";
    document.getElementById('name_title_send').value = document.getElementById('select_type_in_name').innerHTML;
    document.getElementById('name_desc_send').value = document.getElementById('select_desc_in_name').innerHTML;
  //  document.getElementById('name_type_send').value = document.getElementById('select_desc_in_name').innerHTML;

  //  document.getElementById('name_selected_title').innerText = number < 30 ? "Основы" : number < 56 ? "Накладки" : number < 61 ? "Задние части" : "Ножки";
    document.getElementById('name_selected_title').innerText = document.getElementById('select_type_in_name').innerHTML;
    document.getElementById('name_selected_desc').innerHTML = document.getElementById('select_desc_in_name').innerHTML;
  //  document.getElementById('name_selected_type').innerHTML = document.getElementById('select_desc_in_name').innerHTML;
    
    document.getElementById('nonselected_name').setAttribute('class', 'hidden');
    document.getElementById('selected_name').setAttribute('class', 'select_nm');
    document.getElementById('selected_name').setAttribute('style', 'padding:0');
    document.getElementById('wrap_names' ).style.display = 'none';
    hide_greys_names();

    type_selected = true;
    visibleNames = false;
}

function selectName(number, number_img) {


    document.getElementById('name_img_name').value = number_img + '.jpg';
    isSelectedName2 = false;

    $("#img_name").attr("src", "../images/storage/" + number_img + '.jpg');
    number--;

    document.getElementById('name_title_send').value = number < 30 ? "Основы" : number < 56 ? "Накладки" : number < 61 ? "Задние части" : "Ножки";
    document.getElementById('name_desc_send').value = names[number];
    document.getElementById('name_type_send').value = document.getElementById('select_title_in_name').innerHTML + " " + document.getElementById('select_desc_in_name').innerHTML;

    document.getElementById('name_selected_title').innerText = number < 30 ? "Основы" : number < 56 ? "Накладки" : number < 61 ? "Задние части" : "Ножки";
    document.getElementById('name_selected_desc').innerHTML = names[number];
    document.getElementById('name_selected_type').innerHTML = document.getElementById('select_title_in_name').innerHTML + " " + document.getElementById('select_desc_in_name').innerHTML;

    document.getElementById('nonselected_name').setAttribute('class', 'hidden');
    document.getElementById('selected_name').setAttribute('class', 'select_nm');
    document.getElementById('selected_name').setAttribute('style', 'padding:0');
    document.getElementById('wrap_names' ).style.display = 'none';
    hide_greys_names();

    type_selected = true;
    visibleNames = false;
}

function selectName2(number) {
    number--;

    document.getElementById('name_title_send').value = '';
    document.getElementById('name_desc_send').value = names2[number];
    document.getElementById('name_type_send').value = document.getElementById('select_title_in_name').innerHTML + " " + document.getElementById('select_desc_in_name').innerHTML;


    document.getElementById('name_img_name').value = "empty.jpg";
    isSelectedName2 = true;
    
    var scr = "../images/storage/polu/"+(number+1)+"p.jpg";
    
    $.ajax({
        url:scr,
        type:'HEAD',
        error:
            function(){
                $("#img_name").attr("src", "../images/storage/empty.jpg");
            },
        success:
            function(){
                $("#img_name").attr("src", "../images/storage/polu/"+(number+1)+"p.jpg");
            }
    });
    
    

    document.getElementById('name_selected_title').style.display = 'none';
    document.getElementById('name_selected_desc').innerHTML = '<h6 style="margin-top:0;margin-bottom:0">' + names2[number] + '</h6>';
    document.getElementById('name_selected_type').innerHTML = document.getElementById('select_title_in_name').innerHTML + " " + document.getElementById('select_desc_in_name').innerHTML;

    document.getElementById('nonselected_name').setAttribute('class', 'hidden');
    document.getElementById('selected_name').setAttribute('class', 'select_nm');
    document.getElementById('selected_name').setAttribute('style', 'padding:0');
    document.getElementById('wrap_names' ).style.display = 'none';
    hide_greys_names();

    type_selected = true;
    visibleNames = false;
}


function generateNames(type, selected_type_title) {

    var type_1 = document.getElementsByName('type_1');
    var type_2 = document.getElementsByName('type_2');

    if (type == "Деталь") {
        var kind_of_name = document.getElementsByName('kind_of_name');
        var name = document.getElementsByName('name');
        var desc = document.getElementsByName('desc');
        var type_of_name = document.getElementsByName('type_of_name');

        for (var i = 0; i < type_2.length; i++) {
            type_2[i].style.display = 'none';
        }
        for (var i = 0; i < type_1.length; i++) {
            type_1[i].style.display = 'block';
        }

        var first_index_count = 30;//30
        var second_index_count = 26;
        var third_index_count = 5;
        var forth_index_count = 7;

        var name = document.getElementsByName('name');

        
        for (var i = 0; i <= first_index_count - 1; i++) {
            kind_of_name[i].innerText = 'Основы';
        }
        for (var i = first_index_count; i <= first_index_count + second_index_count - 1; i++) {
            kind_of_name[i].innerText = 'Накладки';   
        }

        for (var i = first_index_count + second_index_count; i <= third_index_count + first_index_count + second_index_count - 1; i++) {
            kind_of_name[i].innerText = 'Задние части';   
        }

        for (var i = third_index_count + first_index_count + second_index_count; i <= forth_index_count + third_index_count + first_index_count + second_index_count - 1; i++) {
            kind_of_name[i].innerText = 'Ножки';   
        }

        for (var i = 0; i < type_of_name.length; i++) {
            type_of_name[i].innerHTML = selected_type_title;
        }

        for (var i = 0; i < name.length; i++) {
            name[i].innerHTML = names[i];
            
            desc[i].style.display = 'none';
            desc[i].innerHTML = descs[i];
        }
    } else {
        var name = document.getElementsByName('name_2');
        var desc = document.getElementsByName('desc_2');
        var kind_of_name = document.getElementsByName('kind_of_name_2');
        var type_of_name = document.getElementsByName('type_of_name_2');


        var names2 = ['Фантом (задняя часть с малой поворотной ножкой)','Фантом основа с покрытием','Созвездие (основа + задняя часть с малой поворотной ножкой)','Круг малый  (основа + задняя часть с малой поворотной ножкой)','Щит под дерево с орнаментом (основа + ножка)','Круг под дерево с орнаментом (основа + ножка)','Квадрат под дерево с орнаментом (основа + ножка)','Щит под дерево с просветом  (основа + ножка)','Круг под дерево с просветом (основа + ножка)', 'Квадрат под дерево с просветом (основа + ножка)', '8 граней с орнаментом (основа + ножка)', '8 граней с желобом (основа + ножка)', '8 граней под гравировку (основа + ножка)', 'Щит европа стандартный (основа + ножка)','Щит европа с орнаментом (основа + ножка)','Пупырки (основа + ножка)', 'Прямоугольник косичка (основа + ножка)', 'Круг косичка (основа + ножка)', 'Спаси и сохрани с орнаментом (основа + ножка)','Спаси и сохрани под гравировку (основа + ножка)','Спаси и сохрани с надписью (основа + ножка)', 'Премиум квадратный (основа + ножка)','Накладка под премиум квадратный (отполированная)','Премиум круглый (основа + ножка)','Накладка под премиум круглый (отполированная)','Винтажный куб (основа + ножка)','Омниа круг (основа + ножка)','Омниа квадрат (основа + ножка)','Прямоугольник готика под бриллиант (основа + ножка)'];

        
        //29
        for (var i = 0; i < type_1.length; i++) {
            type_1[i].style.display = 'none';
        }
        for (var i = 0; i < type_2.length; i++) {
            type_2[i].style.display = 'block';
        }
        
        for (var i = 0; i <= 3; i++) {
            kind_of_name[i].style.display = 'none';
        }
        
        
        for (var i = 0; i < name.length; i++) {
            name[i].innerHTML = names2[i];
            desc[i].style.display = 'none';
            desc[i].innerHTML = descs[i];
        }
        
        for (var i = 0; i < type_of_name.length; i++) {
            type_of_name[i].innerHTML = selected_type_title;
        }

    }
}

$('#form').submit(function(ev) {
    if (isFormFilled)
        document.getElementById('future').setAttribute('disabled', 'disabled');
});

function checkTo(id1, id2) {

    if(document.getElementById("selectTo").value == "") { 
        document.getElementById("selectFrom").value = "";
        $("#selectFrom option").css("display","block");
        $("#selectTo option").css("display","block");
        $('#selectFrom').removeAttr('onfocus');
        
        $("#selectOperation option").css("display","block");
        document.getElementById('selectOperation').style.color = "#3d3d3d";
        
        document.getElementById('selectFrom').style.color = "";
    }
    else if(document.getElementById("selectTo").value == "Склад") {
        $("#selectFrom option").css("display","block");
        $("#selectFrom option[value='Склад']").css("display","none");

        document.getElementById("selectFrom").value = "";
        
        document.getElementById("selectOperation").value = "Приход";
        // document.getElementById("selectOperation").setAttribute('disabled', 'disabled');
        $("#selectOperation option").css("display","none");
        document.getElementById('selectOperation').style.color = "#CCCCCC";

        document.getElementById('selectFrom').style.color = "";
    } else {

        document.getElementById("selectFrom").value = "Склад";
        // document.getElementById("selectFrom").setAttribute('disabled', 'disabled');
        $("#selectFrom option").css("display","none");

        document.getElementById('selectFrom').style.color = "#CCCCCC";
        $("#selectFrom option[value='Склад']").css("display","none");

        $("#selectFrom option[value='Склад']").css("display","block");
        
        document.getElementById("selectOperation").value = "Расход";
        // document.getElementById("selectOperation").setAttribute('disabled', 'disabled');
        $("#selectOperation option").css("display","none");
        $("#selectOperation option[value='Расход']").css("display","block");
        document.getElementById('selectOperation').style.color = "#CCCCCC";
        
    }

    compareStrings("selectFrom","selectTo");

}

function checkFrom(id1, id2){
    compareStrings("selectFrom","selectTo");

    if((document.getElementById(id1).value=='Склад' && document.getElementById(id2).value=='Приход') || (document.getElementById(id1).value=='Поставщик')){
        document.getElementById("dpol").style.display="none";
        hide_greys_types();
        hide_greys_names();
        greys_types[0].style.display = 'block';
    }else{
        document.getElementById("dpol").style.display="block";
        show_greys_types();
    }

    if(document.getElementById("selectFrom").value == "" && document.getElementById('type_title_send').value == "") { 
    
        
        $("#selectOperation option").css("display","block");
        document.getElementById('selectOperation').style.color = "#3d3d3d";
        
        
        $("#selectStatus").removeAttr("disabled");
        document.getElementById('selectStatus').style.color = "#3d3d3d";
        document.getElementById('selectStatus_send').value=document.getElementById('selectStatus').value;
        
        
        document.getElementById("selectTo").value = "";
        // $('#selectTo').removeAttr('disabled');
        $("#selectTo option").css("display","block");
        $("#selectFrom option").css("display","block");
        document.getElementById('selectTo').style.color = "";
        
        testStatus = false;
    } else if(document.getElementById("selectFrom").value == "Поставщик") {

        
        document.getElementById("selectOperation").value = "Приход";
        $("#selectOperation option").css("display","block");
        document.getElementById('selectOperation').style.color = "#CCCCCC";
        
        $("#selectStatus").removeAttr("disabled");
        document.getElementById('selectStatus').style.color = "#3d3d3d";
        document.getElementById('selectStatus_send').value=document.getElementById('selectStatus').value;
        
        
        $("#selectTo option[value='Склад']").css("display","block");
        document.getElementById("selectOperation").value = "Приход";
        // document.getElementById("selectOperation").setAttribute('disabled', 'disabled');
        $("#selectOperation option").css("display","none");
        document.getElementById('selectOperation').style.color = "#CCCCCC";

        document.getElementById("selectTo").value = "";
        // $('#selectTo').removeAttr('disabled');
        $("#selectTo option").css("display","block");

        document.getElementById('selectTo').style.color = "";

        document.getElementById("selectTo").value = "Склад";
        // document.getElementById("selectTo").setAttribute('disabled', 'disabled');
        $("#selectTo option").css("display","none");
        $("#selectTo option[value='Склад']").css("display","block");
        
        
        document.getElementById('selectTo').style.color = "#CCCCCC";

        testStatus = true;
    } else if(document.getElementById("selectFrom").value == "Склад") {
        
        
        document.getElementById('selectStatus').style.color = "#CCCCCC";
        $("#selectStatus").prop('disabled', 'disabled');
        document.getElementById('selectStatus_send').value='null';
        
        testStatus = false;
        
        document.getElementById("selectOperation").value = "Расход";
        // document.getElementById("selectOperation").setAttribute('disabled', 'disabled');
        $("#selectOperation option").css("display","none");
        $("#selectOperation option[value='Расход']").css("display","block");
        document.getElementById('selectOperation').style.color = "#CCCCCC";

        document.getElementById("selectTo").value = "";
        // $('#selectTo').removeAttr('disabled');
        $("#selectTo option").css("display","block");
        $("#selectTo option[value='Склад']").css("display","none");
        document.getElementById('selectTo').style.color = "";

    } else if (document.getElementById('type_title_send').value == "Металл" || document.getElementById('type_title_send').value == "Лигатура") {
        document.getElementById('selectStatus').style.color = "#CCCCCC";
        $("#selectStatus").prop('disabled', 'disabled');
        document.getElementById('selectStatus_send').value='null';
    } else if (document.getElementById("selectFrom").value != ""){  
        console.log()
        $("#selectStatus").removeAttr("disabled");
        document.getElementById('selectStatus').style.color = "#3d3d3d";
        document.getElementById('selectStatus_send').value=document.getElementById('selectStatus').value;
        
        document.getElementById("selectTo").value = "Склад";
        // document.getElementById("selectTo").setAttribute('disabled', 'disabled');
        $("#selectTo option").css("display","none");
        document.getElementById('selectTo').style.color = "#CCCCCC";

        $("#selectTo option[value='Склад']").css("display","block");
        // $('#selectOperation').removeAttr('disabled');
        if (document.getElementById("selectTo").value != "Склад") {
            $("#selectOperation option").css("display","block");
            document.getElementById('selectOperation').style.color = "";
        }
        document.getElementById("selectOperation").value = "Приход";
        $("#selectOperation option").css("display","block");
        document.getElementById('selectOperation').style.color = "#CCCCCC";
        //testStatus = true;
    }

}

</script>