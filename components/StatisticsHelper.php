<?php

namespace app\components;

use app\models\LeadLog;
use app\models\Manager;
use Yii;
use app\models\Lead;
use app\models\Money;
use app\models\Job;

class StatisticsHelper
{

    /**
     * @return array
     */
    public static function highlightColors()
    {
        return [
            'metriks_lead' => '#372a79',
            'metriks_CV' => '#ba56d4',
            'metriks_trade' => '#3367cd',
            'metriks_suspended' => '#dc3812',
            'metriks_lost' => '#fe9900',
            'metriks_summary' => '#dc3812',
            'metriks_firstpayment' => '#fe9900',
            'metriks_secondpayment' => '#109518',
            'metriks_potencialsummary' => '#019ac6',
            'trade_leads' => '#dd4578',
            'trade_CV' => '#ba56d4',
            'trade_trade' => '#65dd01',
            'trade_suspended' => '#00d690',
            'trade_lost' => '#66a901',
            'trade_closed' => '#9371ea',
            'trade_disagree' => '#b92f2f',
            'money_summary' => '#bd782d',
            'money_firstpayment' => '#316394',
            'money_secondpayment' => '#4682b4',
            'money_ya-money' => '#ee538d',
            'money_card' => '#02b5af',
            'money_bso' => '#418e86',
            'money_cash' => '#372a79',
            'money_account'=> '#ba56d4',
            'production_done' => '#3367cd',
            'production_received' => '#dc3812',
            'load-department_sales' => '#0fbca6',
            'load-department_design' => '#15fa3a',
            'load-department_production' => '#c26cf8',
            'cities_undefined' => '#f991c5',
            'cities_moscow' => '#fcdb40',
            'cities_piter' => '#ff4b04',
            'cities_n-novgorod' => '#7304a6',
            'cities_rostov' => '#047901',
            'cities_krasnodar' => '#a2c5a1',
        ];
    }



    public static function highlightColorsManager()
    {
        return [
            '220674_summarymanager' => '#372a79',
            '220674_firstpaymentmanager' => '#ba56d4',
            '220674_secondpaymentmanager' => '#3367cd',
            '220674_potencialsummarymanager' => '#dc3812',
            '220674_leadmanager' => '#fe9900',
            '220674_CVmanager' => '#109518',
            '220674_trademanager' => '#019ac6',
            '1122684_summarymanager' => '#dd4578',
            '1122684_firstpaymentmanager' => '#a82bab',
            '1122684_secondpaymentmanager' => '#65dd01',
            '1122684_potencialsummarymanager' => '#00d690',
            '1122684_leadmanager' => '#66a901',
            '1122684_CVmanager' => '#9371ea',
            '1122684_trademanager' => '#b92f2f',
            '1122690_summarymanager' => '#bd782d',
            '1122690_firstpaymentmanager' => '#316394',
            '1122690_secondpaymentmanager' => '#4682b4',
            '1122690_potencialsummarymanager' => '#ee538d',
            '1122690_leadmanager' => '#02b5af',
            '1122690_CVmanager' => '#418e86',
            '1122690_trademanager' => '#372a79',
            '220428_summarymanager' => '#ba56d4',
            '220428_firstpaymentmanager' => '#3367cd',
            '220428_secondpaymentmanager' => '#dc3812',
            '220428_potencialsummarymanager' => '#0fbca6',
            '220428_leadmanager' => '#15fa3a',
            '220428_CVmanager' => '#c26cf8',
            '220428_trademanager' => '#f991c5',
        ];
    }

    /**
     * @return array
     */
    public static function cities()
    {
        return [
            'cities_undefined' => 'Не опредлен',
            'cities_moscow' => 'Москва',
            'cities_piter' => 'Санкт-Петербург',
            'cities_n-novgorod' => 'Нижний Новгород',
            'cities_rostov' => 'Ростов на Дону',
            'cities_krasnodar' => 'Краснодар',
        ];
    }

    /**
     * @return array
     */
    public static function parametersNames()
    {
        return [
            'metriks' => [
                'lead' => 'Лиды',
                'CV' => 'Конверсия',
                'trade' => 'Продажи',
                'summary' => 'Выручка общая',
                'potencialsummary' => 'Потенциальная выручка',
                'firstpayment' => '1я оплата',
                'secondpayment' => '2я оплата',
            ],
            'trade' => [
                'leads' => 'Лиды',
                'CV' => 'CV в продажи',
                'trade' => 'Продажи',
                'suspended' => 'Отложенные',
                'lost' => 'Проигранные',
                'disagree' => 'Отказ, выяснить',
                'closed' => 'Закрыто',
            ],
            'money' => [
                'summary' => 'Выручка общая',
                'firstpayment' => '1я оплата',
                'secondpayment' => '2я оплата',
                'ya-money' => 'Эквайринг',
                'card' => 'Карта (НПК)',
                'bso' => 'БСО',
                'cash' => 'Нал',
                'account' => 'Р/С',
            ],
            'production' => [
                'done' => 'Сделано',
                'received' => 'Поступило',
                '' => '',
            ],
            'load-department' => [
                'sales' => 'Продажи',
                'design' => 'Дизайн',
                'production' => 'Производство',
            ],
            'cities' => [
                'undefined' => 'Не определен',
                'moscow' => 'Москва',
                'piter' => 'Санкт-Петербург',
                'n-novgorod' => 'Нижний Новгород',
                'rostov' => 'Ростов на Дону',
                'krasnodar' => 'Краснодар'
            ],
        ];
    }


    public static function typeGroups()
    {
        return [
            'day' => '%Y%m%d',
            '3days' => '%Y%m%d',
            'week' => '%Y%m%d',
            'month' => '%Y%c',
        ];
    }


    public static function getStatictics($fromDate = 0, $toDate = 0)
    {
        $typeGroups = self::typeGroups();
        $fromDate = !$fromDate ? strtotime(" -30 days") : $fromDate;
        $toDate = !$toDate ? time() : $toDate;
        $cities = self::cities();
        $data = [];
        $lead_status = [];$lead_status[] = 2;$lead_status[] = 3;$lead_status[] = 4;$lead_status[] = 24;$lead_status[] = 25;
        // Продажи
        $leadsCount = Lead::find()->where("`created_at` >= {$fromDate} AND `created_at` <= {$toDate}")
            ->andWhere(['not in', 'status_id', array(22,23,24,25)])->count();
        $salesCount = Money::find()
            ->where("(`first_payment_date` >= {$fromDate} AND `first_payment_date` <= {$toDate} AND `first_payment_amount` > 0)")->count();
        $data['trade']['rows']['leads'] = $leadsCount;
        $data['trade']['rows']['CV'] = ($leadsCount > 0) ? number_format($salesCount / $leadsCount * 100, 0) . '%' : '0';
        $data['trade']['rows']['trade'] = $salesCount;
        $data['trade']['rows']['suspended'] = Money::find()
            ->where("`created_at` >= {$fromDate} AND `created_at` <= {$toDate} AND `lead_status` = 11621095")->count(); // @see lead_status table for status ID
        $data['trade']['rows']['lost'] = Money::find()
            ->where("`created_at` >= {$fromDate} AND `created_at` <= {$toDate} AND `lead_status` IN (143, 10942479)")->count();
        $data['trade']['rows']['closed'] = Money::find()
            ->where("`created_at` >= {$fromDate} AND `created_at` <= {$toDate} AND `lead_status` = 143")->count();
        $data['trade']['rows']['disagree'] = Money::find()
            ->where("`created_at` >= {$fromDate} AND `created_at` <= {$toDate} AND `lead_status` = 10942479")->count();

        // Деньги
        // итоговый
        $data['money']['rows']['summary'] = Yii::$app->getDb()
            ->createCommand("SELECT SUM(`first_payment_amount`) AS `amount`"
                . " FROM `money` WHERE (`first_payment_date` >= {$fromDate} AND `first_payment_date` <= {$toDate})")->queryOne()['amount'];
        $data['money']['rows']['firstpayment'] = 0;
        $data['money']['rows']['firstpayment'] += Yii::$app->getDb()
            ->createCommand("SELECT SUM(`first_payment_amount`) AS `amount`"
                . " FROM `money` WHERE (`first_payment_date` >= {$fromDate} AND `first_payment_date` <= {$toDate})")->queryOne()['amount'];
        $data['money']['rows']['summary'] += Yii::$app->getDb()
            ->createCommand("SELECT SUM(`second_payment_amount`) AS `amount`"
                . " FROM `money` WHERE (`second_payment_date` >= {$fromDate} AND `second_payment_date` <= {$toDate})")->queryOne()['amount'];
        $data['money']['rows']['secondpayment'] = 0;
        $data['money']['rows']['secondpayment'] += Yii::$app->getDb()
            ->createCommand("SELECT SUM(`second_payment_amount`) AS `amount`"
                . " FROM `money` WHERE (`second_payment_date` >= {$fromDate} AND `second_payment_date` <= {$toDate})")->queryOne()['amount'];
        // яндекс
        $data['money']['rows']['ya-money'] = Yii::$app->getDb()
            ->createCommand("SELECT SUM(`first_payment_amount`) AS `amount`"
                . " FROM `money` WHERE (`first_payment_date` >= {$fromDate} AND `first_payment_date` <= {$toDate}) AND `first_payment_method` = " . Money::METHOD_YANDEX)
            ->queryOne()['amount'];
        $data['money']['rows']['ya-money'] += Yii::$app->getDb()
            ->createCommand("SELECT SUM(`second_payment_amount`) AS `amount`"
                . " FROM `money` WHERE (`second_payment_date` >= {$fromDate} AND `second_payment_date` <= {$toDate}) AND `second_payment_method` = " . Money::METHOD_YANDEX)
            ->queryOne()['amount'];
        // карта
        $data['money']['rows']['card'] = Yii::$app->getDb()
            ->createCommand("SELECT SUM(`first_payment_amount`) AS `amount`"
                . " FROM `money` WHERE (`first_payment_date` >= {$fromDate} AND `first_payment_date` <= {$toDate}) AND `first_payment_method` = " . Money::METHOD_CARD)
            ->queryOne()['amount'];
        $data['money']['rows']['card'] += Yii::$app->getDb()
            ->createCommand("SELECT SUM(`second_payment_amount`) AS `amount`"
                . " FROM `money` WHERE (`second_payment_date` >= {$fromDate} AND `second_payment_date` <= {$toDate}) AND `second_payment_method` = " . Money::METHOD_CARD)
            ->queryOne()['amount'];
        // БСО
        $data['money']['rows']['bso'] = Yii::$app->getDb()
            ->createCommand("SELECT SUM(`first_payment_amount`) AS `amount`"
                . " FROM `money` WHERE (`first_payment_date` >= {$fromDate} AND `first_payment_date` <= {$toDate}) AND `first_payment_method` = " . Money::METHOD_BSO)
            ->queryOne()['amount'];
        $data['money']['rows']['bso'] += Yii::$app->getDb()
            ->createCommand("SELECT SUM(`second_payment_amount`) AS `amount`"
                . " FROM `money` WHERE (`second_payment_date` >= {$fromDate} AND `second_payment_date` <= {$toDate}) AND `second_payment_method` = " . Money::METHOD_BSO)
            ->queryOne()['amount'];
        // наличка
        $data['money']['rows']['cash'] = Yii::$app->getDb()
            ->createCommand("SELECT SUM(`first_payment_amount`) AS `amount`"
                . " FROM `money` WHERE (`first_payment_date` >= {$fromDate} AND `first_payment_date` <= {$toDate}) AND `first_payment_method` = " . Money::METHOD_CASH)
            ->queryOne()['amount'];
        $data['money']['rows']['cash'] += Yii::$app->getDb()
            ->createCommand("SELECT SUM(`second_payment_amount`) AS `amount`"
                . " FROM `money` WHERE (`second_payment_date` >= {$fromDate} AND `second_payment_date` <= {$toDate}) AND `second_payment_method` = " . Money::METHOD_CASH)
            ->queryOne()['amount'];
        // счет
        $data['money']['rows']['account'] = Yii::$app->getDb()
            ->createCommand("SELECT SUM(`first_payment_amount`) AS `amount`"
                . " FROM `money` WHERE (`first_payment_date` >= {$fromDate} AND `first_payment_date` <= {$toDate}) AND `first_payment_method` = " . Money::METHOD_BANK_RS)
            ->queryOne()['amount'];
        $data['money']['rows']['account'] += Yii::$app->getDb()
            ->createCommand("SELECT SUM(`second_payment_amount`) AS `amount`"
                . " FROM `money` WHERE (`second_payment_date` >= {$fromDate} AND `second_payment_date` <= {$toDate}) AND `second_payment_method` = " . Money::METHOD_BANK_RS)
            ->queryOne()['amount'];

        // Производство
        $data['production']['rows']['done'] = Job::find()
            ->where("`finished_at` >= {$fromDate} AND `finished_at` <= {$toDate} AND `status` = " . Job::STATUS_DONE)->count();
        $data['production']['rows']['received'] = Job::find()
            ->where("`created_at` >= {$fromDate} AND `created_at` <= {$toDate}")->count();

        // Загрузка отделов
        // - продажи: все сделки за выбранный период, которые находились в статусах "не обработан, думает, ждет кп, недозвон, хочет подъехать, кп, ссылка на оплату, нужно позже"
        $data['load-department']['rows']['sales'] = LeadLog::find()
            ->where("`updated_at` >= {$fromDate} AND `updated_at` <= {$toDate} AND `lead_ext_status_id` IN (7633870, 11681824, 11142822, 9926985, 11670964, 11622466, 8607589, 11621095)") // todo заменить потом ext_id на внутренний ID
            ->count();
        // - дизайн: все сделки за выбранный период, которые находились в статусах "разработка эскиза, эскиз готов, согласование эскиза, нужен план"
        $data['load-department']['rows']['design'] = LeadLog::find()
            ->where("`updated_at` >= {$fromDate} AND `updated_at` <= {$toDate} AND `lead_ext_status_id` IN (7634134, 10409208, 7634328, 10310346)")
            ->count();
        // - производство: все сделки за выбранный период, которые находились в статусах "на производстве"
        $data['load-department']['rows']['production'] = LeadLog::find()
            ->where("`updated_at` >= {$fromDate} AND `updated_at` <= {$toDate} AND `lead_ext_status_id` = 10308990")
            ->count();

        // Города
        $data['cities']['rows']['undefined'] = Yii::$app->getDb()
            ->createCommand("SELECT COUNT(`first_payment_amount`) AS `cnt`"
                . " FROM `money` WHERE (`first_payment_date` >= {$fromDate} AND `first_payment_date` <= {$toDate}) AND `city` = '' ")
            ->queryOne()['cnt'];
        $data['cities']['rows']['moscow'] = Yii::$app->getDb()
            ->createCommand("SELECT COUNT(`first_payment_amount`) AS `cnt`"
                . " FROM `money` WHERE (`first_payment_date` >= {$fromDate} AND `first_payment_date` <= {$toDate}) AND `city` LIKE :city")
            ->bindParam(':city', $cities['cities_moscow'])->queryOne()['cnt'];
        $data['cities']['rows']['piter'] = Yii::$app->getDb()
            ->createCommand("SELECT COUNT(`first_payment_amount`) AS `cnt`"
                . " FROM `money` WHERE (`first_payment_date` >= {$fromDate} AND `first_payment_date` <= {$toDate}) AND `city` LIKE :city")
            ->bindParam(':city', $cities['cities_piter'])->queryOne()['cnt'];
        $data['cities']['rows']['n-novgorod'] = Yii::$app->getDb()
            ->createCommand("SELECT COUNT(`first_payment_amount`) AS `cnt`"
                . " FROM `money` WHERE (`first_payment_date` >= {$fromDate} AND `first_payment_date` <= {$toDate}) AND `city` LIKE :city")
            ->bindParam(':city', $cities['cities_n-novgorod'])->queryOne()['cnt'];
        $data['cities']['rows']['rostov'] = Yii::$app->getDb()
            ->createCommand("SELECT COUNT(`first_payment_amount`) AS `cnt`"
                . " FROM `money` WHERE (`first_payment_date` >= {$fromDate} AND `first_payment_date` <= {$toDate}) AND `city` LIKE :city")
            ->bindParam(':city', $cities['cities_rostov'])->queryOne()['cnt'];
        $data['cities']['rows']['krasnodar'] = Yii::$app->getDb()
            ->createCommand("SELECT COUNT(`first_payment_amount`) AS `cnt`"
                . " FROM `money` WHERE (`first_payment_date` >= {$fromDate} AND `first_payment_date` <= {$toDate}) AND `city` LIKE :city")
            ->bindParam(':city', $cities['cities_krasnodar'])->queryOne()['cnt'];


        //Основные метрики
        $data['metriks']['rows']['lead'] = $leadsCount;
        $data['metriks']['rows']['CV'] = ($leadsCount > 0) ? number_format($salesCount / $leadsCount * 100, 0) . '%' : '0';
        $data['metriks']['rows']['trade'] = $salesCount;
        $data['metriks']['rows']['summary'] = $data['money']['rows']['summary'];
        $data['metriks']['rows']['firstpayment'] = $data['money']['rows']['firstpayment'];
        $data['metriks']['rows']['secondpayment'] = $data['money']['rows']['secondpayment'];
        $data['metriks']['rows']['potencialsummary'] = Yii::$app->getDb()
            ->createCommand("SELECT SUM(`total_amount`) AS `amount`"
                . " FROM `money` WHERE (`first_payment_date` >= {$fromDate} AND `first_payment_date` <= {$toDate})")
            ->queryOne()['amount'];
        $manager = Manager::find()
            ->asArray()
            ->all();
        foreach ($manager as $value){
            $data[$value['responsible_user_id']]['rows']['summarymanager'] = Yii::$app->getDb()
                ->createCommand("SELECT SUM(`first_payment_amount`) AS `amount`"
                    . " FROM `money` WHERE (`first_payment_date` >= {$fromDate} AND `first_payment_date` <= {$toDate} AND `responsible_user_id` = {$value['responsible_user_id']})")->queryOne()['amount'];
            $data[$value['responsible_user_id']]['rows']['summarymanager'] += Yii::$app->getDb()
                ->createCommand("SELECT SUM(`second_payment_amount`) AS `amount`"
                    . " FROM `money` WHERE (`second_payment_date` >= {$fromDate} AND `second_payment_date` <= {$toDate} AND `responsible_user_id` = {$value['responsible_user_id']})")->queryOne()['amount'];
            $data[$value['responsible_user_id']]['rows']['firstpaymentmanager'] = 0;
            $data[$value['responsible_user_id']]['rows']['firstpaymentmanager'] += Yii::$app->getDb()
                ->createCommand("SELECT SUM(`first_payment_amount`) AS `amount`"
                    . " FROM `money` WHERE (`first_payment_date` >= {$fromDate} AND `first_payment_date` <= {$toDate} AND `responsible_user_id` = {$value['responsible_user_id']})")->queryOne()['amount'];
            $data[$value['responsible_user_id']]['rows']['secondpaymentmanager'] = 0;
            $data[$value['responsible_user_id']]['rows']['secondpaymentmanager'] += Yii::$app->getDb()
                ->createCommand("SELECT SUM(`second_payment_amount`) AS `amount`"
                    . " FROM `money` WHERE (`second_payment_date` >= {$fromDate} AND `second_payment_date` <= {$toDate} AND `responsible_user_id` = {$value['responsible_user_id']})")->queryOne()['amount'];
            $data[$value['responsible_user_id']]['rows']['potencialsummarymanager'] = 0;
            $data[$value['responsible_user_id']]['rows']['potencialsummarymanager'] += Yii::$app->getDb()
                ->createCommand("SELECT SUM(`total_amount`) AS `amount`"
                    . " FROM `money` WHERE (`first_payment_date` >= {$fromDate} AND `first_payment_date` <= {$toDate} AND `responsible_user_id` = {$value['responsible_user_id']})")->queryOne()['amount'];

            $data[$value['responsible_user_id']]['rows']['leadmanager'] = Lead::find()->where("`created_at` >= {$fromDate} AND `created_at` <= {$toDate} AND `responsible_user_id` = {$value['responsible_user_id']}")
                ->andWhere(['not in', 'status_id', array(22,23,24,25)])->count();
            $salesCount = Money::find()
                ->where("(`first_payment_date` >= {$fromDate} AND `first_payment_date` <= {$toDate} AND `first_payment_amount` > 0 AND `responsible_user_id` = {$value['responsible_user_id']})")->count();
            $data[$value['responsible_user_id']]['rows']['CVmanager'] = ($data[$value['responsible_user_id']]['rows']['leadmanager'] > 0) ? number_format($salesCount / $data[$value['responsible_user_id']]['rows']['leadmanager'] * 100, 0) . '%' : '0';
            $data[$value['responsible_user_id']]['rows']['trademanager'] = $salesCount;

        }
        //var_dump($data); exit;
        return $data;
    }

    public static function getStatisticsMoney($fromDate = 0, $toDate = 0)
    {
        $fromDate = !$fromDate ? strtotime(" -30 days") : $fromDate;
        $toDate = !$toDate ? time() : $toDate;
        $data = [];
        $collection = Yii::$app->getDb()
            ->createCommand("SELECT label AS  collection"
                . " FROM `collections` WHERE `color` IS NOT NULL")->queryAll();

        foreach ($collection as $value){
            $data[$value['collection']]['rows']['count'] = 0;
            $data[$value['collection']]['rows']['count'] += Yii::$app->getDb()
                ->createCommand("SELECT SUM(`count`) AS `count`"
                    . " FROM `money` WHERE (`first_payment_date` >= {$fromDate} AND `first_payment_date` <= {$toDate} AND `collection` = '{$value['collection']}')")->queryOne()['count'];

            $data[$value['collection']]['rows']['summ'] = 0;
            $data[$value['collection']]['rows']['summ'] += Yii::$app->getDb()
                ->createCommand("SELECT SUM(`total_amount`) AS `amount`"
                    . " FROM `money` WHERE (`first_payment_date` >= {$fromDate} AND `first_payment_date` <= {$toDate} AND `collection` = '{$value['collection']}')")->queryOne()['amount'];

        }

        return $data;
    }

    public static function getPeriod($period, $iShift = 0)
    {
        switch ($period) {
            case 'week':
                $lastPeriod = strtotime(date('d-m-Y 23:59:59', time())) - $iShift;
                $lastWeek = strtotime('-1 week', time());
                $startPeriod = strtotime(date('d-m-Y 00:00:00', $lastWeek)) - $iShift;
                break;
            case 'month':
                $lastPeriod = strtotime(date('d-m-Y 23:59:59', time())) - $iShift;
                $lastMonth = strtotime('-1 month', time());
                $startPeriod = strtotime(date('d-m-Y 00:00:00', $lastMonth)) - $iShift;
                break;
            case '3month':
                $lastPeriod = strtotime(date('d-m-Y 23:59:59', time())) - $iShift;
                $last3Month = strtotime('-3 month', time());
                $startPeriod = strtotime(date('d-m-Y 00:00:00', $last3Month)) - $iShift;
                break;
            case 'year':
                $lastPeriod = strtotime(date('d-m-Y 23:59:59', time())) - $iShift;
                $lastYear = strtotime('-1 year', time());
                $startPeriod = strtotime(date('d-m-Y 00:00:00', $lastYear)) - $iShift;
                break;
            case 'today':
                $startPeriod = strtotime(date('d-m-Y 00:00:00', time())) - $iShift;
                $lastPeriod = strtotime(date('d-m-Y 23:59:59', time())) - $iShift;
                break;
            case 'yesterday':
                $yesterday = strtotime('-1 day', time());
                $lastPeriod = strtotime(date('d-m-Y 23:59:59', $yesterday)) - $iShift;
                $startPeriod = strtotime(date('d-m-Y 00:00:00', $yesterday)) - $iShift;
                break;
            default:
                if (!empty($period) && isset(explode('-', $period)[1])) { // календарь
                    list($startPeriod, $lastPeriod) = explode('-', $period);
                    $startPeriod = date_create_from_format('d.m.Y', $startPeriod); // 01.09.2016
                    $startPeriod = strtotime(date('d-m-Y 00:00:00', $startPeriod->getTimestamp())) - $iShift;
                    $lastPeriod = date_create_from_format('d.m.Y', $lastPeriod); // 01.09.2016
                    $lastPeriod = strtotime(date('d-m-Y 23:59:59', $lastPeriod->getTimestamp())) - $iShift;
                } else {
                    if (empty($period)) {
                        $startPeriod = 0;
                        $lastPeriod = 0;
                    } else {
                        // TODO валидация времени!!
                        $startPeriod = strtotime(date('d-m-Y 00:00:00', strtotime($period))) - $iShift;
                        $lastPeriod = strtotime(date('d-m-Y 23:59:59', strtotime($period))) - $iShift;
                    }
                }
        }
        return [$startPeriod, $lastPeriod];
    }


    /**
     * Returns graph data by param and dates
     * @param string $paramName
     * @param int $fromDate
     * @param int $toDate
     * @return array
     */
    public static function getGraphDataByParam($paramName, $fromDate, $toDate)
    {
        $cities = self::cities();
        $data = [];
        switch ($paramName) {
            //Production
            case 'production_done':
                $data = StatisticsHelper::getAllDoneDiagramValues($fromDate, $toDate);
                break;
            case 'production_received':
                $data = StatisticsHelper::getReceivedDiagramValues($fromDate, $toDate);
                break;
            //Metriks
            case 'metriks_lead':
                $data = StatisticsHelper::getAllDiagramValues($fromDate, $toDate);
                break;
            case 'metriks_CV':
                $data = StatisticsHelper::getCVDiagramValues($fromDate, $toDate);
                break;
            case 'metriks_trade':
                $data = StatisticsHelper::getAllFirstPaymentDoneDiagramValues($fromDate, $toDate);
                break;
            case 'metriks_summary':
                $data = StatisticsHelper::getSummaryDiagramValues($fromDate, $toDate);
                break;
            case 'metriks_firstpayment':
                $data = StatisticsHelper::getSummaryFirstPaymentDiagramValues($fromDate, $toDate);
                break;
            case 'metriks_secondpayment':
                $data = StatisticsHelper::getSummarySecondPaymentDiagramValues($fromDate, $toDate);
                break;
            case 'metriks_potencialsummary':
                $data = StatisticsHelper::getSummaryPotencialDiagramValues($fromDate, $toDate);
                break;
            //Leads
            case 'trade_leads':
                $data = StatisticsHelper::getAllDiagramValues($fromDate, $toDate);
                break;
            case 'trade_CV':
                $data = StatisticsHelper::getCVDiagramValues($fromDate, $toDate);
                break;
            case 'trade_trade':
                $data = StatisticsHelper::getAllFirstPaymentDoneDiagramValues($fromDate, $toDate);
                break;
            case 'trade_suspended':
                $data = StatisticsHelper::getAllSuspendedDiagramValues($fromDate, $toDate);
                break;
            case 'trade_lost':
                $data = StatisticsHelper::getAllLostDiagramValues($fromDate, $toDate);
                break;
            case 'trade_closed':
                $data = StatisticsHelper::getAllClosedDiagramValues($fromDate, $toDate);
                break;
            case 'trade_disagree':
                $data = StatisticsHelper::getAllDisagreeDiagramValues($fromDate, $toDate);
                break;
            //Money
            case 'money_summary':
                $data = StatisticsHelper::getSummaryDiagramValues($fromDate, $toDate);
                break;
            case 'money_firstpayment':
                $data = StatisticsHelper::getSummaryFirstPaymentDiagramValues($fromDate, $toDate);
                break;
            case 'money_secondpayment':
                $data = StatisticsHelper::getSummarySecondPaymentDiagramValues($fromDate, $toDate);
                break;
            case 'money_ya-money':
                $data = StatisticsHelper::getPaymentsDiagramValues(Money::METHOD_YANDEX, $fromDate, $toDate);
                break;
            case 'money_card':
                $data = StatisticsHelper::getPaymentsDiagramValues(Money::METHOD_CARD, $fromDate, $toDate);
                break;
            case 'money_bso':
                $data = StatisticsHelper::getPaymentsDiagramValues(Money::METHOD_BSO, $fromDate, $toDate);
                break;
            case 'money_cash':
                $data = StatisticsHelper::getPaymentsDiagramValues(Money::METHOD_CASH, $fromDate, $toDate);
                break;
            case 'money_account':
                $data = StatisticsHelper::getPaymentsDiagramValues(Money::METHOD_BANK_RS, $fromDate, $toDate);
                break;
            //loaded
            case 'load-department_sales':
                $data = StatisticsHelper::loadedSalesDepartmentDiagramValues($fromDate, $toDate);
                break;
            case 'load-department_design':
                $data = StatisticsHelper::loadedDesignDepartmentDiagramValues($fromDate, $toDate);
                break;
            case 'load-department_production':
                $data = StatisticsHelper::loadedProductionDepartmentDiagramValues($fromDate, $toDate);
                break;
            // by citiesget
            case 'cities_undefined':
                $data = StatisticsHelper::getByCityUndefinedDiagramValues($fromDate, $toDate);
                break;
            case 'cities_moscow':
            case 'cities_piter':
            case 'cities_n-novgorod':
            case 'cities_rostov':
            case 'cities_krasnodar':
                $data = StatisticsHelper::getByCityDiagramValues($cities[$paramName], $fromDate, $toDate);
                break;
        }
        return $data;
    }

    public static function getGraphDataByParamManager($paramName, $fromDate, $toDate)
    {
        $chunk = explode('_', $paramName);


        switch ($chunk[1]) {
            //Metriks
            case 'leadmanager':
                $data = StatisticsHelper::getAllDiagramValuesManager($fromDate, $toDate, $chunk[0] );
                break;
            case 'CVmanager':
                $data = StatisticsHelper::getCVDiagramValuesManager($fromDate, $toDate, $chunk[0]);
                break;
            case 'trademanager':
                $data = StatisticsHelper::getAllFirstPaymentDoneDiagramValuesManager($fromDate, $toDate, $chunk[0]);
                break;
            case 'summarymanager':
                $data = StatisticsHelper::getSummaryDiagramValuesManager($fromDate, $toDate, $chunk[0]);
                break;
            case 'potencialsummarymanager':
                $data = StatisticsHelper::getSummaryPotencialDiagramValuesManager($fromDate, $toDate, $chunk[0]);
                break;
            case 'firstpaymentmanager':
                $data = StatisticsHelper::getSummaryFirstPaymentDiagramValuesManager($fromDate, $toDate, $chunk[0]);
                break;
            case 'secondpaymentmanager':
                $data = StatisticsHelper::getSummarySecondPaymentDiagramValuesManager($fromDate, $toDate, $chunk[0]);
                break;

        }
        return $data;
    }

    public static function getGraphDataByParamMoney($paramName, $fromDate, $toDate)
    {
        $chunk = explode('_', $paramName);


        $periodTpl = self::isSameDay($fromDate, $toDate) ? '%m-%d-%Y %h:59:59' : '%m-%d-%Y 23:59:59';
        $datapara = Money::find()->select(["FROM_UNIXTIME(`created_at`, '{$periodTpl}') AS `period`", 'SUM(`count`) AS `count`'])
            ->where(['>=','first_payment_date', $fromDate])->andWhere(['<=', 'first_payment_date', $toDate])->andWhere(['=', 'collection', $chunk[1]])
            ->groupBy('period')->asArray()->all();
        $series = []; // $series = [0 => ['07-31-2016', 2], 1 => ['дата', значение], ... ]
        foreach ($datapara as $k => $item) {
            $series[] = [$item['period'], $item['count']];
        }

        return $series;
    }


    /**
     * Группирует, сортирует и добавляет отсутствующие даты в данных для графика
     * @param array $resultData
     * @param integer $fromDate
     * @param integer $toDate
     * @param integer $periodInterval
     * @return array
     */
    public static function fillEmptyDates($resultData, $fromDate, $toDate, $periodInterval = 1)
    {
        //var_dump($resultData); exit;
        $isSameDay = self::isSameDay($fromDate, $toDate);
        $sortedData = [];
        if (!$isSameDay) {
            $position = strtotime(date('Y-m-d 23:59:59', $fromDate)); // нам нужны данные на конец каждого дня
        } else {
            $position = $fromDate;
        }
        $isFinish = false;
        // в цикле формируем новый массив со строго сортированными датами и перемещаем все данные туда
        while (!$isFinish) {
            if ($position >= $toDate) {
                $isFinish = true;
            }
            $date = $isSameDay ? 'm-d-Y H:59:59' : 'm-d-Y 23:59:59';
            $date = date($date, $position);
            foreach ($resultData as $key => $series) {
                // $series = [0 => ['07-31-2016 22:33:44', 10, 2], 1 => ['дата', процент, значение], ... ]
                if (!isset($sortedData[$key][$date])) {
                    $sortedData[$key][$date] = [$date, 0, 0];
                }
                // search this date in series
                foreach ($series as $j => $point) {
                    $char = (substr($point[1], -1, 1) == '%') ? '%' : '';
                    $point[1] = str_replace('%', '', $point[1]);
                    if ($periodInterval > 1) {
                        // групировка по нескольким дням
                        $itemDate = date_create_from_format('m-d-Y', explode(' ', $point[0])[0]);
                        $itemDate = strtotime($itemDate->format('Y-m-d 23:59:59')); // timestamp текущей точки
                        if ($itemDate <= $position) { // если дата точки меньше или равна дате точки для графика, то суммируем ее значение
                            $sortedData[$key][$date][1] += $point[1]; // реальное значение
                            $sortedData[$key][$date][2] = number_format($sortedData[$key][$date][1], 0, ',', '') . $char; // значение для legend
                            unset($resultData[$key][$j]);
                        }
                    } else {
                        if ($point[0] == $date) {
                            $sortedData[$key][$date] = $point;
                            $sortedData[$key][$date][2] = number_format($point[1], 0, ',', '') . $char;
                            unset($resultData[$key][$j]);
                        }
                    }
                }
                $sortedData[$key] = array_values($sortedData[$key]); // очищаем ключи дат и делаем просто цифровые индексы
            }
            if ($isSameDay) {
                $position = strtotime('+1 hour', $position);
            } else {
                $position = strtotime('+' . $periodInterval . ' days', $position);
            }
        }
        // масштабирование и добавление одной точки (нужна для графика, иначе крайняя правая позиция не выделяется)
        foreach ($sortedData as $key => $series) {
            // ищем максимум для каждого графика
            $max = 0;
            foreach ($series as $j => $point) {
                $point[1] = floatval(str_replace('%', '', $point[1]));
                if ($max < $point[1]) {
                    $max = $point[1];
                }
                // обнуляем время для дат, если это не один день
                if (!$isSameDay) {
                    $newDate = date_create_from_format('m-d-Y H:i:s', $point[0]); // 09-12-2016 23:59:59
                    $newDate->setTime(12, 0, 0);
                    if ($periodInterval > 1) {

                        $sortedData[$key][$j][3] = 'с '.date('d-m-Y', $newDate->getTimestamp() - 60*60*24*$periodInterval).' по '.date('d-m-Y', $newDate->getTimestamp());
                    }
                    $sortedData[$key][$j][0] = date('m-d-Y 12:00:00', $newDate->getTimestamp());


                }
            }
            // масштабируем все значения от максимума
            if ($max > 0) {
                foreach ($series as $j => $point) {
                    $point[1] = floatval(str_replace('%', '', $point[1]));
                    $sortedData[$key][$j][1] = $point[1] / ($max / 100);
                }
            }
        }
        return $sortedData;
    }

    public static function fillEmptyDatesMoney($resultData, $fromDate, $toDate, $periodInterval = 1)
    {
        //var_dump($resultData); exit;
        $isSameDay = self::isSameDay($fromDate, $toDate);
        $sortedData = [];
        if (!$isSameDay) {
            $position = strtotime(date('Y-m-d 23:59:59', $fromDate)); // нам нужны данные на конец каждого дня
        } else {
            $position = $fromDate;
        }
        $isFinish = false;
        // в цикле формируем новый массив со строго сортированными датами и перемещаем все данные туда
        while (!$isFinish) {
            if ($position >= $toDate) {
                $isFinish = true;
            }
            $date = $isSameDay ? 'm-d-Y H:59:59' : 'm-d-Y 23:59:59';
            $date = date($date, $position);
            foreach ($resultData as $key => $series) {
                // $series = [0 => ['07-31-2016 22:33:44', 10, 2], 1 => ['дата', процент, значение], ... ]
                if (!isset($sortedData[$key][$date])) {
                    $sortedData[$key][$date] = [$date, 0, 0];
                }
                // search this date in series
                foreach ($series as $j => $point) {
                    $char = (substr($point[1], -1, 1) == '%') ? '%' : '';
                    $point[1] = str_replace('%', '', $point[1]);
                    if ($periodInterval > 1) {
                        // групировка по нескольким дням
                        $itemDate = date_create_from_format('m-d-Y', explode(' ', $point[0])[0]);
                        $itemDate = strtotime($itemDate->format('Y-m-d 23:59:59')); // timestamp текущей точки
                        if ($itemDate <= $position) { // если дата точки меньше или равна дате точки для графика, то суммируем ее значение
                            $sortedData[$key][$date][1] += $point[1]; // реальное значение
                            $sortedData[$key][$date][2] = number_format($sortedData[$key][$date][1], 0, ',', '') . $char; // значение для legend
                            unset($resultData[$key][$j]);
                        }
                    } else {
                        if ($point[0] == $date) {
                            $sortedData[$key][$date] = $point;
                            $sortedData[$key][$date][2] = number_format($point[1], 0, ',', '') . $char;
                            unset($resultData[$key][$j]);
                        }
                    }
                }
                $sortedData[$key] = array_values($sortedData[$key]); // очищаем ключи дат и делаем просто цифровые индексы
            }
            if ($isSameDay) {
                $position = strtotime('+1 hour', $position);
            } else {
                $position = strtotime('+' . $periodInterval . ' days', $position);
            }
        }
        // масштабирование и добавление одной точки (нужна для графика, иначе крайняя правая позиция не выделяется)
        foreach ($sortedData as $key => $series) {
            // ищем максимум для каждого графика
            $max = 0;
            foreach ($series as $j => $point) {
                $point[1] = floatval(str_replace('%', '', $point[1]));
                if ($max < $point[1]) {
                    $max = $point[1];
                }
                // обнуляем время для дат, если это не один день
                if (!$isSameDay) {
                    $newDate = date_create_from_format('m-d-Y H:i:s', $point[0]); // 09-12-2016 23:59:59
                    $newDate->setTime(12, 0, 0);
                    if ($periodInterval > 1) {

                        $sortedData[$key][$j][3] = 'с '.date('d-m-Y', $newDate->getTimestamp() - 60*60*24*$periodInterval).' по '.date('d-m-Y', $newDate->getTimestamp());
                    }
                    $sortedData[$key][$j][0] = date('m-d-Y 12:00:00', $newDate->getTimestamp());


                }
            }
            // масштабируем все значения от максимума
            if ($max > 0) {
                foreach ($series as $j => $point) {
                    $point[1] = floatval(str_replace('%', '', $point[1]));
                    $sortedData[$key][$j][1] = $point[1];
                }
            }
        }
        return $sortedData;
    }


    /**
     * Проверяет временные местки и возвращает TRUE если они относятся к одному дню
     * @param $fromDate
     * @param $toDate
     * @return bool
     */
    public static function isSameDay($fromDate, $toDate)
    {
        return (date('dmY', $fromDate) == date('dmY', $toDate)) ? true : false;
    }


    public static function getCVDiagramValues($fromDate, $toDate)
    {
        $periodTpl = self::isSameDay($fromDate, $toDate) ? '%m-%d-%Y %h:59:59' : '%m-%d-%Y 23:59:59';
        $payments  = Yii::$app->getDb()->createCommand("SELECT FROM_UNIXTIME(`created_at`, '{$periodTpl}') AS `period`, COUNT(`ext_id`) AS `cnt`, `ext_id` AS `id`
        FROM `money` WHERE (`created_at` >= '{$fromDate}') AND (`created_at` <= '{$toDate}') AND (`first_payment_method` > 0) GROUP BY `period`")
            ->queryAll();
        $leads = Yii::$app->getDb()->createCommand("SELECT FROM_UNIXTIME(lead.`created_at`, '{$periodTpl}') AS `period`, 
            count(`lead_id`)  AS `cnt`, `ext_id` AS `id` 
            FROM `lead` WHERE (`created_at` > '{$fromDate}') AND ( `created_at` < '{$toDate}') AND (`status_id` NOT IN (22,23,24,25)) GROUP BY `period`")
            ->queryAll();
        $series = []; // $series = [0 => ['07-31-2016', 2], 1 => ['дата', значение], ... ]
        foreach ($leads as $k => $lead) {
            foreach ($payments as $j => $payment) {
                if($lead['period'] == $payment['period']) {
                    $p = $payment['cnt'] / $lead['cnt']  * 100;
                    $series[] = [$payment['period'], $p . '%'];
                }
            }
        }
        return $series;
    }

    public static function getCVDiagramValuesManager($fromDate, $toDate, $manager_id_lead)
    {
        $periodTpl = self::isSameDay($fromDate, $toDate) ? '%m-%d-%Y %h:59:59' : '%m-%d-%Y 23:59:59';
        $payments  = Yii::$app->getDb()->createCommand("SELECT FROM_UNIXTIME(`created_at`, '{$periodTpl}') AS `period`, COUNT(`ext_id`) AS `cnt`, `ext_id` AS `id`
        FROM `money` WHERE (`created_at` >= '{$fromDate}') AND (`created_at` <= '{$toDate}') AND (`first_payment_method` > 0) AND (`responsible_user_id` = $manager_id_lead) GROUP BY `period`")
            ->queryAll();
        $leads = Yii::$app->getDb()->createCommand("SELECT FROM_UNIXTIME(lead.`created_at`, '{$periodTpl}') AS `period`, 
            count(`lead_id`)  AS `cnt`, `ext_id` AS `id` 
            FROM `lead` WHERE (`created_at` > '{$fromDate}') AND ( `created_at` < '{$toDate}') AND (`responsible_user_id` = $manager_id_lead) AND (`status_id` NOT IN (22,23,24,25)) GROUP BY `period`")
            ->queryAll();
        $series = []; // $series = [0 => ['07-31-2016', 2], 1 => ['дата', значение], ... ]
        foreach ($leads as $k => $lead) {
            foreach ($payments as $j => $payment) {
                if($lead['period'] == $payment['period']) {
                    $p = $payment['cnt'] / $lead['cnt']  * 100;
                    $series[] = [$payment['period'], $p . '%'];
                }
            }
        }
        return $series;
    }


    public static function getAllDiagramValues($fromDate, $toDate)
    {
        $periodTpl = self::isSameDay($fromDate, $toDate) ? '%m-%d-%Y %h:59:59' : '%m-%d-%Y 23:59:59';
        $leads = Lead::find()->select(["FROM_UNIXTIME(`created_at`, '{$periodTpl}') AS `period`",  'COUNT(`lead_id`) AS `cnt`'])
            ->where(['>=',' `created_at`', $fromDate])->andWhere(['<=',' `created_at`', $toDate])->andWhere(['not in', 'status_id', array(22,23,24,25)])
            ->groupBy('period')->asArray()->all();
        $series = []; // $series = [0 => ['07-31-2016', 2], 1 => ['дата', значение], ... ]
        foreach ($leads as $k => $lead) {
            $series[] = [$lead['period'], $lead['cnt']];
        }
        return $series;
    }

    public static function getAllDiagramValuesManager($fromDate, $toDate, $manager_id)
    {
        $periodTpl = self::isSameDay($fromDate, $toDate) ? '%m-%d-%Y %h:59:59' : '%m-%d-%Y 23:59:59';
        $leads = Lead::find()->select(["FROM_UNIXTIME(`created_at`, '{$periodTpl}') AS `period`",  'COUNT(`lead_id`) AS `cnt`'])
            ->where(['>=',' `created_at`', $fromDate])->andWhere(['<=',' `created_at`', $toDate])->andWhere(['=',' `responsible_user_id`', $manager_id])
            ->groupBy('period')->asArray()->all();
        $series = []; // $series = [0 => ['07-31-2016', 2], 1 => ['дата', значение], ... ]
        foreach ($leads as $k => $lead) {
            $series[] = [$lead['period'], $lead['cnt']];
        }
        return $series;
    }


    public static function getAllFirstPaymentDoneDiagramValues($fromDate, $toDate)
    {
        $periodTpl = self::isSameDay($fromDate, $toDate) ? '%m-%d-%Y %h:59:59' : '%m-%d-%Y 23:59:59';
        $data = Money::find()->select(["FROM_UNIXTIME(`created_at`, '{$periodTpl}') AS `period`", 'COUNT(`ext_id`) AS `cnt`'])
            ->where(['>=','first_payment_date', $fromDate])->andWhere(['<=', 'first_payment_date', $toDate])
            ->andWhere(['>', 'first_payment_amount', 0])->groupBy('period')->asArray()->all();
        $series = []; // $series = [0 => ['07-31-2016', 2], 1 => ['дата', значение], ... ]
        foreach ($data as $k => $item) {
            $series[] = [$item['period'], $item['cnt']];
        }
        return $series;
    }

    public static function getAllFirstPaymentDoneDiagramValuesManager($fromDate, $toDate, $manager_id)
    {
        $periodTpl = self::isSameDay($fromDate, $toDate) ? '%m-%d-%Y %h:59:59' : '%m-%d-%Y 23:59:59';
        $data = Money::find()->select(["FROM_UNIXTIME(`created_at`, '{$periodTpl}') AS `period`", 'COUNT(`ext_id`) AS `cnt`'])
            ->where(['>=','first_payment_date', $fromDate])->andWhere(['<=', 'first_payment_date', $toDate])->andWhere(['=', 'responsible_user_id', $manager_id])
            ->andWhere(['>', 'first_payment_amount', 0])->groupBy('period')->asArray()->all();
        $series = []; // $series = [0 => ['07-31-2016', 2], 1 => ['дата', значение], ... ]
        foreach ($data as $k => $item) {
            $series[] = [$item['period'], $item['cnt']];
        }
        return $series;
    }


    // Продажи - отложенные
    public static function getAllSuspendedDiagramValues($fromDate, $toDate)
    {
        $data = Yii::$app->getDb()->createCommand("SELECT FROM_UNIXTIME(`created_at`, '%m-%d-%Y') AS `period`, COUNT(`ext_id`) AS `cnt` FROM `money` 
          WHERE (((`created_at` >= '{$fromDate}') AND (`created_at` <= '{$toDate}'))) AND ((`lead_status` = 11621095)) 
          GROUP BY `period`")->queryAll();
        $series = []; // $series = [0 => ['07-31-2016', 2], 1 => ['дата', значение], ... ]
        foreach ($data as $k => $item) {
            $series[] = [$item['period'], $item['cnt']];
        }
        return $series;
    }


    public static function getAllDoneDiagramValues($fromDate, $toDate)
    {
        $periodTpl = self::isSameDay($fromDate, $toDate) ? '%m-%d-%Y %h:59:59' : '%m-%d-%Y 23:59:59';
        $jobs = Job::find()->select(["FROM_UNIXTIME(`finished_at`, '{$periodTpl}') AS period", 'COUNT(`id`) AS `cnt`'])
            ->where(['=','status', Job::STATUS_DONE ])->andWhere(['>=',' `finished_at`', $fromDate])
            ->andWhere(['<=',' `finished_at`', $toDate])
            ->groupBy('period')->asArray()->all();
        $series = []; // $series = [0 => ['07-31-2016', 2], 1 => ['дата', значение], ... ]
        foreach ($jobs as $k => $job) {
            $series[] = [$job['period'], $job['cnt']];
        }
        return $series;
    }


    public static function getReceivedDiagramValues($fromDate, $toDate)
    {
        $periodTpl = self::isSameDay($fromDate, $toDate) ? '%m-%d-%Y %h:59:59' : '%m-%d-%Y 23:59:59';
        $jobs = Job::find()->select(["FROM_UNIXTIME(`finished_at`, '{$periodTpl}') AS `period`", 'COUNT(`id`) AS `cnt`'])
            ->andWhere(['>', 'finished_at', $fromDate])->andWhere(['<', 'finished_at', $toDate])
            ->groupBy('period')->asArray()->all();
        $series = []; // $series = [0 => ['07-31-2016', 2], 1 => ['дата', значение], ... ]
        foreach ($jobs as $k => $job) {
            $series[] = [$job['period'], $job['cnt']];
        }
        return $series;
    }


    public static function getAllLostDiagramValues($fromDate, $toDate)
    {
        $periodTpl = self::isSameDay($fromDate, $toDate) ? '%m-%d-%Y %h:59:59' : '%m-%d-%Y 23:59:59';
        $data = Yii::$app->getDb()->createCommand("SELECT FROM_UNIXTIME(`created_at`, '{$periodTpl}') AS `period`, COUNT(`ext_id`) AS `cnt` FROM `money` 
          WHERE `created_at` >= '{$fromDate}' AND `created_at` <= '{$toDate}' AND `lead_status` IN (143, 10942479) GROUP BY `period`")->queryAll();
        $series = []; // $series = [0 => ['07-31-2016', 2], 1 => ['дата', значение], ... ]
        foreach ($data as $k => $item) {
            $series[] = [$item['period'], $item['cnt']];
        }
        return $series;
    }


    public static function getAllClosedDiagramValues($fromDate, $toDate)
    {
        $periodTpl = self::isSameDay($fromDate, $toDate) ? '%m-%d-%Y %h:59:59' : '%m-%d-%Y 23:59:59';
        $data = Money::find()->select(["FROM_UNIXTIME(`created_at`, '{$periodTpl}') AS `period`", 'COUNT(`ext_id`) AS `cnt`'])
            ->where(['>=', 'created_at', $fromDate])->andWhere(['<=', 'created_at', $toDate])
            ->andWhere(['=', 'lead_status', 143])
            ->groupBy('period')->asArray()->all();
        $series = []; // $series = [0 => ['07-31-2016', 2], 1 => ['дата', значение], ... ]
        foreach ($data as $k => $item) {
            $series[] = [$item['period'], $item['cnt']];
        }
        return $series;
    }


    public static function getAllDisagreeDiagramValues($fromDate, $toDate)
    {
        $periodTpl = self::isSameDay($fromDate, $toDate) ? '%m-%d-%Y %h:59:59' : '%m-%d-%Y 23:59:59';
        $data = Money::find()->select(["FROM_UNIXTIME(`created_at`, '{$periodTpl}') AS `period`", 'COUNT(`ext_id`) AS `cnt`'])
            ->where(['>', 'created_at', $fromDate])->andWhere(['<', 'created_at', $toDate])->andWhere(['=', 'lead_status', 10942479])
            ->groupBy('period')->asArray()->all();
        $series = []; // $series = [0 => ['07-31-2016', 2], 1 => ['дата', значение], ... ]
        foreach ($data as $k => $item) {
            $series[] = [$item['period'], $item['cnt']];
        }
        return $series;
    }


    public static function loadedSalesDepartmentDiagramValues($fromDate, $toDate)
    {
        $periodTpl = self::isSameDay($fromDate, $toDate) ? '%m-%d-%Y %h:59:59' : '%m-%d-%Y 23:59:59';
        $data = LeadLog::find()->select(["FROM_UNIXTIME(`updated_at`, '{$periodTpl}') AS `period`", 'COUNT(`lead_id`) AS `cnt`'])
            ->where(['>=',' `updated_at`', $fromDate])->andWhere(['<=',' `updated_at`', $toDate])
            ->andWhere(['IN',' `lead_ext_status_id`', [7633870,11681824,11142822,9926985,11670964,11622466,8607589,11621095]])
            ->groupBy('period')->asArray()->all();
        $series = []; // $series = [0 => ['07-31-2016', 2], 1 => ['дата', значение], ... ]
        foreach ($data as $k => $item) {
            $series[] = [$item['period'], $item['cnt']];
        }
        return $series;
    }


    public static function loadedDesignDepartmentDiagramValues($fromDate, $toDate)
    {
        $periodTpl = self::isSameDay($fromDate, $toDate) ? '%m-%d-%Y %h:59:59' : '%m-%d-%Y 23:59:59';
        $data = LeadLog::find()->select(["FROM_UNIXTIME(`updated_at`, '{$periodTpl}') AS `period`", 'COUNT(`lead_id`) AS `cnt`'])
            ->where(['>=', 'updated_at', $fromDate])->andWhere(['<=', 'updated_at', $toDate])
            ->andWhere(['IN', 'lead_ext_status_id', [7634134, 10409208, 7634328, 10310346]])->groupBy('period')
            ->asArray()->all();
        $series = []; // $series = [0 => ['07-31-2016', 2], 1 => ['дата', значение], ... ]
        foreach ($data as $k => $item) {
            $series[] = [$item['period'], $item['cnt']];
        }
        return $series;
    }


    public static function loadedProductionDepartmentDiagramValues($fromDate, $toDate)
    {
        $periodTpl = self::isSameDay($fromDate, $toDate) ? '%m-%d-%Y %h:59:59' : '%m-%d-%Y 23:59:59';
        $data = LeadLog::find()->select(["FROM_UNIXTIME(`updated_at`, '{$periodTpl}') AS period", 'COUNT(`lead_id`) AS `cnt`'])
            ->where(['>=', 'updated_at', $fromDate])->andWhere(['<=', 'updated_at', $toDate])
            ->andWhere(['=',' `lead_ext_status_id`', 10308990])->groupBy('period')->asArray()->all();
        $series = []; // $series = [0 => ['07-31-2016', 2], 1 => ['дата', значение], ... ]
        foreach ($data as $k => $item) {
            $series[] = [$item['period'], $item['cnt']];
        }
        return $series;
    }


    public static function getByCityDiagramValues($city = 'Москва', $fromDate, $toDate)
    {
        $periodTpl = self::isSameDay($fromDate, $toDate) ? '%m-%d-%Y %h:59:59' : '%m-%d-%Y 23:59:59';
        $data = Money::find()->select(["FROM_UNIXTIME(`created_at`, '{$periodTpl}') AS `period`", 'COUNT(`ext_id`) AS `cnt`'])
            ->where(['>=', 'created_at', $fromDate])->andWhere(['<=', 'created_at', $toDate])
            ->andWhere(['=', 'city', $city])->andWhere(['>', 'first_payment_amount', 0])
            ->groupBy('period')->asArray()->all();
        $series = []; // $series = [0 => ['07-31-2016', 2], 1 => ['дата', значение], ... ]
        foreach ($data as $k => $item) {
            $series[] = [$item['period'], $item['cnt']];
        }
        return $series;
    }

    public static function getByCityUndefinedDiagramValues($fromDate, $toDate)
    {
        $periodTpl = self::isSameDay($fromDate, $toDate) ? '%m-%d-%Y %h:59:59' : '%m-%d-%Y 23:59:59';
        $data = Money::find()->select(["FROM_UNIXTIME(`created_at`, '{$periodTpl}') AS `period`", 'COUNT(`ext_id`) AS `cnt`'])
            ->where(['>=', 'created_at', $fromDate])->andWhere(['<=', 'created_at', $toDate])
            ->andWhere(['=', 'city', ''])->andWhere(['>', 'first_payment_amount', 0])
            ->groupBy('period')->asArray()->all();
        $series = []; // $series = [0 => ['07-31-2016', 2], 1 => ['дата', значение], ... ]
        foreach ($data as $k => $item) {
            $series[] = [$item['period'], $item['cnt']];
        }
        return $series;
    }

    public static function getSummaryPotencialDiagramValues($fromDate, $toDate)
    {
        $periodTpl = self::isSameDay($fromDate, $toDate) ? '%m-%d-%Y %h:59:59' : '%m-%d-%Y 23:59:59';
        $data = Money::find()->select(["FROM_UNIXTIME(`first_payment_date`, '{$periodTpl}') AS `period`", 'SUM(total_amount)  AS `cnt`'])
            ->where(['>=', 'first_payment_date', $fromDate])->andWhere(['<=', 'first_payment_date', $toDate])->groupBy('period')->asArray()->all();
        $series = []; // $series = [0 => ['07-31-2016', 2], 1 => ['дата', значение], ... ]
        foreach ($data as $k => $item) {
            $series[] = [$item['period'], $item['cnt']];
        }
        return $series;

    }

    public static function getSummaryFirstPaymentDiagramValues($fromDate, $toDate)
    {
        $periodTpl = self::isSameDay($fromDate, $toDate) ? '%m-%d-%Y %h:59:59' : '%m-%d-%Y 23:59:59';
        $data = Money::find()->select(["FROM_UNIXTIME(`first_payment_date`, '{$periodTpl}') AS `period`", 'SUM(first_payment_amount)  AS `cnt`'])
            ->where(['>=', 'first_payment_date', $fromDate])->andWhere(['<=', 'first_payment_date', $toDate])->groupBy('period')->asArray()->all();
        $series = []; // $series = [0 => ['07-31-2016', 2], 1 => ['дата', значение], ... ]
        foreach ($data as $k => $item) {
            $series[] = [$item['period'], $item['cnt']];
        }
        return $series;

    }

    public static function getSummarySecondPaymentDiagramValues($fromDate, $toDate)
    {
        $periodTpl = self::isSameDay($fromDate, $toDate) ? '%m-%d-%Y %h:59:59' : '%m-%d-%Y 23:59:59';
        $data = Money::find()->select(["FROM_UNIXTIME(`second_payment_date`, '{$periodTpl}') AS `period`", 'SUM(second_payment_amount)  AS `cnt`'])
            ->where(['>=', 'second_payment_date', $fromDate])->andWhere(['<=', 'second_payment_date', $toDate])->groupBy('period')->asArray()->all();
        $series = []; // $series = [0 => ['07-31-2016', 2], 1 => ['дата', значение], ... ]
        foreach ($data as $k => $item) {
            $series[] = [$item['period'], $item['cnt']];
        }
        return $series;

    }


    public static function getSummaryPotencialDiagramValuesManager($fromDate, $toDate, $manager_id)
    {
        $periodTpl = self::isSameDay($fromDate, $toDate) ? '%m-%d-%Y %h:59:59' : '%m-%d-%Y 23:59:59';
        $data = Money::find()->select(["FROM_UNIXTIME(`first_payment_date`, '{$periodTpl}') AS `period`", 'SUM(total_amount)  AS `cnt`'])
            ->where(['>=', 'first_payment_date', $fromDate])->andWhere(['<=', 'first_payment_date', $toDate])->andWhere(['=', 'responsible_user_id', $manager_id])->groupBy('period')->asArray()->all();
        $series = []; // $series = [0 => ['07-31-2016', 2], 1 => ['дата', значение], ... ]
        foreach ($data as $k => $item) {
            $series[] = [$item['period'], $item['cnt']];
        }
        return $series;

    }
    public static function getSummaryFirstPaymentDiagramValuesManager($fromDate, $toDate, $manager_id)
    {
        $periodTpl = self::isSameDay($fromDate, $toDate) ? '%m-%d-%Y %h:59:59' : '%m-%d-%Y 23:59:59';
        $data = Money::find()->select(["FROM_UNIXTIME(`first_payment_date`, '{$periodTpl}') AS `period`", 'SUM(first_payment_amount)  AS `cnt`'])
            ->where(['>=', 'first_payment_date', $fromDate])->andWhere(['<=', 'first_payment_date', $toDate])->andWhere(['=', 'responsible_user_id', $manager_id])->groupBy('period')->asArray()->all();
        $series = []; // $series = [0 => ['07-31-2016', 2], 1 => ['дата', значение], ... ]
        foreach ($data as $k => $item) {
            $series[] = [$item['period'], $item['cnt']];
        }
        return $series;

    }

    public static function getSummarySecondPaymentDiagramValuesManager($fromDate, $toDate, $manager_id)
    {
        $periodTpl = self::isSameDay($fromDate, $toDate) ? '%m-%d-%Y %h:59:59' : '%m-%d-%Y 23:59:59';
        $data = Money::find()->select(["FROM_UNIXTIME(`second_payment_date`, '{$periodTpl}') AS `period`", 'SUM(second_payment_amount)  AS `cnt`'])
            ->where(['>=', 'second_payment_date', $fromDate])->andWhere(['<=', 'second_payment_date', $toDate])->andWhere(['=', 'responsible_user_id', $manager_id])->groupBy('period')->asArray()->all();
        $series = []; // $series = [0 => ['07-31-2016', 2], 1 => ['дата', значение], ... ]
        foreach ($data as $k => $item) {
            $series[] = [$item['period'], $item['cnt']];
        }
        return $series;

    }


    public static function getSummaryDiagramValues($fromDate, $toDate)
    {
        $periodTpl = self::isSameDay($fromDate, $toDate) ? '%m-%d-%Y %h:59:59' : '%m-%d-%Y 23:59:59';
        $firstSummary = Yii::$app->getDb()
            ->createCommand("SELECT SUM(`first_payment_amount`) AS `amount`, FROM_UNIXTIME(`first_payment_date`, '{$periodTpl}') AS `period`"
                . " FROM `money` WHERE (`first_payment_date` >= {$fromDate} AND `first_payment_date` <= {$toDate})"
                . " GROUP BY `period`")->queryAll();
        $secondSummary = Yii::$app->getDb()
            ->createCommand("SELECT SUM(`second_payment_amount`) AS amount, FROM_UNIXTIME(second_payment_date, '{$periodTpl}') AS `period`"
                . " FROM `money` WHERE (`second_payment_date` >= {$fromDate} AND `second_payment_date` <= {$toDate})"
                . " GROUP BY `period`")->queryAll();
        $series = []; // $series = [0 => ['07-31-2016', 2], 1 => ['дата', значение], ... ]
        foreach ([$firstSummary, $secondSummary] as $summary) {
            foreach ($summary as $k => $item) {
                $period = $item['period'];
                if (isset($series[$period])) {
                    $series[$period][1] += $item['amount'];
                } else {
                    $series[$period] = [$period, $item['amount']];
                }
            }
        }
        return $series;
    }

    public static function getSummaryDiagramValuesManager($fromDate, $toDate, $manager_id)
    {
        $periodTpl = self::isSameDay($fromDate, $toDate) ? '%m-%d-%Y %h:59:59' : '%m-%d-%Y 23:59:59';
        $firstSummary = Yii::$app->getDb()
            ->createCommand("SELECT SUM(`first_payment_amount`) AS `amount`, FROM_UNIXTIME(`first_payment_date`, '{$periodTpl}') AS `period`"
                . " FROM `money` WHERE (`first_payment_date` >= {$fromDate} AND `first_payment_date` <= {$toDate} AND `responsible_user_id` = {$manager_id})"
                . " GROUP BY `period`")->queryAll();
        $secondSummary = Yii::$app->getDb()
            ->createCommand("SELECT SUM(`second_payment_amount`) AS amount, FROM_UNIXTIME(second_payment_date, '{$periodTpl}') AS `period`"
                . " FROM `money` WHERE (`second_payment_date` >= {$fromDate} AND `second_payment_date` <= {$toDate} AND `responsible_user_id` = {$manager_id})"
                . " GROUP BY `period`")->queryAll();
        $series = []; // $series = [0 => ['07-31-2016', 2], 1 => ['дата', значение], ... ]
        foreach ([$firstSummary, $secondSummary] as $summary) {
            foreach ($summary as $k => $item) {
                $period = $item['period'];
                if (isset($series[$period])) {
                    $series[$period][1] += $item['amount'];
                } else {
                    $series[$period] = [$period, $item['amount']];
                }
            }
        }
        return $series;
    }


    public static function getPaymentsDiagramValues($type = Money::METHOD_BANK_RS, $fromDate, $toDate)
    {
        $periodTpl = self::isSameDay($fromDate, $toDate) ? '%m-%d-%Y %h:59:59' : '%m-%d-%Y 23:59:59';
        $first = Yii::$app->getDb()->createCommand("SELECT FROM_UNIXTIME(`first_payment_date`, '{$periodTpl}') AS period, SUM(`first_payment_amount`) AS amount 
        FROM `money` 
        WHERE ((( `first_payment_date` >= '{$fromDate}') AND ( `first_payment_date` <= '{$toDate}'))) AND (( `first_payment_method` = '{$type}') OR ( `first_payment_method` = '{$type}')) GROUP BY `period`")
            ->queryAll();
        $second = Yii::$app->getDb()->createCommand("SELECT FROM_UNIXTIME(`second_payment_date`, '{$periodTpl}') AS period, SUM(`second_payment_amount`) AS amount 
        FROM `money` 
        WHERE ((( `second_payment_date` >= '{$fromDate}') AND ( `second_payment_date` <= '{$toDate}'))) AND (( `second_payment_method` = '{$type}') OR ( `second_payment_method` = '{$type}')) GROUP BY `period`")
            ->queryAll();
        $series = []; // $series = [0 => ['07-31-2016', 2], 1 => ['дата', значение], ... ]
        foreach ([$first, $second] as $summary) {
            foreach ($summary as $k => $item) {
                $period = $item['period'];
                if (isset($series[$period])) {
                    $series[$period] += [$period, $item['amount']];
                } else {
                    $series[$period] = [$period, $item['amount']];
                }
            }
        }
        return $series;
    }

}