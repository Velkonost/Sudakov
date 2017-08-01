<head>
    <meta charset="utf-8">
</head>
<?php

// use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Things;
use yii\helpers\Url;
use yii\helpers;
use yii\web\helpers\CHtml;
/* @var $this yii\web\View */

$this->title = 'Metals';
$user = Yii::$app->user->identity;


?>
<?php

if ($user->hasRole(['admin'])) { 
    Yii::$app->response->redirect(Url::to(['storagee/add']));
} else if(!$user->hasRole(['admin', 'superadmin'])) { 
    Yii::$app->response->redirect(Url::to(['site/index']));
}
?>


<button class = 'btn_submit' onclick = "return location.href = 'view'" style = "text-decoration: none;"><span style="text-align:center;">Показать товары</span></button>
<button class = 'btn_submit'  onclick = "return location.href = 'add'" style = "text-decoration: none; display:inline-block; margin-bottom: 20px"><span style="text-align:center;">Добавить товары</span></button>



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
        margin-left: 40%;
        margin-top: 45px;
        font-family: inherit;
        font-size: 18px;
        background-color: #FCDA33;
        width: 300px;
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