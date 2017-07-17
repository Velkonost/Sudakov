<?php
namespace app\commands;

use app\models\AssigmentLeads;
use app\models\ManagerOption;
use app\models\QueueLeads;
use yii\console\Controller;
use yii\helpers\Console;
use app\models\Amo;
use app\models\Option;


class AssignmentController extends Controller
{

    public function actionIndex()
    {
        $this->stdout("Use: php yii assignment/lead-assignment\n", Console::FG_GREEN);
    }

    /**
     * Основной метод перераспределения
     * @return null
     */
    public function actionLeadAssignment()
    {
        $this->stdout("Start LeadAssignment\n", Console::FG_GREEN);
        $amo = new Amo(\Yii::$app->params);
        $status = AssigmentLeads::STATUS_NONE;
        $currentManager = Option::getCurrentManagerForLead();

        if (empty($currentManager['manager_id'])) {
            $this->stdout("Not found any manager\n", Console::FG_RED);
            return;
        }

        // тип распределения
        $type = Option::getOption('typeOfAssignmentLeads');

        // проверяем сколько было распределено этому менеджеру заявок
        if ($type == 'co') {
            // с коэффициентом
            // запрашиваем, сколько ему должно быть распределено?
            $coef = ManagerOption::getCoefficient($currentManager['manager_id']);
            if ($currentManager['amount'] >= $coef) {
                // нужно переходить к следующему менеджеру
                $currentManager = ManagerOption::getNextActiveManager($currentManager['manager_id']);
                Option::setOption('amountOfLeadsForManager', 0);
                Option::setOption('managerForLead', $currentManager['manager_id']);
            }
        } else {
            // flow - поочередное
            if ($currentManager['amount'] >= 1) {
                // нужно переходить к следующему менеджеру
                $currentManager = ManagerOption::getNextActiveManager($currentManager['manager_id']);
                Option::setOption('amountOfLeadsForManager', 0);
                Option::setOption('managerForLead', $currentManager['manager_id']);
            }
        }

        // Берём заявку самой старой датой
        /* @var $queueLead QueueLeads */
        $queueLead = QueueLeads::find()->orderBy(['created_at' => SORT_DESC])->one();

        // Проверяем в таблице хоть что-то есть?
        if (!empty($queueLead)) {
            $log = 0;
            $managerId = 0;
            $this->stdout("New lead found {$queueLead->lead_id}\n", Console::FG_GREEN);
            $lead = $amo->getLead($queueLead->lead_id);
            if (!empty($lead)) {
                $managerId = $lead['responsible_user_id'];
            } else {
                // сделка не существует в AMOCRM, удаляем ее из очереди нафиг
                $this->stdout("Lead {$queueLead->lead_id} not exists in AMOCRM\n", Console::FG_RED);
                $queueLead->delete();
                return false;
            }
            // Если заявка уже привязана к менеджеру, то записываем в лог и не пускаем её дальше
            if ($managerId && $managerId != '220428' && $managerId != '7633866') { // не ID судакова или аккаунта
                $status = AssigmentLeads::STATUS_ACCEPTED;
                $log = 1;
            } else {
                $managerId = $currentManager['manager_id'];
            }
            if ($managerId) {
                $this->stdout("Assignmented lead {$queueLead->lead_id} for {$currentManager['manager_id']} manager' \n", Console::FG_GREEN);
                // Распределяем на менеджера
                $assignmentLeads = new AssigmentLeads();
                $assignmentLeads->lead_id = $queueLead->lead_id;
                $assignmentLeads->manager_id = $managerId;
                $assignmentLeads->status = $status;
                $assignmentLeads->log = $log;
                $assignmentLeads->created_at = time();
                $assignmentLeads->save();
                //Удаляем Входящую сделку
                $queueLead->delete();
                // обновляем счетчик
                $currentManager['amount']++;
                if (!Option::setOption('amountOfLeadsForManager', $currentManager['amount'])) {
                    $this->stdout("Error on save 'amountOfLeadsForManager++ = {$currentManager['amount']}' \n", Console::FG_RED);
                } else {
                    $this->stdout("Inc 'amountOfLeadsForManager++ = {$currentManager['amount']}' \n", Console::FG_GREEN);
                }
            }
        } else {
            $this->stdout("No new leads found\n", Console::FG_GREEN);
        }

        $this->stdout("Check managers reacts\n", Console::FG_GREEN);
        //Теперь смотрим есть ли сделки которые не отработаны (status != 0 && status != 3 ) и при этом активны (log == 0) если да то копируем их обратно во входящие
        /* @var  $lead AssigmentLeads */
        $leads = AssigmentLeads::find()->all();
        foreach ($leads as $lead) {
            if ($lead->log == 0) {
                // Если сделка пришла, но время вышло
                if ($lead->status == AssigmentLeads::STATUS_NONE && time() - $lead->created_at > 60) {
                    $lead->status = AssigmentLeads::STATUS_MISSED;
                }
                // Статус сделки сменился на пропущенный
                if ($lead->status == AssigmentLeads::STATUS_MISSED) {
                    $this->stdout("Lead {$lead['lead_id']} reverted (missed)\n", Console::FG_YELLOW);
                    $lead->log = 1;
                    $lead->save(false);
                    QueueLeads::addLeads($lead);
                }
                // Статус сделки сменился на отклонённый
                if ($lead->status == AssigmentLeads::STATUS_REFUSED) {
                    $this->stdout("Lead {$lead['lead_id']} reverted (refused)\n", Console::FG_YELLOW);
                    $lead->log = 1;
                    $lead->save(false);
                    QueueLeads::addLeads($lead);
                }
                //Статус сделки сменился на выполнено
                if ($lead->status == AssigmentLeads::STATUS_ACCEPTED) {
                    $this->stdout("Lead {$lead['lead_id']} accepted!\n", Console::FG_GREEN);
                    $lead->log = 1;
                    $lead->save(false);
                }
            }
        }

        return null;
    }


    public function actionTest()
    {
        $currentManager = Option::getCurrentManagerForLead();
        var_dump($currentManager); exit("\n");
    }

}
