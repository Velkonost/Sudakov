<?php

namespace app\controllers;

use app\models\AssigmentLeads;
use app\models\Option;
use app\models\QueueLeads;
use app\models\Lead;
use app\models\Amo;
use Yii;
use yii\web\Controller;
use yii\helpers\Json;
use app\models\ManagerOption;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class ItController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'update-managers', 'manager-options-save', 'test'],
                        'allow' => true,
                        'roles' => ['superadmin'],
                    ],
                ],
                'denyCallback' => function() {
                    if (Yii::$app->user->isGuest) {
                        return $this->redirect('/site/login');
                    }
                    return $this->redirect('/site/no-access');
                }
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        return $this->render('index', [
            'managers' => ManagerOption::find()->all(),
            'method' => Option::getOption('typeOfAssignmentLeads'),
            'user' => Yii::$app->user->identity
        ]);
    }


    /**
     * Обновление менеджеров из амо
     */
    public function actionUpdateManagers()
    {
        $amo = new Amo(\Yii::$app->params);
        $queue = new ManagerOption();
        // Обновить менеджеров
        $managers = $amo->reloadManagersList();
        if (!empty($managers)) {
            $queue->changeUsersName($managers);
        }
        header('Location: ' . Url::to('/it/index'));
        exit;
    }


    /**
     * Сохранение параметров менеджеров
     */
    public function actionManagerOptionsSave()
    {
        $queue = new ManagerOption();
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            if (!isset($data['type'])) {
                $queue->changeValues($data);
                echo Json::encode([
                    'status' => 200,
                    'id' => $data['manager_id'],
                    'field' => $data['field']
                ]);
            } else {
                Option::setOption('typeOfAssignmentLeads', $data['value']);
                echo Json::encode([
                    'status' => 200,
                    'type' => $data['value']
                ]);
            }
            exit;
        }
        exit('Доступ запрещён');
    }


    // testing methods

    /**
     * Эмуляция хука - точка входа в тестирование, так как заполняет лидами таблица входящих сделок
     */
    public function actionTest()
    {
        $domain = 'sudakov.dev';//'sscrm.dev';
        // Выбираем из реально существующих случайную
        $size = count(Lead::findAll([]));
        $randLead = Lead::find()->orderBy(['lead_id'=> SORT_DESC])->offset(intval(rand(0, $size-1)))->one();
        $randLead = rand(1, 2000); //Временно пока нетоступа к амо
        $array = [
            'leads' =>
                [
                    'add' =>
                        [
                            0 => [
                                'id' => $randLead, //rand(1, 2000),
                                'name' => 'тираж.14 пар, 8 гр, бронза+родий,камень чароит/обсидиан (монограммы в ленте)',
                                'status_id' => '7633870',
                                'price' => '',
                                'responsible_user_id' => '',
                                'last_modified' => '1481203113',
                                'modified_user_id' => '220428',
                                'created_user_id' => '220428',
                                'date_create' => '1481203113',
                                'pipeline_id' => '22014',
                                'account_id' => '7633866',
                                'custom_fields' =>
                                    [
                                        0 =>
                                            [
                                                'id' => '1287406',
                                                'name' => 'Оплачено Курьеру',
                                                'values' =>
                                                    [
                                                        0 => ['value' => '0']
                                                    ]
                                            ],
                                        1 =>
                                            [
                                                'id' => '1286186',
                                                'name' => 'roistat',
                                                'values' =>
                                                    [
                                                        0 =>
                                                            [
                                                                'value' => 'Директ ручной',
                                                            ]
                                                    ]
                                            ]
                                    ]
                            ]
                        ]
                ],
            'account' =>
                [
                    'subdomain' => 'jbyss',
                ]
        ];
        //var_dump(serialize(  $array ));
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $domain.'/amo/web-hook');
        //curl_setopt($s,CURLOPT_HTTPHEADER,array('Expect:'));
        curl_setopt($curl, CURLOPT_TIMEOUT, 600);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($array));

        $res = curl_exec($curl);
        curl_close($curl);

        var_dump($res);


    }


    function curlTest($url, $params)
    {
        $curl = curl_init();

        //curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_URL, $url . '?' . http_build_query($params));
        //curl_setopt($s,CURLOPT_HTTPHEADER,array('Expect:'));
        curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        //curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        //curl_setopt( $curl, CURLOPT_POST, true );
        //curl_setopt( $curl, CURLOPT_POSTFIELDS, http_build_query( $params ));

        $res = curl_exec($curl);
        curl_close($curl);
        return $res;
    }


    function actionWidgetTest()
    {
        $array = [
            'manager_id' => \Yii::$app->request->get('manager_id'),
            'lead_id' => \Yii::$app->request->get('lead_id'),
            'status' => \Yii::$app->request->get('status'),
        ];

        // echo $array['mid'],'<br/>';
        //var_dump($this->curlTest('sscrm.dev/amo/allocation-request', $array));
        var_dump($this->curlTest('sscrm.dev/amo/set-allocation', $array));
    }
}
