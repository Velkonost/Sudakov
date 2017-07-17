<?php

namespace app\controllers;

use app\components\StatisticsHelper;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\Job;
use app\models\Lead;
use app\models\Money;


class SiteController extends Controller
{

    private $startPeriod = 0;

    private $finishPeriod = 0;


    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'diagram','get-stat-info','statistics'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['login', 'logout', 'no-access', 'test'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                ],
                'denyCallback' => function() {
                    if (Yii::$app->user->isGuest) {
                        return $this->redirect('/site/login');
                    }
                }
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

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

    public function actionNoAccess()
    {
        return $this->render('no_access', []);
    }

    public function actionIndex()
    {
        $fact = $data = StatisticsHelper::getStatictics();
        $paramNames = StatisticsHelper::parametersNames();
        $this->layout = 'empty';
        $user = Yii::$app->user->identity;
        $period = empty($_SESSION['period']) ? 'month' : $_SESSION['period'];
        $calendar = (count(explode('-', $period)) > 1) ? true : false;

        $result = [];
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->hasRole('superadmin')) {
            $categories = [
                'metriks' => ['label' => 'Основные метрики'],
                'trade' => ['label' => 'Продажи'],
                'money' => ['label' => 'Деньги'],
                'production' => ['label' => 'Производство'],
                'load-department' => ['label' => 'Загруженность отделов'],
                'cities' => ['label' => 'Города'],
            ];
            foreach ($categories as $category => $categoryName) {
                foreach ($data as $name => $item) {
                    foreach ($item['rows'] as $key => $value) {
                        if ($category == $name) {
                            $result[$category]['rows'][$key]['name'] = $paramNames[$category][$key];
                            $result[$category]['rows'][$key]['for30days'] = $value;
                            $result[$category]['rows'][$key]['for_day'] = intval($value / 30);
                            $result[$category]['rows'][$key]['fact'] = [
                                'value' => $fact[$category]['rows'][$key],
                                'change' => '+0',
                                'status' => 'gray'
                            ];
                            $result[$category]['rows'][$key]['ratio'] = 0;
                            $result[$category]['rows'][$key]['plan'] = 0;
                        }
                    }
                }
                $result[$category]['label'] = $categoryName['label'];
            }
        }

        return $this->render('index', [
            'user' => $user,
            'period' => $period,
            'statisticsData' => $result,
            'calendar' => $calendar
        ]);
    }


    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionDiagram()
    {
        //var_dump($type);
        $groupBy = Yii::$app->request->get('group_by');
        $checkedParams = Yii::$app->request->get('type');
        $resultData = $seriesColor = $count = $labels =  [];

        $highlightColors = StatisticsHelper::highlightColors();
        $paramNames = StatisticsHelper::parametersNames();
        if ($period = Yii::$app->request->get('period')) {
            list($fromDate, $toDate) = StatisticsHelper::getPeriod($period);
            $this->startPeriod = $fromDate;
            $this->finishPeriod = $toDate;
            if (count($checkedParams) > 0) {
                foreach ($checkedParams as $param) {
                    $data = StatisticsHelper::getGraphDataByParam($param['name'], $fromDate, $toDate);
                    $seriesColor[] = $highlightColors[$param['name']];
                    $chunk = explode('_', $param['name']);
                    $labels[] = $paramNames[ $chunk[0] ][ $chunk[1] ];
                    $resultData[] = $data;
                }
            }
            //Data to right block table
            $_SESSION['period'] = $period;

            switch ($groupBy) {
                case '3days': $periodInterval = 3; break;
                case 'week': $periodInterval = 7; break;
                case 'month': $periodInterval = 30; break;
                case 'year': $periodInterval = 365; break;
                default: $periodInterval = 1;
            }

            $resultData = StatisticsHelper::fillEmptyDates($resultData, $fromDate, $toDate, $periodInterval);

            if (Yii::$app->request->isAjax) {
                return json_encode([
                    'code' => 0,
                    'is_same_day' => StatisticsHelper::isSameDay($fromDate, $toDate),
                    'result' => $resultData,
                    'start' => date('m-d-Y H:i:s', $fromDate),
                    'finish' => date('m-d-Y H:i:s', strtotime('+1 hour', $toDate)),
                    'colors' => $seriesColor,
                    'labels' => $labels,
                ]);
            } else {
                return json_encode($resultData);
            }
        } else {
            return json_encode(['code' => 1]);
        }
    }

    public function actionGetStatInfo()
    {

        list($startDate, $finishDate) =  StatisticsHelper::getPeriod(Yii::$app->request->get('period'));

        list($iLastStartDate, $iLastFinishDate) =  StatisticsHelper::getPeriod(Yii::$app->request->get('period'), (time() - $startDate));
        $plan = [];
        $data = StatisticsHelper::getStatictics($startDate, $finishDate);
        $aLastData = StatisticsHelper::getStatictics($iLastStartDate, $iLastFinishDate);
        $result = [];
        $aChangeResult=[];
        $aLastResult=[];

        // todo move to other method
        // Для городов плановое
        foreach (StatisticsHelper::cities() as $key => $city) {
            $count1 = Yii::$app->getDb()
                ->createCommand("SELECT COUNT(`lead_id`) AS `cnt`"
                    . " FROM `lead` WHERE (`created_at` >= {$startDate} AND `created_at` <= {$finishDate}) AND `city` LIKE :city")
                ->bindParam(':city', $city)->queryOne()['cnt'];
            $count2 = Yii::$app->getDb()
                ->createCommand("SELECT COUNT(`lead_id`) AS `cnt`"
                    . " FROM `lead` WHERE (`created_at` >= {$iLastStartDate} AND `created_at` <= {$iLastFinishDate}) AND `city` LIKE :city")
                ->bindParam(':city', $city)->queryOne()['cnt'];
            $count2 = ($count1 - $count2);
            $plan[$key] = [
                'value' => $count1,
                'change' => $count2 > 0 ? '+' . $count2 : $count2
            ];
            $cityIndex = explode("_",$key);
            $leads = $data[$cityIndex[0]]['rows'][$cityIndex[1]];
            if($count1) {
                $ratio[$key] = intval($leads * 100/ $count1) ;
            }else{
                $ratio[$key] =  0;
            }
        }
        $period_average = array(
            'week' => '52',
            '3month' => '4',
            'month' => '12',
            'year' => '1'
        );
        if(isset($period_average[Yii::$app->request->get('period')])){

            //выбираем за год для подсчета среднего
            list($startDate, $finishDate) =  StatisticsHelper::getPeriod('year');
            $data_average = StatisticsHelper::getStatictics($startDate, $finishDate);
            foreach($data_average as $category => $rows){
                foreach ($rows['rows'] as $name =>$row){
                    $result_average[$category."_".$name] = round($row/$period_average[Yii::$app->request->get('period')]);

                }
            }
        }elseif(isset(explode('-', Yii::$app->request->get('period'))[1]) ){
            //выбираем за год для подсчета среднего
            list($startDateinterval, $finishDateinterval) =  StatisticsHelper::getPeriod(Yii::$app->request->get('period'));
            list($startDate, $finishDate) =  StatisticsHelper::getPeriod('year');
            $interval = round(($finishDateinterval-$startDateinterval)/(60*60*24));
            //var_dump($interval); exit;
            $data_average = StatisticsHelper::getStatictics($startDate, $finishDate);
            foreach($data_average as $category => $rows){
                foreach ($rows['rows'] as $name =>$row){
                    $result_average[$category."_".$name] = round($row/$interval);

                }
            }
        }else{
            //выбираем за год для подсчета среднего
            list($startDate, $finishDate) =  StatisticsHelper::getPeriod('month');
            $data_average = StatisticsHelper::getStatictics($startDate, $finishDate);
            foreach($data_average as $category => $rows){
                foreach ($rows['rows'] as $name =>$row){
                    $result_average[$category."_".$name] = round($row/30);

                }
            }
        }


        foreach($data as $category => $rows){
            foreach ($rows['rows'] as $name =>$row){
                $result[$category."_".$name] = $row;
                // $aLastResult[$category."_".$name] = 0;
            }
        }
        foreach($aLastData as $category => $rows){
            foreach ($rows['rows'] as $name =>$row){
                $aLastResult[$category."_".$name] = $row;
            }
        }
        foreach($result as $key => $element){
            $aChangeResult[$key] = $element - $result_average[$key];
        }
        $resPeriod = StatisticsHelper::getPeriod(Yii::$app->request->get('period'));
        if($resPeriod[0] == 0 && $resPeriod[1] == 0){
            return json_encode(['code'=>2]);
        }
        if(sizeof($result)==0){
            return json_encode(['code'=>1]);
        }else{
            return json_encode([
                'code'=>0,
                'result'=>$result,
                'result_average'=>$result_average,
                'period'=>$resPeriod,
                'changes'=>$aChangeResult,
                'cities_plan'=>$plan,
                'ratio' => $ratio
            ]);
        }

    }

    // TODO вообще не понятно что тут происходит!
    // TODO перенести в StatisticsHelper !
    // TODO удалить неисп аргументы
    function renderDiagram($data, $period, $isMoney=false, $oneArray=true){
        $i = 0; // Только для теста
        $res = $result = [];
        if ($oneArray) { // Иногда надо сумму первой и второй оплаты прогонять
            $tData = [$data];
        } else {
            $tData = $data;

        }
        foreach($tData as $datum) {
            if (!$isMoney) {
                foreach ($datum as $item) {
                    if (isset($result[$item['period']])) {
                        $result[$item['period']]++;
                    } else {
                        $result[$item['period']] = 1;
                    }
                }
            } else {
                foreach ($datum as $item) {
                    $char = (substr($item['amount'], -1, 1) == '%') ? '%' : '';
                    $item['amount'] = str_replace('%', '', $item['amount']);
                    $result[$item['period']] = str_replace('%', '', $result[$item['period']]);
                    if (isset($result[$item['period']])) {
                        $result[$item['period']] += $item['amount'];
                    } else {
                        $result[$item['period']] = $item['amount'];
                    }
                    $result[$item['period']] .= $char;
                }
            }
        }
        foreach ($result as $date => $point) {
            $res[] = [$date, $point, $point];
            $i += str_replace('%', '', $point);
        }
        // TODO это условие для одной точки?
        if (count($res) == 1) {
            $res[1] = $res[0];
            $res[0] = [$res[1][0],0,0];
        }

        return [$res, $i];
    }




}
