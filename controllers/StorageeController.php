<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

use app\models\MyForm;
use app\models\Comments;

use yii\helpers\Html;
use yii\web\UploadedFile;
use yii\data\Pagination;

use app\models\StorageFormAdd;
use app\models\MetalsTest;



class StorageeController extends Controller
{

    private $isAddFormSubmitted = false;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }


    public function actionReport() {
        $all = MetalsTest::find()->all();
        $from = [];
        $to = [];
        $operation = [];
        $type = [];
        $name = [];
        $name_desc = [];
        $parent = [];
        $massa = [];

        foreach($all as $key){
            array_push($from, $key->from);
            array_push($to, $key->to);
            array_push($operation, $key->operation);
            array_push($type, $key->type_title . ' ' . $key->type_desc);
            array_push($name, $key->name_title . ' ' . $key->name_desc);
            array_push($name_desc, $key->name_desc);
            array_push($massa, $key->massa);
        }

        return $this->render('report',
            [
                'to' => $to,
                'from' => $from,
                'operation' => $operation,
                'type' => $type,
                'name' => $name_desc,
                'name_desc' => $name_desc,
                'massa' => $massa
            ]);
    }


    public function actionIndex() {
        return $this->render('index');
    }

    public function actionView() {
        $all = MetalsTest::find()->all();
        
        return $this->render('view',
            ['all'=>$all]);

    }

    public function actionAdd()
    {

        $form = new StorageFormAdd();
        $text = "";
        if (($form->load(Yii::$app->request->post())) && ($form->validate())){

            $post = new MetalsTest;
            $post->type_title = Html::encode($form->type_title_send);
            $post->type_desc = Html::encode($form->type_desc_send);
            $post->img_type = Html::encode($form->type_img_name);
            $post->img_name = Html::encode($form->name_img_name);
            $post->massa = Html::encode($form->massa);
            $post->value = Html::encode($form->value);
            $post->status = Html::encode($form->status);
            $post->from = Html::encode($form->from);
            $post->to = Html::encode($form->to);
            $post->operation = Html::encode($form->operation);
            $post->name_title = Html::encode($form->name_title_send);
            $post->name_desc = Html::encode($form->name_desc_send);
            $post->name_type = Html::encode($form->name_type_send);
            $post->date = Html::encode($form->date_send);
            $post->time = Html::encode($form->time_send);
            
            $post->save();
           
            $this->redirect("add?r=true");
            
            $form->massa = "";
            $form->value = "";
            $form->status = "Статус";
            $form->operation = "Операция";
            $form->to = "Кому";
            $form->from = "От кого";

        }
        
        $items = [
            '' => 'Операция',
            'Расход' => 'Расход',
            'Приход' => 'Приход',
        ];
        $items2 = [
            '' => 'От кого',
            'Склад' => 'Склад',
            'Петр' => 'Петр',
            'Галина' => 'Галина',
            'Жоомарт' => 'Жоомарт',
            'Поставщик' => 'Поставщик',
            'Остаток с прошлого месяца' => 'Остаток с прошлого месяца',
        ];
        $items3 = [
            '' => 'Кому',
            'Склад' => 'Склад',
            'Петр' => 'Петр',
            'Галина' => 'Галина',
            'Жоомарт' => 'Жоомарт',
        ];
        $items4 = [
            '' => 'Статус',
            'Годное' => 'Годное',
            'Брак' => 'Брак',
        ];
    

        return $this->render('add',
            [ 'textSave' => $text, 'form' => $form, 'operations'=>$items, 'froms'=>$items2, 'tos'=>$items3, 'statuses'=>$items4]);
    }
}