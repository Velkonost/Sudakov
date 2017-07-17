<?php
namespace app\controllers;

use app\models\Money;
use Yii;
use app\models\Amo;
use app\models\Payment;
use app\models\PaymentSearch;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

// Заметка по редиректам
// http://payment.sergeysudakov.ru/payment/success
// http://payment.sergeysudakov.ru/payment/checkout-success
// http://payment.sergeysudakov.ru/payment/fail

/**
 * PaymentController implements the CRUD actions for Payment model.
 */
class PaymentController extends Controller
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
                        'allow' => true,
                        'roles' => ['superadmin', 'manager-payment', 'acc_manager'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['superadmin'],
                    ],
                    [
                        'actions' => ['checkout', 'gateway', 'checkout-success', 'success', 'fail', 'check-parameters', 'test-page'],
                        'allow' => true,
                        'roles' => ['?', '@'],
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
                    'gateway' => ['POST', 'GET'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        // cancel CSRF check
        if (in_array($action->id, ['checkout-success', 'success', 'fail', 'check-parameters'])) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    /**
     * Lists all Payment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $pagination = null;
        $searchModel = new PaymentSearch();
        $models = $searchModel->search(Yii::$app->request->queryParams, $pagination);
        $user = Yii::$app->user->identity;
        return $this->render('index', [
            'user' => $user,
            'models' => $models,
            'pagination' => $pagination
        ]);
    }

    /**
     * Displays a single Payment model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $errors = '';
        $payment = $this->findModel($id);
        // обновляем имя клента по ext_id
        if (!empty($payment->ext_id)) {
            $amo = new Amo(\Yii::$app->params);
            if ($amo->getErrorCode() == 0) {
                $contact = $amo->getContactByLead($payment->ext_id);
                if (!empty($contact)) {
                    if (!empty($contact['company_name'])) {
                        $client = $contact['company_name'];
                    } else if (!empty($contact['name'])) {
                        $client = $contact['name'];
                    }
                    if ($payment->client != $client) {
                        $payment->client = $client;
                        $payment->save();
                    }
                } else {
                    $errors = 'Не удалось загрузить ФИО клиента! Нарушена связь со сделкой из АМО CRM. Возможно сделка была удалена.';
                }
            } else {
                $errors = 'Не удалось загрузить ФИО клиента! AMOCRM недоступен.';
            }
        } else {
            $payment->client = $payment->comment;
            $errors = 'Отсутствует привязка к сделке AMOCRM.';
        }
        return $this->render('view', [
            'model' => $payment,
            'errors' => $errors
        ]);
    }

    /**
     * Creates a new Payment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $errors = '';
        $payment = new Payment();
        $payment->client = 'нет имени';
        $payment->pnum = Payment::TYPE_P1;
        // check ext_id
        if (!empty($_GET['ext_id']) && is_numeric($_GET['ext_id']) && !empty($_GET['num']) && is_numeric($_GET['num'])) {
            $payment->pnum = ($_GET['num'] == Payment::TYPE_P2) ? Payment::TYPE_P2 : Payment::TYPE_P1;
            $find = Payment::find()->where(['ext_id' => $_GET['ext_id'], 'pnum' => $_GET['num']])->one();
            if (!empty($find)) {
                return $this->redirect(['payment/update', 'id' => $find->id]);
            }
            $payment->ext_id = $_GET['ext_id'];
            // читаем имя клента по ext_id
            if (!empty($payment->ext_id)) {
                $amo = new Amo(\Yii::$app->params);
                if ($amo->getErrorCode() == 0) {
                    $contact = $amo->getContactByLead($payment->ext_id);
                    if (!empty($contact)) {
                        if (!empty($contact['company_name'])) {
                            $payment->client = $contact['company_name'];
                        } else if (!empty($contact['name'])) {
                            $payment->client = $contact['name'];
                        }
                    } else {
                        $errors = 'Не удалось загрузить ФИО клиента! Нарушена связь со сделкой из АМО CRM. Возможно сделка была удалена.';
                    }
                } else {
                    $errors = 'Не удалось загрузить ФИО клиента! AMOCRM недоступен.';
                }
            } else {
                $errors = 'Отсутствует привязка к сделке AMOCRM.';
                $payment->client = $payment->comment;
            }
        }
        if ($payment->load(Yii::$app->request->post())) {
            $payment->manager = Yii::$app->user->identity->fio;
            if ($payment->save()) {
                if (!empty($_POST['Item'])) {
                    $items = [];
                    foreach ($_POST['Item']['product'] as $key => $item) {
                        // {"product":"Тестовый заказ","price":"100","count":"1","image":"818.jpg","description":"Описание"}
                        $price = floatval($_POST['Item']['price'][$key]);
                        if ($price > 0) {
                            $items[] = [
                                'product' => $_POST['Item']['product'][$key],
                                'price' => $price,
                                'count' => $_POST['Item']['count'][$key],
                                'description' => $_POST['Item']['description'][$key],
                            ];
                        }
                    }
                }
                $payment->items = json_encode($items);
                $payment->created_at = time();
                $payment->save();
                // генерируем ссылки на оплату и отправляем в AMO
                $hash = md5($payment->id . '&' . $payment->ext_id);
                $url = Yii::$app->getRequest()->getHostInfo();
                $url .= \yii\helpers\Url::toRoute(['payment/checkout', 'id' => $payment->id . '_' . $payment->created_at, 'hash' => $hash]);
                $amo = new Amo(\Yii::$app->params);
                if ($amo->getErrorCode() == 0) {
                    $amo->addLeadComment($payment->ext_id, "Ссылка на {$payment->pnum}-ю оплату {$url}");
                }
                return $this->redirect(['index']);
            }
        }
        $payment->status = ($payment->status === null) ? 0 : $payment->status;
        $payment->pnum = ($payment->pnum === null) ? 1 : $payment->pnum;
        $payment->ext_id = ($payment->ext_id === null) ? 0 : $payment->ext_id;
        return $this->render('create', [
            'model' => $payment,
            'errors' => $errors
        ]);
    }


    /**
     * Updates an existing Payment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $errors = '';
        $payment = $this->findModel($id);
        if (empty($payment)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        if ($payment->status == 1) {
            $this->redirect(['payment/view', 'id' => $payment->id]);
        }
        $payment->status = ($payment->status === null) ? 0 : $payment->status;
        $payment->pnum = ($payment->pnum === null) ? 1 : $payment->pnum;
        $payment->ext_id = ($payment->ext_id === null) ? 0 : $payment->ext_id;
        if ($payment->load(Yii::$app->request->post())) {
            if ($payment->save()) {
                if (!empty($_POST['Item'])) {
                    $items = [];
                    foreach ($_POST['Item']['product'] as $key => $item) {
                        // {"product":"Тестовый заказ","price":"100","count":"1","image":"818.jpg","description":"Описание"}
                        $price = floatval($_POST['Item']['price'][$key]);
                        if ($price > 0) {
                            $items[] = [
                                'product' => $_POST['Item']['product'][$key],
                                'price' => $price,
                                'count' => $_POST['Item']['count'][$key],
                                'description' => $_POST['Item']['description'][$key],
                            ];
                        }
                    }
                }
                $payment->items = json_encode($items);
                $payment->created_at = time();
                $payment->save(false);
                return $this->redirect(['index']);
            }
        }
        // обновляем имя клента по ext_id
        if (!empty($payment->ext_id)) {
            $amo = new Amo(\Yii::$app->params);
            if ($amo->getErrorCode() == 0) {
                $contact = $amo->getContactByLead($payment->ext_id);
                if (!empty($contact)) {
                    if (!empty($contact['company_name'])) {
                        $client = $contact['company_name'];
                    } else if (!empty($contact['name'])) {
                        $client = $contact['name'];
                    }
                    if ($payment->client != $client) {
                        $payment->client = $client;
                        $payment->save();
                    }
                } else {
                    $errors = 'Не удалось загрузить ФИО клиента!';
                }
            } else {
                $errors = 'Не удалось загрузить ФИО клиента! AMOCRM недоступен.';
            }
        } else {
            $errors = 'Отсутствует привязка к сделке AMOCRM.';
            $payment->client = $payment->comment;
        }
        return $this->render('update', [
            'model' => $payment,
            'errors' => $errors
        ]);
    }


    /**
     * Deletes an existing Payment model.
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
     * Finds the Payment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Payment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Payment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    /**
     * Checkout page
     */
    public function actionCheckout($id, $hash)
    {
        $modelId = explode('_', $id);
        $createdAt = $modelId[1];
        $modelId = $modelId[0];
        $this->layout = 'empty';
        $model = $this->findModel($modelId);
        if ($model) {
            $test = md5($model->id . '&' . $model->ext_id);
            if ($test == $hash && $model->created_at == $createdAt) {
                return $this->render('checkout', ['model' => $model, 'invoiceId' => $id]);
            }
        }
        Yii::$app->response->statusCode = 500;
        return $this->render('fail', ['message' => 'Транзакция не найдена']);
    }


    /**
     * Gateway
     */
    public function actionGateway()
    {
        $invoiceId = Yii::$app->request->post('id');
        $id = explode('_', $invoiceId);
        $createdAt = $id[1];
        $id = $id[0];
        $hash = Yii::$app->request->post('hash');
        $this->layout = 'empty';
        $model = $this->findModel($id);
        if ($model) {
            $test = md5($model->id . '&' . $model->ext_id);
            if ($test == $hash && $model->created_at == $createdAt) {
                return $this->render('gateway', ['model' => $model, 'invoiceId' => $invoiceId]);
            }
        }
        Yii::$app->response->statusCode = 500;
        return $this->render('fail', ['message' => 'Транзакция не найдена']);
    }


    /**
     * Success page
     */
    public function actionSuccess()
    {
        $this->layout = 'empty';
        $orderNumber = isset($_GET['orderNumber']) ? $_GET['orderNumber'] : '';
        if (empty($orderNumber)) {
            Yii::$app->response->statusCode = 500;
            return $this->render('fail', ['message' => 'Неверный код платежа']);
        } else {
            $id = explode('_', $orderNumber);
            $createdAt = $id[1];
            $id = $id[0];
            $model = Payment::findOne(['id' => $id]); /* @var $model Payment */
            if ($model && $model->created_at == $createdAt) {
                $hash = md5($model->id . '&' . $model->ext_id);
                $url = Url::to(['checkout', 'id' => $orderNumber, 'hash' => $hash]);
                return $this->redirect($url);
            }
        }
        Yii::$app->response->statusCode = 500;
        return $this->render('fail', ['message' => 'Транзакция не найдена']);
    }

    /**
     * Success checkout
     * Яндекс сюда присылает подтверждение об оплате.
     */
    public function actionCheckoutSuccess()
    {
        //file_put_contents(\Yii::$app->params['amoLogPath'] . "pay_CS_".date('dmY_His').".log", var_export(@$_POST, true));

        $shopID = Yii::$app->params['yandex']['shopID'];
        // HTTP parameters:
        //$requestDatetime = isset($_POST['requestDatetime']) ? $_POST['requestDatetime'] : '';
        $action = isset($_POST['action']) ? $_POST['action'] : '';
        //$md5 = isset($_POST['md5']) ? $_POST['md5'] : '';
        $reqShopId = isset($_POST['shopId']) ? $_POST['shopId'] : '';
        $invoiceId = isset($_POST['invoiceId']) ? $_POST['invoiceId'] : '';
        $orderCreatedDatetime = isset($_POST['orderCreatedDatetime']) ? $_POST['orderCreatedDatetime'] : '';
        $orderSumAmount = isset($_POST['orderSumAmount']) ? $_POST['orderSumAmount'] : '';
        //$orderSumCurrencyPaycash = isset($_POST['orderSumCurrencyPaycash']) ? $_POST['orderSumCurrencyPaycash'] : '';
        //$orderSumBankPaycash = isset($_POST['orderSumBankPaycash']) ? $_POST['orderSumBankPaycash'] : '';
        //$shopSumAmount = isset($_POST['shopSumAmount']) ? $_POST['shopSumAmount'] : '';
        //$shopSumCurrencyPaycash = isset($_POST['shopSumCurrencyPaycash']) ? $_POST['shopSumCurrencyPaycash'] : '';
        //$paymentPayerCode = isset($_POST['paymentPayerCode']) ? $_POST['paymentPayerCode'] : '';
        //$paymentType = isset($_POST['paymentType']) ? $_POST['paymentType'] : '';
        //$customerNumber = isset($_POST['customerNumber']) ? $_POST['customerNumber'] : '';
        $orderNumber = isset($_POST['orderNumber']) ? $_POST['orderNumber'] : ''; // ID счета

        /*
        Формат ответа
        Параметр	            Тип	            Описание
        performedDatetime       xs:dateTime     Момент обработки запроса по часам ИС Контрагента.
        code                	xs:int      	Код результата обработки. Список допустимых значений приведен в таблице ниже.
        shopId              	xs:long     	Идентификатор Контрагента. Должен дублировать поле shopId запроса.
        invoiceId           	xs:long     	Идентификатор транзакции в ИС Оператора. Должен дублировать поле invoiceId запроса.
        orderSumAmount	        CurrencyAmount	Стоимость заказа в валюте, определенной параметром запроса orderSumCurrencyPaycash.
        message	                xs:string       до 255 символов	Текстовое пояснение в случае отказа принять платеж.
        techMessage	            xs:string       до 64 символов	Дополнительное текстовое пояснение ответа Контрагента. Как правило, используется как дополнительная информация об ошибках. Необязательное поле.

        Код	    Значение	                Описание ситуации
        0	    Успешно	                    Контрагент дал согласие и готов принять перевод.
        1	    Ошибка авторизации	        Несовпадение значения параметра md5 с результатом расчета хэш-функции. Оператор считает ошибку окончательной и не будет осуществлять перевод.
        100	    Отказ в приеме перевода	    Отказ в приеме перевода с заданными параметрами. Оператор считает ошибку окончательной и не будет осуществлять перевод.
        200	    Ошибка разбора запроса	    ИС Контрагента не в состоянии разобрать запрос. Оператор считает ошибку окончательной и не будет осуществлять перевод.
        */

        if ($shopID != $reqShopId) {
            //file_put_contents(\Yii::$app->params['amoLogPath'] . "pay_CS_".date('dmY_His').".log", "\n'Неверный код магазина'", FILE_APPEND);
            exit($this->renderPartial('xml_response', [
                'responseType' => 'paymentAvisoResponse',
                'dateTime' => $orderCreatedDatetime,
                'code' => '1',
                'shopID' => $shopID,
                'invoiceId' => $invoiceId,
                'message' => 'Неверный код магазина'
            ]));
        }
        //file_put_contents(\Yii::$app->params['amoLogPath'] . "pay_CS_".date('dmY_His').".log", "\n SHOP OK", FILE_APPEND);
        if ($action != 'paymentAviso') {
            file_put_contents(\Yii::$app->params['amoLogPath'] . "pay_CS_".date('dmY_His').".log", "\n'Неверный код action'", FILE_APPEND);
            exit($this->renderPartial('xml_response', [
                'responseType' => 'paymentAvisoResponse',
                'dateTime' => $orderCreatedDatetime,
                'code' => '1',
                'shopID' => $shopID,
                'invoiceId' => $invoiceId,
                'message' => 'Неверный код action'
            ]));
        }
        //file_put_contents(\Yii::$app->params['amoLogPath'] . "pay_CS_".date('dmY_His').".log", "\n ACTION OK", FILE_APPEND);

        // находим нужный счет и сохраняем в него информацию об успешной оплате
        $id = explode('_', $orderNumber);
        $id = $id[0];
        $payment = Payment::findOne(['id' => $id]); /* @var $payment Payment */
        if (!$payment) {
            //file_put_contents(\Yii::$app->params['amoLogPath'] . "pay_CS_".date('dmY_His').".log", "\n'Неверный код заказа'", FILE_APPEND);
            exit($this->renderPartial('xml_response', [
                'responseType' => 'paymentAvisoResponse',
                'dateTime' => $orderCreatedDatetime,
                'code' => '1',
                'shopID' => $shopID,
                'invoiceId' => $invoiceId,
                'message' => 'Неверный код заказа'
            ]));
        } else {
            //file_put_contents(\Yii::$app->params['amoLogPath'] . "pay_CS_".date('dmY_His').".log", "\n MODEL OK", FILE_APPEND);
        }

        // payment successful

        $payment->setAttributes(['status' => Payment::STATUS_PAID, 'paid_at' => time()]);
        if (!$payment->save()) {
            //file_put_contents(\Yii::$app->params['amoLogPath'] . "pay_CS_".date('dmY_His').".log", "\n" . var_export($model->getErrors(), true), FILE_APPEND);
        } else {
            //file_put_contents(\Yii::$app->params['amoLogPath'] . "pay_CS_".date('dmY_His').".log", "\n MODEL SAVE OK", FILE_APPEND);
        }

        $money = Money::findOne(['ext_id' => $payment->ext_id]); /* @var $money Money */
        if ($money) {
            // обновляем статус финансовой записи
            $money->first_payment_method = Money::METHOD_YANDEX;
            if ($payment->pnum == '1') {
                $payment_method = 'pay_method_1_yandex';
                $payment_date = 'pay_date_1';
                //$money->first_payment_status = 1;
            } else {
                $payment_method = 'pay_method_2_yandex';
                $payment_date = 'pay_date_2';
                //$money->second_payment_status = 1;
            }

            // AMO
            $amo = new Amo(\Yii::$app->params);
            if ($amo->getErrorCode() == 0) {
                // обновляем дату ($money->ext_id == lead ID)
                $amo->setLeadCustomField($money->ext_id, [$payment_method, $payment_date => time()]);
                // сверяем суммы оплаты
                $amounts = $amo->loadLeadAmounts($money->ext_id);
                if (!empty($amounts)) {
                    if (floatval($money->first_payment_amount) != floatval($amounts[0])) {
                        $money->first_payment_valid = 0;
                        $money->first_payment_amount = floatval($amounts[0]);
                    }
                    if (floatval($money->second_payment_amount) != floatval($amounts[1])) {
                        $money->second_payment_valid = 0;
                        $money->second_payment_amount = floatval($amounts[1]);
                    }
                }
                $valid = ($payment->pnum == 2) ? 'second_payment_valid' : 'first_payment_valid';
                $field = ($payment->pnum == 2) ? 'second_payment_amount' : 'first_payment_amount';
                if ($payment->sum == $money->{$field}) {
                    $money->{$valid} = 1;
                } else {
                    $money->{$valid} = 0;
                }
            }
            $money->save();
        }

        //file_put_contents(\Yii::$app->params['amoLogPath'] . "pay_CS_".date('dmY_His').".log", "\n'ВСЕ КРУТО'", FILE_APPEND);
        exit($this->renderPartial('xml_response', [
            'responseType' => 'paymentAvisoResponse',
            'dateTime' => $orderCreatedDatetime,
            'code' => '0',
            'shopID' => $shopID,
            'invoiceId' => $invoiceId,
            'message' => ''
        ]));
    }


    /**
     * Проверка параметров оплаты
     */
    public function actionCheckParameters()
    {
        /* request
        array (
          'targetcurrency' => '643',
          'wbp_ShopKeyID' => '2350484147',
          'shopSumBankPaycash' => '1003',
          'cps_theme' => 'default',
          'isOUTshop' => 'true',
          'requestDatetime' => '2015-02-25T15:11:24.384+03:00',
          'wbp_shoperrorinfo' => 'Shop error',
          'merchant_order_id' => '1421646753_10170_250215151055_00000_3113',
          'customerNumber' => 'jbyss@yandex.ru',
          'sumCurrency' => '10643',
          'wbp_Version' => '2',
          'shopSumAmount' => '538.35',
          'cps_user_country_code' => 'RU',
          'wbp_ShopEncryptionKey' => 'hAAAEicBAI/gWZ7nPmvPCEf6CyNZrDT/M5dqhxF0IQeB+pv7vetU1a35irDRuShgwsyUjxsUxHiwFgoOO51QqednVreeWZO16APsHZhWFQGw4cZhSzOlC5470PgGSGt/MZTqxetuSYe9ZbnaOMXqy3grEkzB/Z1iim40KHtTyewiIiXJhAKJ',
          'ErrorTemplate' => 'ym2xmlerror',
          'shopSumCurrencyPaycash' => '10643',
          'orderSumAmount' => '555.00',
          'cps_user_ip' => '46.233.204.241',
          'shopId' => '31132',
          'successURL' => '',
          'action' => 'checkOrder',
          'orderSumCurrencyPaycash' => '10643',
          'cps_changeSum' => 'false',
          'payment-name' => 'ИП Судаков Сергей Евгеньевич',
          'cps_rebillingAllowed' => 'false',
          'orderSumBankPaycash' => '1003',
          'wbp_ShopAddress' => '77.75.157.167:9128',
          'invoiceId' => '2000000413908',
          'paymentType' => 'PC',
          'wbp_CorrespondentID' => 'F55EFDE2D16BA0456B2DDBE468A6C0F8B1D0D105',
          'orderCreatedDatetime' => '2015-02-25T15:10:57.387+03:00',
          'paymentPayerCode' => '4100322344779',
          'wbp_ShopAdditionalAddress' => '77.75.157.167:9138',
          'rebillingOn' => 'false',
          'wbp_InactivityPeriod' => '2',
          'isViaWeb' => 'true',
          'orderNumber' => '1421646753_10170',
          'md5' => 'D55D81D2BFC6C5BA2A98D3F1153C57E5',
          'cps_region_id' => '66',
          'SuccessTemplate' => 'ym2xmlsuccess',
          'WAShopID' => '1936803660',
          'cps-source' => 'default',
          'nst_unilabel' => '1c7fcf8f-0001-5000-8000-00000003527b',
          'wbp_messagetype' => 'MoneyInvitationRequest',
          'scid' => '59606',
        )
        */

        //file_put_contents(\Yii::$app->params['amoLogPath'] . "pay_CP_".date('dmY_His').".log", var_export($_REQUEST, true));

        $shopID = Yii::$app->params['yandex']['shopID'];
        $shopPassword = Yii::$app->params['yandex']['password'];

        // HTTP parameters:
        //$requestDatetime = isset($_POST['requestDatetime']) ? $_POST['requestDatetime'] : '';
        $action = isset($_POST['action']) ? $_POST['action'] : '';
        $md5 = isset($_POST['md5']) ? $_POST['md5'] : '';
        $reqShopId = isset($_POST['shopId']) ? $_POST['shopId'] : '';
        $invoiceId = isset($_POST['invoiceId']) ? $_POST['invoiceId'] : '';
        $orderCreatedDatetime = isset($_POST['orderCreatedDatetime']) ? $_POST['orderCreatedDatetime'] : '';
        $orderSumAmount = isset($_POST['orderSumAmount']) ? $_POST['orderSumAmount'] : '';
        $orderSumCurrencyPaycash = isset($_POST['orderSumCurrencyPaycash']) ? $_POST['orderSumCurrencyPaycash'] : '';
        $orderSumBankPaycash = isset($_POST['orderSumBankPaycash']) ? $_POST['orderSumBankPaycash'] : '';
        //$shopSumAmount = isset($_POST['shopSumAmount']) ? $_POST['shopSumAmount'] : '';
        //$shopSumCurrencyPaycash = isset($_POST['shopSumCurrencyPaycash']) ? $_POST['shopSumCurrencyPaycash'] : '';
        //$paymentPayerCode = isset($_POST['paymentPayerCode']) ? $_POST['paymentPayerCode'] : '';
        //$paymentType = isset($_POST['paymentType']) ? $_POST['paymentType'] : '';
        $customerNumber = isset($_POST['customerNumber']) ? $_POST['customerNumber'] : '';
        $orderNumber = isset($_POST['orderNumber']) ? $_POST['orderNumber'] : '';

        /*
         Формат ответа

        Параметр	            Тип	            Описание
        performedDatetime       xs:dateTime     Момент обработки запроса по часам ИС Контрагента.
        code                	xs:int      	Код результата обработки. Список допустимых значений приведен в таблице ниже.
        shopId              	xs:long     	Идентификатор Контрагента. Должен дублировать поле shopId запроса.
        invoiceId           	xs:long     	Идентификатор транзакции в ИС Оператора. Должен дублировать поле invoiceId запроса.
        orderSumAmount	        CurrencyAmount	Стоимость заказа в валюте, определенной параметром запроса orderSumCurrencyPaycash.
        message	                xs:string       до 255 символов	Текстовое пояснение в случае отказа принять платеж.
        techMessage	            xs:string       до 64 символов	Дополнительное текстовое пояснение ответа Контрагента. Как правило, используется как дополнительная информация об ошибках. Необязательное поле.

        Код	    Значение	                Описание ситуации
        0	    Успешно	                    Контрагент дал согласие и готов принять перевод.
        1	    Ошибка авторизации	        Несовпадение значения параметра md5 с результатом расчета хэш-функции. Оператор считает ошибку окончательной и не будет осуществлять перевод.
        100	    Отказ в приеме перевода	    Отказ в приеме перевода с заданными параметрами. Оператор считает ошибку окончательной и не будет осуществлять перевод.
        200	    Ошибка разбора запроса	    ИС Контрагента не в состоянии разобрать запрос. Оператор считает ошибку окончательной и не будет осуществлять перевод.
        */


        if ($shopID != $reqShopId) {
            //file_put_contents(\Yii::$app->params['amoLogPath'] . "pay_CP_".date('dmY_His').".log", "\n'Неверный код магазина'", FILE_APPEND);
            exit($this->renderPartial('xml_response', [
                'responseType' => 'checkOrderResponse',
                'dateTime' => $orderCreatedDatetime,
                'code' => '100',
                'shopID' => $shopID,
                'invoiceId' => $invoiceId,
                'message' => 'Неверный код магазина'
            ]));
        }

        if ($action != 'checkOrder') {
            //file_put_contents(\Yii::$app->params['amoLogPath'] . "pay_CP_".date('dmY_His').".log", "\n'Неверный код action'", FILE_APPEND);
            exit($this->renderPartial('xml_response', [
                'responseType' => 'checkOrderResponse',
                'dateTime' => $orderCreatedDatetime,
                'code' => '100',
                'shopID' => $shopID,
                'invoiceId' => $invoiceId,
                'message' => 'Неверный код action'
            ]));
        }

        // сверяем md5
        //action;orderSumAmount;orderSumCurrencyPaycash;orderSumBankPaycash;shopId;invoiceId;customerNumber;shopPassword
        $myMD5 = md5($action . ';' . $orderSumAmount . ';' . $orderSumCurrencyPaycash . ';' . $orderSumBankPaycash . ';'
            . $shopID . ';' . $invoiceId . ';' . $customerNumber . ';' . $shopPassword);
        if (strtoupper($myMD5) != strtoupper($md5)) {
            //file_put_contents(\Yii::$app->params['amoLogPath'] . "pay_CP_".date('dmY_His').".log", "\n'Неверный хеш md5'", FILE_APPEND);
            exit($this->renderPartial('gateway', [
                'responseType' => 'checkOrderResponse',
                'dateTime' => $orderCreatedDatetime,
                'code' => '100',
                'shopID' => $shopID,
                'invoiceId' => $invoiceId,
                'message' => 'Неверный хеш md5'
            ]));
        }
        // проверяем заказ и сумму
        $id = explode('_', $orderNumber);
        $id = $id[0];
        $model = Payment::findOne(['id' => $id]);
        if (!$model) {
            //file_put_contents(\Yii::$app->params['amoLogPath'] . "pay_CP_".date('dmY_His').".log", "\n'Неверный код заказа'", FILE_APPEND);
            exit($this->renderPartial('xml_response', [
                'responseType' => 'checkOrderResponse',
                'dateTime' => $orderCreatedDatetime,
                'code' => '100',
                'shopID' => $shopID,
                'invoiceId' => $invoiceId,
                'message' => 'Неверный код заказа'
            ]));
        }
        if (floatval($orderSumAmount) != floatval($model->sum)) {
            //file_put_contents(\Yii::$app->params['amoLogPath'] . "pay_CP_".date('dmY_His').".log", "\n'Не совпадает сумма заказа'", FILE_APPEND);
            exit($this->renderPartial('xml_response', [
                'responseType' => 'checkOrderResponse',
                'dateTime' => $orderCreatedDatetime,
                'code' => '100',
                'shopID' => $shopID,
                'invoiceId' => $invoiceId,
                'message' => 'Не совпадает сумма заказа'
            ]));
        }
        // success
        //file_put_contents(\Yii::$app->params['amoLogPath'] . "pay_CP_".date('dmY_His').".log", "\n'ВСЕ КРУТО!'", FILE_APPEND);
        exit($this->renderPartial('xml_response', [
            'responseType' => 'checkOrderResponse',
            'dateTime' => $orderCreatedDatetime,
            'code' => '0',
            'shopID' => $shopID,
            'invoiceId' => $invoiceId,
            'message' => ''
        ]));
    }


    /**
     * Fail page
     */
    public function actionFail()
    {
        return $this->render('fail', ['message' => 'Оплата не удалась']);
    }

    /**
     * Test page
     */
    public function actionTestPage()
    {
        return $this->render('fail', ['message' => 'Тестовая страница работает']);
    }

}
