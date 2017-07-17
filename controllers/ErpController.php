<?php

namespace app\controllers;

use app\models\Log;
use app\models\Money;
use app\models\User;
use app\models\Amo;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Job;
use app\models\JobSearch;
use yii\web\NotFoundHttpException;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;

class ErpController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'printjob'],
                        'allow' => true,
                        'roles' => ['admin', 'superadmin', 'worker', 'acc_manager'],
                    ],
                    [
                        'actions' => ['update-status', 'delete', 'update-adminchek'],
                        'allow' => true,
                        'roles' => ['admin', 'superadmin'],
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
                    'logout' => ['post'],
                    'delete' => ['post'],
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
        ];
    }



    /**
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {
        // если не админ, редиректим на страницу соотв. поддомену
        $user = Yii::$app->user->identity;
        if (!$user->hasRole('superadmin')) {
            $sd = Yii::$app->params['subdomain'];
            if ($sd == 'payment') {
                return $this->redirect('/payment/index');
            } else if ($sd == 'money') {
                return $this->redirect('/money/index');
            }
        }

        $searchModel = new JobSearch();
        $models = $searchModel->search(Yii::$app->request->queryParams);
        $countjobs = $searchModel->searchAllStatusJob();
        $jobsstatuscount = $searchModel->searchCountStatusJob();
        $pages = new Pagination(['totalCount' => sizeof($models), 'pageSize' => 100]);
        $pages->pageSizeParam = false;
        $models = array_slice($models, $pages->offset, $pages->limit);//$models->offset($pages->offset)

        return $this->render('index', [
            'user' => $user,
            'countjobs' => $countjobs,
            'jobsstatuscount' => $jobsstatuscount,
            'models' => $models,
            'pages' => $pages
        ]);
    }

    public function actionPrintjob()
    {
        // если не админ, редиректим на страницу соотв. поддомену
        $user = Yii::$app->user->identity;
        if (!$user->hasRole('superadmin')) {
            $sd = Yii::$app->params['subdomain'];
            if ($sd == 'payment') {
                return $this->redirect('/payment/index');
            } else if ($sd == 'money') {
                return $this->redirect('/money/index');
            }
        }



        $searchModel = new JobSearch();
        $array = $searchModel->searchJobId(Yii::$app->request->queryParams);
        if(strripos(Yii::$app->request->queryParams['id'],',') === false){
            $result = ArrayHelper::index($array['custom_fields'], 'id');
            unset($array['custom_fields']);
            $array['custom_fields'] = $result;
            $array = array($array);
        }else{
            foreach ($array as $key => $value){
                $result = ArrayHelper::index($value['custom_fields'], 'id');
                unset($array[$key]['custom_fields']);
                $array[$key]['custom_fields'] = $result;

            }
        }
       // var_dump($array); exit;


        return $this->renderPartial('printjob', [
            'lead' => $array,
        ]);
    }

   


    /**
     * Displays a single Job model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $user = Yii::$app->user->identity;
        $model = $this->findModel($id);
        $logs = Log::find()->orderBy('created_at DESC')->where(['job_id' => $id])->all();

        // изображения уже подготовленные (прямые ссылки на рисунки) и сохранены в виде массива json
        $images = json_decode($model->sketch, true);
        if (empty($images)) {
            //$images = ['k1' => '/images/test.jpg', 'k2' => '/images/test2.jpg'];
            $images = [];
        }
        // ссылки на  DXF
        $drawsDXF = json_decode($model->plan, true);
        if (empty($drawsDXF)) {
            //$drawsDXF = ['k1' => ['file1', '/images/test.jpg'], 'k2' => ['file2', '/images/test.jpg']];
            $drawsDXF = [];
        }
        // ссылки на чертежи AI
        $drawsAI = json_decode($model->plan_ai, true);
        if (empty($drawsAI)) {
            //$drawsAI = ['k1' => ['file1', '/images/test.jpg'], 'k2' => ['file2', '/images/test.jpg']];
            $drawsAI = [];
        }
        // описания чертежей
        $planDescription = json_decode($model->plan_description, true);
        if (empty($planDescription)) {
            //$planDescription = ['k1' => 'description 1', 'k2' => 'description 2'];
            $planDescription = [];
        }

        return $this->render('view', [
            'user' => $user,
            'drawsDXF' => $drawsDXF,
            'drawsAI' => $drawsAI,
            'planDescription' => $planDescription,
            'images' => $images,
            'model' => $model,
            'logs' => $logs,
        ]);
    }


    /**
     * @param integer $id
     * @param integer $status
     * @return mixed
     */
    public function actionUpdateStatus($id, $status)
{
    $user = Yii::$app->user->identity; /* @var $user User */
    $model = $this->findModel($id);
    if ($model) {
        $oldStatus = $model->status;
        $money = Money::findOne(['ext_id' => $model->ext_id]); /* @var $money Money */
        if ($money) {
            if ($model->status == 0 && $status > 0 && !in_array($status, [Job::STATUS_TRASH, Job::STATUS_DONE, Job::STATUS_FAIL])) { // начало работ (любой статус)
                $model->started_at = time();
            }
        }
        $model->status = $status;
        if ($status == 90 || $status == 100) { // успешно реализовано
            $model->finished_at = time(); // запоминаем дату
            // запоминаем ту же дату в money
            if ($money) {
                $money->finished_at = $model->finished_at;
                $money->save();
            }
            // меняем статус в AMO
            // TODO временно отключено, не удалять
            //$amo = new Amo(\Yii::$app->params);
            //if ($amo->getErrorCode() == 0) {
            //    // обновляем дату ($money->ext_id == lead ID)
            //   $amo->setLeadField($model->ext_id, ['status_id' => Amo::STATUS_PRODUCT_DONE]);
            //}
        } else {
            if ($money) {
                $money->finished_at = 0;
                $money->save();
            }
        }
        if ($model->validate() && $model->save()) {
            $log = new Log();
            $log->setAttributes(['job_id' => $id, 'old_status' => $oldStatus, 'new_status' => $status,
                'created_at' => time(), 'username' => $user->username]);
            $log->save(false);
            return Json::encode(['status' => 'success', 'mesage' => '']);
        } else {
            return Json::encode(['status' => 'error', 'mesage' => 'wrong status key']);
        }
    }
    return Json::encode(['status' => 'error', 'mesage' => 'not found ID ' . $id]);
}

    public function actionUpdateAdminchek($id, $chek)
    {
        $model = $this->findModel($id);
        if ($model) {
            $model->adminchek = $chek;
            if ($model->validate() && $model->save()) {
                return Json::encode(['status' => 'success', 'mesage' => '']);
            } else {
                return Json::encode(['status' => 'error', 'mesage' => 'wrong status key']);
            }
        }
        return Json::encode(['status' => 'error', 'mesage' => 'not found ID ' . $id]);
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

    /**
     * Finds the Job model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Job the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Job::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
