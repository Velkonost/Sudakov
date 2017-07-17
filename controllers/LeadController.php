<?php

namespace app\controllers;

use app\models\LeadForm;
use Yii;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class LeadController extends \yii\web\Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'done', 'add'],
                        'allow' => true,
                        'roles' => ['manager-payment', 'superadmin'],
                    ],
                ],
                'denyCallback' => function() {
                    if (Yii::$app->user->isGuest) {
                        return $this->redirect('/site/login');
                    }
                    return $this->redirect('/site/no-access');
                }
            ],
        ];
    }


    public function actionIndex()
    {
        $this->redirect(['lead/add']);
    }


    public function actionAdd()
    {
        $error = '';
        $model = new LeadForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->saveLead()) {
                $this->redirect(['lead/done']);
            } else {
                $error = 'Ошибка сохранения. Не удалось создать сделку в AMOCRM.';
            }
        }
        return $this->render('add', [
            'model' => $model,
            'error' => $error
        ]);
    }


    public function actionDone()
    {
        return $this->render('done');
    }

}
