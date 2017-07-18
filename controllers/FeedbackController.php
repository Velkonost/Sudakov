<?php

namespace app\controllers;

use Yii;
use app\models\Feedback;
use app\models\Amo;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * FeedbackController implements the CRUD actions for Feedback model.
 */
class FeedbackController extends Controller
{
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
                        'actions' => ['index',],
                        'allow' => true,
                        'roles' => ['superadmin', 'manager-payment', 'acc_manager'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
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

    public function beforeAction($action)
    {
        if ($action->id == 'create') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    /**
     * Lists all Feedback models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Feedback::find()->orderBy(['date' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        $feedbacks = $dataProvider->getModels();
        $pagination = $dataProvider->getPagination();
        return $this->render('index', [
            'feedbacks' => $feedbacks,
            'pagination' => $pagination,
        ]);
    }


    /**
     * Creates a new Feedback model.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        if (!empty($_POST['id']) && !empty($_POST['comment'])) {
            $id = $_POST['id'];
            $comment = $_POST['comment'];

            $amo = new Amo(\Yii::$app->params);
            if ($amo->getErrorCode() == 0) {
                // берем лид из AmoCRM
                $lead = $amo->getLead($id);
                if (empty($lead)) {
                    // сделки не существует;
                    exit('ERROR');
                }

                //обработка для телефона
                $phone = '';
                $contact = $amo->getContactByLead($id);
                if (!empty($contact['custom_fields'])) {
                    $custom_fields = $contact['custom_fields'];
                    foreach ($custom_fields as $custom_field) {
                        foreach ($custom_field as $key => $value) {
                            if ($key == 'code' && $value == 'PHONE') {
                                $phone = $custom_field['values'][0]['value'];
                            }
                        }

                    }
                }

                // обработка для ФИО
                $fio = '';
                $links = $amo->getLinks($id);
                if (!empty($links['links'][0]['contact_id'])) {
                    $contacts = $amo->getContact($links['links'][0]['contact_id']);
                    if (!empty($contacts['contacts'][0]['name'])) {
                        $fio = $contacts['contacts'][0]['name'];
                    }
                }
                // обработка для эскиза
                $sketch = '';
                foreach ($lead['custom_fields'] as $key => $field) {
                    if ($field['id'] == Amo::FIELD_SKETCH1) {
                        $sketch = $field['values'][0]['value'];
                        if (stripos($sketch, 'dropbox') !== false) {
                            $sketch = str_replace('?dl=0', '?dl=1', $sketch);
                        }
                    }
                }
                $model = new Feedback([
                    'date' => time(), // TODO правильней так "created_at", к тому же DATE совпадает с системной командой SQL
                    'fio' => $fio,
                    'budget' => $lead['price'],
                    'thumbnail' => $sketch,
                    'text' => $comment,
                    'phone' => $phone,
                    'ext_id' => $id,
                ]);
                $model->save();
                exit('OK');
            }
        }
        exit('ERROR');
    }


    /**
     * Deletes an existing Feedback model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
//    public function actionDelete($id)
//    {
//        $this->findModel($id)->delete();
//
//        return $this->redirect(['index']);
//    }

    /**
     * Finds the Feedback model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Feedback the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Feedback::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
