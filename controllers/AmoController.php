<?php

namespace app\controllers;

use app\models\LeadLog;
use app\models\Option;
use app\models\QueueLeads;
use app\models\ManagerOption;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;
use app\models\Job;
use app\models\Amo;
use app\models\Payment;
use app\models\Money;
use yii\helpers\Html;
//use app\models\LeadStatus;
use app\models\Lead;
use app\models\AssigmentLeads;

class AmoController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['web-hook', 'add-paylinks', 'reload-statuses', 'allocation-request', 'set-allocation'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
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


    public function beforeAction($action)
    {
        if (in_array($action->id, ['web-hook', 'allocation-request', 'set-allocation'])) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }


    /**
     * Перехват заявок из AMO CRM
     */
    public function actionWebHook()
    {
        $path = \Yii::$app->params['amoLogPath'];
        $toDate = \Yii::$app->params['amoLogToDate'];
        $now = time();
        if (empty($_POST)) {
            file_put_contents($path . "amo_empty_{$now}.log", 'empty_request');
            exit('FAIL');
        }
        if (@$_POST['account']['subdomain'] == \Yii::$app->params['amoSubdomain']) {
            if (isset($_POST['leads']['status'])) { // TODO похоже, что этот хук больше не существует, но на всякий случай оставим
                // смена статуса
                /*
                foreach ($_POST['leads']['status'] as $lead) {
                    if ($toDate > $now) {
                        file_put_contents($path . "amo_post_{$now}_{$lead['id']}.log", var_export($_REQUEST, true), FILE_APPEND);
                    }
                    if (@$lead['status_id'] == Amo::STATUS_FACTORY_BEGIN) { // если был изменен статус сделки на "начало работ", то добавляем новый заказ в ERP
                        file_put_contents($path . "_save_job_{$lead['id']}.log", "Добавление новой работы\n");
                        $job = new Job();
                        $job->insertFromAmo($lead);
                        if ($job->saveData()) {
                            file_put_contents($path . "_save_job_{$lead['id']}.log", "Успешно сохранено\n");
                        }
                    }
                    // пишем смену статуса в логи
                    Lead::updateLeadAmoStatus($lead);
                    // обновляем статус в money
                    $money = Money::find()->where(['ext_id' => $lead['id']])->one(); / * @var $money Money * /
                    if (!empty($money)) {
                        $money->lead_status = $lead['status_id'];
                        if (!$money->save()) {
                            $errors = Html::errorSummary($money);
                            file_put_contents($path . "_error_money_status_{$lead['id']}.log", var_export($errors, true), 8);
                        }
                        if ($lead['status_id'] == Amo::STATUS_SHIPPING && $money->goods_bill_num == 0) { // если статус "на доставке", то нужно создать ТТН
                            $num = $money->createTTN();
                            if ($num !== false) {
                                // отправляем ссылку на ТТН в AMO
                                $url = 'http://' . $_SERVER['HTTP_HOST'] . '/money/waybill?num=' . $money->id . '_' . $num;
                                $amo = new Amo(\Yii::$app->params);
                                if ($amo->getErrorCode() == 0) {
                                    $amo->addLeadComment($lead['id'], "Ссылка на накладную\n{$url}");
                                }
                            }
                        }
                    }
                    $model = Lead::updateFromAmo($lead);
                    if ($model && $model->hasErrors()) {
                        file_put_contents($path . "_error_add_lead_{$lead['id']}.log", var_export($model->getErrors(), true), 8);
                    }
                }
                */
            } else if (isset($_POST['leads']['add'])) {
                // НОВАЯ СДЕЛКА
                foreach ($_POST['leads']['add'] as $lead) {
                    if ($toDate > $now) {
                        file_put_contents($path . "amo_post_{$now}_{$lead['id']}.log", var_export($_REQUEST, true), FILE_APPEND);
                    }
                    $leadId = $lead['id'];
                    // нужно сгенерировать две ссылки на оплату и сохранить в поля сделки
                    $link1 = 'http://erp.sergeysudakov.ru/payment/create?ext_id=' . $leadId . '&num=1';
                    $link2 = 'http://erp.sergeysudakov.ru/payment/create?ext_id=' . $leadId . '&num=2';
                    $amo = new Amo(\Yii::$app->params);
                    if ($amo->getErrorCode() == 0) {
                        $amo->addLeadComment($leadId, "Ссылки на создание оплаты:\nна первую оплату {$link1} \nна вторую оплату {$link2}");
                    }
                    // добавляем сделку в нашу таблицу
                    $model = Lead::updateFromAmo($lead);
                    if ($model && $model->hasErrors()) {
                        file_put_contents($path . "_error_add_lead_{$leadId}.log", var_export($model->getErrors(), true), 8);
                    }
                    // Добавление в таблицу обработки очереди заказов
                    // TODO: Создать константу id Судакова: 220428
                    if ($lead['responsible_user_id'] == Amo::LEAD_ACCOUNT || $lead['responsible_user_id'] == '220428')  { // ID судакова
                        $queueLeads = new QueueLeads();
                        $queueLeads->lead_id = $leadId;
                        $queueLeads->created_at = time();
                        if (!$queueLeads->save()) {
                            file_put_contents($path . "_error_queue_{$leadId}.log", var_export($queueLeads->getErrors(), true), 8);
                        }
                    } else {
                        // Когда уже заявка имеет ответственного то в лог её сразу
                        $assignmentLeads = new AssigmentLeads();
                        $assignmentLeads->status = AssigmentLeads::STATUS_ACCEPTED;
                        $assignmentLeads->log = 1;
                        $assignmentLeads->lead_id = $leadId;
                        $assignmentLeads->created_at = $lead['date_create'];
                        $assignmentLeads->manager_id = $lead['responsible_user_id'];
                        if (!$assignmentLeads->save()) {
                            file_put_contents($path . "_error_assignment_{$leadId}.log", var_export($assignmentLeads->getErrors(), true), 8);
                        }
                    }
                }
            } else if (isset($_POST['leads']['update'])) {
                // сделка обновлена
                foreach ($_POST['leads']['update'] as $lead) {
                    if ($toDate > $now) {
                        file_put_contents($path . "amo_post_{$now}_{$lead['id']}.log", var_export($_REQUEST, true), FILE_APPEND);
                    }
                    $money = Money::find()->where(['ext_id' => $lead['id']])->one(); /* @var $money Money */ // just for check
                    if (!empty($money)) {
                        // сделка существует в money
                        $money->updateFromAmo($lead);
                        if (!$money->save()) {
                            $errors = Html::errorSummary($money);
                            file_put_contents($path . "_error_money_update_{$lead['id']}.log", var_export($errors, true), 8);
                        }
                    } else {
                        // сделки не существует в money
                        file_put_contents($path . "_no_money_{$lead['id']}.log", "Не найдено 'ext_id' => {$lead['id']} :\n", 8);
                        if (!empty($lead['custom_fields'])) { // проверяем пользовательский поля сделки
                            // пока что тут только одна реакция - создание записи в системе учета
                            // ищем поле '1-я оплата' c любым значением
                            file_put_contents($path . "_no_money_{$lead['id']}.log", "Проверяем поля...\n", 8);
                            $isFound = false;
                            foreach ($lead['custom_fields'] as $field) {
                                if ($field['id'] == Amo::FIELD_FINAL_AMOUNT) {
                                    file_put_contents($path . "_no_money_{$lead['id']}.log", "Сумма = '{$field['values'][0]['value']}'\n", 8);
                                    if (!empty($field['values'][0]['value'])) {
                                        // создание записи в Money, если ее там нет
                                        file_put_contents($path . "_no_money_{$lead['id']}.log", "Пытаемся создать сделку...\n", 8);
                                        $newMoney = Money::createFromAmo($lead);
                                        file_put_contents($path . "_no_money_{$lead['id']}.log", "Проверяем на ошибки...\n", 8);
                                        if ($newMoney->hasErrors()) {
                                            file_put_contents($path . "_error_money_save_{$lead['id']}.log",
                                                "Ошибка при попытке создать сделку в Money\n" . var_export($newMoney->getErrors(), true), 8);
                                        } else {
                                            file_put_contents($path . "_no_money_{$lead['id']}.log", "Создано! \n" . var_export($newMoney->getAttributes(), true), 8);
                                        }
                                        $isFound = true;
                                    }
                                } else if ($field['id'] == 'xxx') {
                                    // что-то еще
                                } else {

                                }
                            }
                            if (!$isFound) {
                                file_put_contents($path . "_no_money_{$lead['id']}.log", "Отслеживаемых полей нет.\n", 8);
                            }
                        }
                    }
                    // обновление имени клиента в платежках
                    $payment = Payment::findOne(['ext_id' => $lead['id']]); /* @var $payment Payment */
                    if ($payment) {
                        $amo = new Amo(\Yii::$app->params);
                        if ($amo->getErrorCode() == 0) {
                            $contact = $amo->getContactByLead($lead['id']);
                            if (!empty($contact)) {
                                $payment->client = !empty($contact['company_name'])
                                    ? $contact['company_name'] : (!empty($contact['name']) ? $contact['name'] : '--нет имени--');
                                $payment->save();
                            }
                        }
                    }
                    // обновление в производстве
                    if (Job::updateFromAmo($lead)) {
                        // ok
                    }
                    // проверяем, была ли смена статуса сделки
                    Lead::updateLeadAmoStatus($lead, $isStatusChanged);
                    if ($isStatusChanged === true) { // если статус и правда поменялся, то
                        if (@$lead['status_id'] == Amo::STATUS_FACTORY_BEGIN) { // если был изменен статус сделки на "начало работ", то добавляем новый заказ в ERP
                            file_put_contents($path . "_save_job_{$lead['id']}.log", "Добавление новой работы\n");
                            $job = new Job();
                            $job->insertFromAmo($lead);
                            if ($job->saveData()) {
                                file_put_contents($path . "_save_job_{$lead['id']}.log", "Успешно сохранено\n");
                            }
                        }
                        // обновляем статус в money
                        $money = Money::find()->where(['ext_id' => $lead['id']])->one();
                        /* @var $money Money */
                        if (!empty($money)) {
                            $money->lead_status = $lead['status_id'];
                            if (!$money->save()) {
                                $errors = Html::errorSummary($money);
                                file_put_contents($path . "_error_money_status_{$lead['id']}.log", var_export($errors, true), 8);
                            }
                            if ($lead['status_id'] == Amo::STATUS_SHIPPING && $money->goods_bill_num == 0) { // если статус "на доставке", то нужно создать ТТН
                                $num = $money->createTTN();
                                if ($num !== false) {
                                    // отправляем ссылку на ТТН в AMO
                                    $url = 'http://' . $_SERVER['HTTP_HOST'] . '/money/waybill?num=' . $money->id . '_' . $num;
                                    $amo = new Amo(\Yii::$app->params);
                                    if ($amo->getErrorCode() == 0) {
                                        $amo->addLeadComment($lead['id'], "Ссылка на накладную\n{$url}");
                                    }
                                }
                            }
                        }
                    }
                    $model = Lead::updateFromAmo($lead);
                    if ($model && $model->hasErrors()) {
                        file_put_contents($path . "_error_add_lead_{$lead['id']}.log", var_export($model->getErrors(), true), 8);
                    }
                }
            } else if (isset($_POST['leads']['delete'])) {
                // сделка удалена, удаляем связанные записи
                foreach ($_POST['leads']['update'] as $lead) {
                    if ($toDate > $now) {
                        file_put_contents($path . "amo_post_{$now}_{$lead['id']}.log", var_export($_REQUEST, true), FILE_APPEND);
                    }
                    file_put_contents($path . "_delete_lead_{$lead['id']}.log", "Удалена запись.", 8);
                    $job = Job::findOne(['ext_id' => $lead['id']]); /* @var $job Job */
                    if ($job) {
                        if ($job->status != Job::STATUS_NEW) {
                            //$job->delete();
                        } else {
                            $job->status = Job::STATUS_FAIL;
                            $job->save(false);
                        }
                    }
                    $lead = Lead::findOne(['ext_id' => $lead['id']]);
                    if ($lead) {
                        $lead->delete();
                    }
                }
            }
        } else {
            file_put_contents($path . "web-hook.fail.log", "hook domain: {$_POST['account']['subdomain']}\nParams domain: " . \Yii::$app->params['amoSubdomain'] . "\n\n", FILE_APPEND);
        }
        exit('OK');
    }


    /**
     * Обновляет список статусов из настроек AMOCRM
     * Запускается вручную
     */
    public function actionReloadStatuses()
    {
        $amo = new Amo(\Yii::$app->params);
        if ($amo->getErrorCode() == 0) {
            $statuses = $amo->reloadStatusesList();
            return $this->render('statuses', ['statuses' => $statuses]);
        } else {
            exit("FAIL");
        }
    }

    /**
     * Пересоздает ссылки на оплату для лидов старше указанной даты
     * Запускается вручную
     */
    public function actionAddPaylinks()
    {
        $fromDate = Yii::$app->request->get('from');
        $fromDate .= ' 00:00:00';
        $fromDate = date_create_from_format('d-m-Y H:i:s', $fromDate);
        $id = Yii::$app->request->get('id');
        $id = intval($id);
        $amo = new Amo(\Yii::$app->params);
        if ($amo->getErrorCode() == 0) {
            if ($id > 0) {
                $link1 = 'http://erp.sergeysudakov.ru/payment/create?ext_id=' . $id . '&num=1';
                $link2 = 'http://erp.sergeysudakov.ru/payment/create?ext_id=' . $id . '&num=2';
                $amo->addLeadComment($id, "Ссылки на создание оплаты:\nна первую оплату {$link1} \nна вторую оплату {$link2}");
                echo 'Добавлено в <a href="https://jbyss.amocrm.ru/leads/detail/' . $id . '">' . $id . '</a>';
            } else {
                if ($fromDate === false) {
                    exit("Использовать: ?from=dd-mm-YYYY или ?id=1234");
                }
                echo 'Начиная с даты ' . $fromDate->format('d.m.Y') . '<br>';
                $fromDate = $fromDate->getTimestamp();
                $leads = Lead::find()->where("created_at > {$fromDate}")->all();
                if (!empty($leads)) {
                    foreach ($leads as $lead) { /* @var $lead Lead */
                        // нужно сгенерировать две ссылки на оплату и сохранить в поля сделки
                        $link1 = 'http://erp.sergeysudakov.ru/payment/create?ext_id=' . $lead->ext_id . '&num=1';
                        $link2 = 'http://erp.sergeysudakov.ru/payment/create?ext_id=' . $lead->ext_id . '&num=2';
                        $amo->addLeadComment($lead->ext_id, "Ссылки на создание оплаты:\nна первую оплату {$link1} \nна вторую оплату {$link2}");
                        echo 'Добавлено в <a href="https://jbyss.amocrm.ru/leads/detail/' . $lead->ext_id . '">' . $lead->ext_id . '</a> от ' . date('d.m.Y', $lead->created_at) . ' числа <br>';
                    }
                }
            }
        } else {
            exit("FAIL");
        }
    }


    /**
     * Запрос с виджета на то есть ли новые заявки или нет чтобы оповестить менеджера идёт сюда
     * $mid
     */
    public function actionAllocationRequest()
    {
        // запускаем скрипт распределения заявок
        exec('php /var/www/crm-erp/yii assignment/lead-assignment', $output, $res);
        // и только потом проверяем заявки для текущего менеджера
        if (\Yii::$app->request->getMethod() == 'GET') {
            $managerId = intval(\Yii::$app->request->get('manager_id', 0));
        } else {
            $managerId = intval(\Yii::$app->request->post('manager_id', 0));
        }
        // проверяем существование менеджера
        $manager = ManagerOption::find()->where(['user_ext_id' => $managerId])->one();
        if (empty($manager)) {
            return Json::encode(['status' => '400']);
        }
        $managerId = $manager->user_ext_id;
        // Есть ли вообще заявки для этого менеджера?
        $assignmentLead = AssigmentLeads::find() /* @var $assignmentLead AssigmentLeads */
            ->where(['manager_id' => $managerId, 'log' => 0, 'status' => 0])
            ->orderBy(['created_at' => SORT_DESC])->one();
        if (empty($assignmentLead)) {
            return Json::encode(['status' => '202', 'message' => 'Нет заявок', 'shell' => $output, 'shellr' => $res]);
        }
        $lead = Lead::findOne(['ext_id' => $assignmentLead->lead_id]);
        if (empty($lead)) {
            // заявка не найдена, значит нужно удалить эту запись
            $assignmentLead->delete();
            return Json::encode(['status' => '203', 'message' => 'Заявка не найдена', 'shell' => $output, 'shellr' => $res]);
        }
        // Если пришёл именно тот менеджер и заявка корректная
        if($lead->ext_id == $assignmentLead->lead_id) {
            return Json::encode([
                'status' => '200',
                'lead' => [
                    'id' => $lead->ext_id,
                    'name' => $lead->name,
                    'for_manager' => $assignmentLead->manager_id,
                    'status' => $assignmentLead->status,
                    'log' => $assignmentLead->log,
                ],
                'shell' => $output,
                'shellr' => $res
            ]);
        }
        return Json::encode(['status' => '500', 'message' => 'Параметры не совпадают',
            'debug' => ['id' => $lead->ext_id, 'name' => $lead->name],
            'shell' => $output, 'shellr' => $res
        ]);
    }


    /**
     * Для запроса на изменение статуса заявки виджетом распределения
     */
    public function actionSetAllocation()
    {
        $amo = new Amo(\Yii::$app->params);
        if (\Yii::$app->request->getMethod() == 'GET') {
            $managerId = intval(\Yii::$app->request->get('manager_id'));
            $leadId = intval(\Yii::$app->request->get('lead_id'));
            $status = intval(\Yii::$app->request->get('status', AssigmentLeads::STATUS_MISSED));
        } else {
            $managerId = intval(\Yii::$app->request->post('manager_id'));
            $leadId = intval(\Yii::$app->request->post('lead_id'));
            $status = intval(\Yii::$app->request->post('status', AssigmentLeads::STATUS_MISSED));
        }
        if (!in_array($status, [AssigmentLeads::STATUS_MISSED, AssigmentLeads::STATUS_REFUSED, AssigmentLeads::STATUS_ACCEPTED])) {
            return Json::encode(['status' => '500', 'message' => 'Неверный статус', 'debug_status' => $status]);
        }
        // проверяем существование менеджера
        $manager = ManagerOption::find()->where(['user_ext_id' => $managerId])->one();
        if (empty($manager)) {
            return Json::encode(['status' => '400', 'message' => 'Менеджер не найден']);
        }
        $managerId = $manager->user_ext_id;
        if (!$managerId || !$leadId || !$status) {
            return Json::encode(['status' => '500', 'message' => 'Один или несколько параметров некорректны', 'debug' => [$managerId, $leadId, $status]]);
        }
        $lead = AssigmentLeads::findOne(['lead_id' => $leadId, 'status' => 0]);
        if (!empty($lead)) {
            $lead->setAttribute('status', $status);
            if ($lead->save()) {
                // Назначаем менеджера на принятую сделку
                if ($status == AssigmentLeads::STATUS_ACCEPTED) {
                    $amo->setLeadField($leadId, ['responsible_user_id' => $managerId]);
                }
                // вне зависимости от ответа менеджера, мы считаем, что распределили ему сделку
                return Json::encode(['status' => '200', 'lead' => $lead->getAttributes()]);
            } else {
                return Json::encode(['status' => '500', 'message' => $lead->getErrors()]);
            }
        }
        return Json::encode(['status' => '500', 'message' => 'Сделка не найдена']);
    }
}
