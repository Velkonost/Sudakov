<?php

namespace app\controllers;

use app\models\MoneySearch;
use app\models\MamanegSearch;
use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use app\models\Money;
use app\models\Amo;
use app\models\Lead;
use yii\filters\VerbFilter;
use app\components\StatisticsHelper;

class MoneyController extends Controller {

    private $startPeriod = 0;
    private $finishPeriod = 0;
    public $layout = 'money';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['superadmin', 'manager-payment', 'buh'],
                    ],
                    [
                        'actions' => ['waybill'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['superadmin', 'buh'],
                    ],
                    [
                        'actions' => ['all-periods-update','update-all', 'download'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function() {
                    if (Yii::$app->user->isGuest) {
                        return $this->redirect('/site/login');
                    }
                    // error page
                    return $this->redirect('/site/no-access');
                }
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        $searchModel = new MoneySearch();
        $models = $searchModel->search(Yii::$app->request->queryParams);
        $labels = ['', 'Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль',
            'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];
        $currentDate = strtotime('01.08.2016');
        $months = [];

        $managername = Yii::$app->getDb()
            ->createCommand("SELECT responsible_user_id, name"
                . " FROM `manager`")
            ->queryAll();
        $manager = [];
        foreach($managername as $value){
            $manager[$value['responsible_user_id']] = $value['name'];
        }

        while ($currentDate < strtotime('now')) {
            $months[date('m-Y', $currentDate)] = $labels[ intval(date('m', $currentDate)) ] . ' ' . date('Y', $currentDate);
            $currentDate = strtotime("+1 month", $currentDate);
        }
        if(!$date = Yii::$app->request->get('date_period')){
            $date = date("m-Y", strtotime('now'));
        }
        return $this->render('index', [
            'filter' => [
                'months' => $months,
            ],
            'user' => $user,
            'models' => $models,
            'manager' => $manager,
            'date_period' => $date
        ]);
    }

    public function actionStatistics()
    {
        $user = Yii::$app->user->identity;
        $searchModel = new MoneySearch();
        $fact = $data = StatisticsHelper::getStatisticsMoney();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $period = empty($_SESSION['period']) ? 'month' : $_SESSION['period'];
        $calendar = (count(explode('-', $period)) > 1) ? true : false;

        $result = [];
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->hasRole('superadmin')) {
            $categories['collection']= array('label' => 'Коллекции');
            $paramNames['collection'] = array();
            $collection = Yii::$app->getDb()
                ->createCommand("SELECT label "
                    . " FROM `collections` WHERE `color` IS NOT NULL")->queryAll();

            foreach ($collection as $value){
                $paramNames['collection'][$value['label']] = $value['label'];
            }
            // var_dump($paramNames); exit;
            foreach ($data as $name => $item) {


                $result['collection']['rows'][$name]['name'] = $paramNames['collection'][$name];
                $result['collection']['rows'][$name]['for30days'] = $item['rows']['count'];
                $result['collection']['rows'][$name]['for_day'] = intval($item['rows']['count'] / 30);
                $result['collection']['rows'][$name]['fact'] = [
                    'value' => $fact[$name]['rows']['count'],
                    'change' => '+0',
                    'status' => 'gray'
                ];
                $result['collection']['rows'][$name]['ratio'] = 0;
                $result['collection']['rows'][$name]['plan'] = $fact[$name]['rows']['summ'];


            }
            $result['collection']['label'] = 'Коллекции';

        }

        return $this->render('statistics', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'user' => $user,
            'period' => $period,
            'statisticsData' => $result,
            'calendar' => $calendar
        ]);
    }

    public function actionDiagram()
    {
        $groupBy = Yii::$app->request->get('group_by');
        $checkedParams = Yii::$app->request->get('type');
        $resultData = $seriesColor = $count = $labels =  [];
        

        $paramNames['collection'] = array();
        $collection = Yii::$app->getDb()
            ->createCommand("SELECT label,color "
                . " FROM `collections` WHERE `color` IS NOT NULL")->queryAll();

        foreach ($collection as $value){
            $paramNames['collection'][$value['label']] = $value['label'];
            $highlightColors[$value['label']] = $value['color'];
        }

        if ($period = Yii::$app->request->get('period')) {
            list($fromDate, $toDate) = StatisticsHelper::getPeriod($period);
            $this->startPeriod = $fromDate;
            $this->finishPeriod = $toDate;
            if (count($checkedParams) > 0) {
                foreach ($checkedParams as $param) {
                    $chunk = explode('_', $param['name']);
                    $data = StatisticsHelper::getGraphDataByParamMoney($param['name'], $fromDate, $toDate);
                    $seriesColor[] = $highlightColors[$chunk[1]];
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

            $resultData = StatisticsHelper::fillEmptyDatesMoney($resultData, $fromDate, $toDate, $periodInterval);

            if (Yii::$app->request->isAjax) {
                return json_encode([
                    'code' => 0,
                    'is_same_day' => StatisticsHelper::isSameDay($fromDate, $toDate),
                    'result' => $resultData,
                    'start' => date('m-d-Y H:i:s', $fromDate),
                    'finish' => date('m-d-Y H:i:s', strtotime('+10 hour', $toDate)),
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
        $data = StatisticsHelper::getStatisticsMoney($startDate, $finishDate);
        $aLastData = StatisticsHelper::getStatisticsMoney($iLastStartDate, $iLastFinishDate);
        $result = [];
        $aChangeResult=[];
        $aLastResult=[];
        $aLastResultz= $data;
        $aChartResult=[];
        $isSameDay = StatisticsHelper::isSameDay($startDate, $finishDate);

        if (!$isSameDay) {
            $tooltiptime = date('d.m.Y', $startDate).' - '.date('d.m.Y', $finishDate);
        }else{
            $tooltiptime = date('d.m.Y', $startDate);
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
            $data_average = StatisticsHelper::getStatisticsMoney($startDate, $finishDate);
            foreach($data_average as $category => $rows){
                foreach ($rows['rows'] as $name =>$row){
                    if($name == 'count')
                        $result_average[$category."_".$name] = round($row/$period_average[Yii::$app->request->get('period')]);

                }
            }
        }elseif(isset(explode('-', Yii::$app->request->get('period'))[1]) ){
            //выбираем за год для подсчета среднего

            list($startDate, $finishDate) =  StatisticsHelper::getPeriod(Yii::$app->request->get('period'));
            $interval = round(($finishDate-$startDate)/(60*60*24));
            // var_dump(($finishDate-$startDate)/(60*60*24)); exit;
            $data_average = StatisticsHelper::getStatisticsMoney($startDate, $finishDate);
            foreach($data_average as $category => $rows){
                foreach ($rows['rows'] as $name =>$row){
                    if($name == 'count')
                        $result_average[$category."_".$name] = round($row/$interval);

                }
            }
        }else{
            list($startDate, $finishDate) =  StatisticsHelper::getPeriod('month');
            $data_average = StatisticsHelper::getStatisticsMoney($startDate, $finishDate);
            foreach($data_average as $category => $rows){
                foreach ($rows['rows'] as $name =>$row){
                    if($name == 'count')
                        $result_average[$category."_".$name] = round($row/30);

                }

            }
        }

        $i=0;
        $summprotege = 0;
        $countprotege = 0;
        foreach($data as $category => $rows){

            foreach ($rows['rows'] as $name =>$row){
                $i++;
                $result[$i."_".$name] = $row;
                $aLastResultz[$category."_".$name] = $row;
                if($name == 'summ') {
                    $summprotege += $row;
                }else{
                    $countprotege += $row;
                }


            }
        }

        $collection = Yii::$app->getDb()
            ->createCommand("SELECT label,color "
                . " FROM `collections` WHERE `color` IS NOT NULL")->queryAll();

        foreach ($collection as $value){

            $highlightColors[$value['label']] = $value['color'];
            $colorColl[]= $value['color'];
        }

        foreach($data as $category => $rows){

            foreach ($rows['rows'] as $name =>$row){
                $aChartResult[$category."_".$name] = $row;

            }


            $aChartResult[$category."tooltip"] = '<table width="270px">
             <tr><td></td><td>'.$tooltiptime.'</td></tr>  
            <tr><td width="10%"><div class="google-visualization-tooltip-square" style="background-color:'.$highlightColors[$category].' "></div></td>';
            $aChartResult[$category."tooltip"] .= '<td width="80%"><p><b>'.$category.'</b></p>';
            $aChartResult[$category."tooltip"] .= '<p>'.$rows['rows']['count'].' пар ('.round(($rows['rows']['count']*100)/$countprotege).'%)</p>';
            $aChartResult[$category."tooltip"] .= '<p>'.$rows['rows']['summ'].' Р ('.round(($rows['rows']['summ']*100)/$summprotege).'%)</p>';
            $aChartResult[$category."tooltip"] .= '</td></tr></table>';
        }

        foreach($aLastData as $category => $rows){
            foreach ($rows['rows'] as $name =>$row){
                $aLastResult[$category."_".$name] = $row;
            }
        }

        foreach($aLastResultz as $key => $element){
            if(isset($result_average[$key])) {
                $aChangeResult[$key] = $element - $result_average[$key];
            }
        }
        // exit;
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
                'chartresult'=>$aChartResult,
                'result_average'=>$result_average,
                'period'=>$resPeriod,
                'changes'=>$aChangeResult,
                'cities_plan'=>$plan,
                'colorColl'=>$colorColl

            ]);
        }

    }


    public function actionUpdate()
    {
        $attributes = [];
        $value = '';
        $status = 'error';
        $message = 'Запись не найдена';
        $color = '';
        if (isset($_POST['id'])) {
            $money = Money::findOne($_POST['id']);
            /* @var $money Money */
            if ($money) {
                $type = $_POST['type'];
                $value = $_POST['value'];
                if ($type == 'payment_status') {
                    $value = intval($value);
                    if ($value == 1) {
                        // сверяем суммы оплаты
                        $amo = new Amo(\Yii::$app->params);
                        if ($amo->getErrorCode() == 0) {
                            $amounts = $amo->loadLeadAmounts($money->ext_id);
                            if (!empty($amounts)) {
                                if (floatval($money->first_payment_amount) != floatval($amounts[0])) {
                                    $money->first_payment_valid = 0;
                                    $money->first_payment_amount = floatval($amounts[0]);
                                } else {
                                    $money->first_payment_valid = 1;
                                }
                                if (floatval($money->second_payment_amount) != floatval($amounts[1])) {
                                    $money->second_payment_valid = 0;
                                    $money->second_payment_amount = floatval($amounts[1]);
                                } else {
                                    $money->second_payment_valid = 1;
                                }
                                $money->save();
                            }
                        }
                    }
                    if ($_POST['num'] == '1') {
                        $money->setAttribute('first_payment_status', $value);
                        $color = $money->getColor(1);
                    } else if ($_POST['num'] == '2') {
                        $money->setAttribute('second_payment_status', $value);
                        $color = $money->getColor(2);
                    } else {
                        $message = 'Неверный номер поля';
                        return Json::encode(['status' => $status, 'message' => $message]);
                    }
                } else if ($type == 'registry') {
                    $money->registry_check = intval($value);
                } else if ($type == 'bill_comment') {
                    // комментарий ТТН
                    $money->setAttribute('goods_bill_comment', $value);
                } else if ($type == 'comment') {
                    // общий комментарий
                    $money->setAttribute('comment', $value);
                }
                if ($money->save(false)) { // todo remove FALSE
                    $status = 'success';
                    $message = '';
                } else {
                    $message = 'Ошибка сохранения: ' . Html::errorSummary($money);
                }
                $attributes = $money->prepareColumnsValues();
            }
        }
        return Json::encode([
            'status' => $status,
            'message' => $message,
            'value' => $value, // new value of changed field
            'color' => $color,
            'attributes' => $attributes // all values of current model
        ]);
    }


    /**
     * Deletes an existing Job model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }


    protected function findModel($id)
    {
        if (($model = Money::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    /**
     * @param $num
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionWaybill($num)
    {
        $this->layout = 'blank';
        $num = explode('_', $num);
        $id = $num[0];
        $billNum = $num[1];
        $model = Money::findOne($id); /* @var $model Money */
        if (empty($model) || $model->goods_bill_num != $billNum) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $this->render('waybill', [
            'money' => $model,
        ]);
    }


    /**
     * Выгрузка в CSV
     * @return string
     */
    public function actionDownload()
    {
        $fileName = 'money-' . Yii::$app->request->get('date_period') . '.csv"';
        Yii::$app->response->headers
            ->add('Content-Type', 'text/csv')
            ->add('Content-Type', 'application/octet-stream')
            ->add('Content-Disposition', 'attachment; filename="' . $fileName)
            ->add('Content-Type', 'text/xml; charset=utf-8');
        $searchModel = new MoneySearch();
        $isYear = false;
        if (Yii::$app->request->get('date_period') == 'year') $isYear = true;

        $managername = Yii::$app->getDb()
            ->createCommand("SELECT responsible_user_id, name"
                . " FROM `manager`")
            ->queryAll();
        $manager = [];
        foreach($managername as $value){
            $manager[$value['responsible_user_id']] = $value['name'];
        }


        return $this->renderPartial('csv', [
            'year' => $isYear,
            'manager' => $manager,
            'models' => $searchModel->search(Yii::$app->request->queryParams),
        ]);
    }


    /**
     * Обновляет все данные сверяясь с AMOCRM по текущему периоду
     * @return string
     */
    public function actionAllForPeriodUpdate()
    {
        $startTime = microtime(true);
        $money = new Money();
        $amo = new Amo(\Yii::$app->params);
        $_SESSION['update_leads'] = isset($_SESSION['update_leads']) ? $_SESSION['update_leads'] : [];
        if (empty($_SESSION['update_leads'])) {
            $searchModel = new MoneySearch();
            $date = ['date_period' => Yii::$app->request->queryParams['date_period']];
            $models = $searchModel->search($date);
            $leadsId = [];
            foreach ($models as $model) {
                $leadsId[] = $model['ext_id'];
            }
            if (!empty($leadsId)) {
                $_SESSION['update_leads'] = $amo->getLeads($leadsId);
            }
        }
        if (!empty($_SESSION['update_leads'])) {
            while (count($_SESSION['update_leads']) > 0) {
                $currentTime = microtime(true);
                $lead = array_pop($_SESSION['update_leads']);
                $money->createFromAmo($lead);
                if (Lead::updateFromAmo($lead)) {
                    // ok
                }
                $s = count($_SESSION['update_leads']);
                if ($currentTime - $startTime > 25) {
                    if ($s > 0) {
                        return json_encode(['code' => 1, 'len' => $s]);
                    } else {
                        break;
                    }
                }
            }
            return json_encode(['code' => 0, 'len' => count($_SESSION['update_leads'])]);
        } else {
            return json_encode(['code' => 2, 'len'=>sizeof($_SESSION['update_leads'])]);
        }
    }


    /*
     *
     */
    public function actionUpdateAll()
    {
        $searchModel = new MoneySearch();
        $money = new Money();
        $amo = new Amo(\Yii::$app->params);
        $months = [];
        $ids = [];
        $date = ['date_period' => Yii::$app->request->queryParams['date_period']];
        $models = $searchModel->search($date);
        foreach ($models as $model)
        {
            $money->find()->where(['ext_id'=>$model['ext_id']])->one();
            $amo->getContactByLead($model['ext_id']);
            $money->save();
        }
        return "Даннвые успешно обновлены";
    }
}