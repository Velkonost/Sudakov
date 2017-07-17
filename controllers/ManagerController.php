<?php

namespace app\controllers;

use Yii;
use app\models\Manager;
use app\models\ManagerSearch;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\StatisticsHelper;

/**
 * ManagerController implements the CRUD actions for Manager model.
 */
class ManagerController extends Controller
{

    private $startPeriod = 0;

    private $finishPeriod = 0;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'diagram','get-stat-info','statistics','create','view','update'],
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
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Manager models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new ManagerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $fact = $data = StatisticsHelper::getStatictics();
        $this->layout = 'empty';
        $user = Yii::$app->user->identity;
        $period = empty($_SESSION['period']) ? 'month' : $_SESSION['period'];
        $calendar = (count(explode('-', $period)) > 1) ? true : false;

        $result = [];
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->hasRole('superadmin')) {
            $manager = Manager::find()
                ->asArray()
                ->all();
            foreach ($manager as $value){
                $categories[$value['responsible_user_id']]= array('label' => $value['name']);
                $paramNames[$value['responsible_user_id']]= array(
                    'summarymanager' => 'Выручка общая',
                    'firstpaymentmanager' => '1я оплата',
                    'secondpaymentmanager' => '2я оплата',
                    'potencialsummarymanager' => 'Потенциальная выручка',
                    'leadmanager' => 'Лиды',
                    'CVmanager' => 'Конверсия',
                    'trademanager' => 'Продажи',
                );
            }
            /* $categories = [
                 'metriks' => ['label' => 'Основные метрики'],
                 'trade' => ['label' => 'Продажи'],
                 'money' => ['label' => 'Деньги'],
                 'production' => ['label' => 'Производство'],
                 'load-department' => ['label' => 'Загруженность отделов'],
                 'cities' => ['label' => 'Города'],
             ]; */
            // var_dump($data); exit;
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
                            if ($category == 'money' && $key == 'summary') {
                                $result[$category]['rows'][$key]['first_payments'] = $data['summary']['rows']['first_payment'];
                                $result[$category]['rows'][$key]['second_payments'] = $data['summary']['rows']['second_payment'];
                            }
                        }
                    }
                }
                $result[$category]['label'] = $categoryName['label'];
            }
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'user' => $user,
            'period' => $period,
            'statisticsData' => $result,
            'calendar' => $calendar
        ]);
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

            list($startDate, $finishDate) =  StatisticsHelper::getPeriod(Yii::$app->request->get('period'));
            $interval = round(($finishDate-$startDate)/(60*60*24));
            // var_dump(($finishDate-$startDate)/(60*60*24)); exit;
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

            ]);
        }

    }

    public function actionDiagram()
    {
        //var_dump($type);
        $groupBy = Yii::$app->request->get('group_by');
        $checkedParams = Yii::$app->request->get('type');
        $resultData = $seriesColor = $count = $labels =  [];

        $highlightColors = StatisticsHelper::highlightColorsManager();
        $manager = Manager::find()
            ->asArray()
            ->all();
        foreach ($manager as $value){
            $paramNames[$value['responsible_user_id']]= array(
                'summarymanager' => 'Выручка общая',
                'firstpaymentmanager' => '1я оплата',
                'secondpaymentmanager' => '2я оплата',
                'potencialsummarymanager' => 'Потенциальная выручка',
                'leadmanager' => 'Лиды',
                'CVmanager' => 'Конверсия',
                'trademanager' => 'Продажи',
            );
        }

        if ($period = Yii::$app->request->get('period')) {
            list($fromDate, $toDate) = StatisticsHelper::getPeriod($period);
            $this->startPeriod = $fromDate;
            $this->finishPeriod = $toDate;
            if (count($checkedParams) > 0) {
                foreach ($checkedParams as $param) {
                    $chunk = explode('_', $param['name']);
                    $data = StatisticsHelper::getGraphDataByParamManager($param['name'], $fromDate, $toDate);
                    $seriesColor[] = $highlightColors[$param['name']];
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

    /**
     * Displays a single Manager model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Manager model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Manager();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Manager model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Manager model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Manager model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Manager the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Manager::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
