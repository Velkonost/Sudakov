<?php
namespace app\commands;

use app\models\LeadStatus;
use yii\console\Controller;
use yii\helpers\Console;
use app\models\Amo;
use app\models\Lead;

class AmoController extends Controller
{

    public function actionIndex()
    {
        $this->stdout("Use: php yii amo/load-leads\n", Console::FG_GREEN);
    }

    public function actionLoadLeads()
    {
        $this->stdout("Start loading leads\n", Console::FG_GREEN);
        $amo = new Amo(\Yii::$app->params);
        if ($amo->getErrorCode() == 0) {
            $page = 0;
            do {
                $this->stdout("   loading page #{$page}...", Console::FG_GREEN);
                $leads = $amo->getAllLeads($page);
                if (empty($leads)) {
                    $this->stdout("   no more leads found\n", Console::FG_GREEN);
                    break;
                }
                $this->stdout(count($leads) . " loaded, saving ", Console::FG_GREEN);
                foreach ($leads as $lead) {
                    $leadModel = Lead::updateFromAmo($lead, $log);
                    if (isset($log['no_status'])) {
                        $this->stdout(" [STATUS {$lead['status_id']} NOT FOUND] ", Console::FG_RED);
                    }
                    if (!$leadModel->hasErrors()) {
                        $this->stdout($log['char'], Console::FG_GREEN);
                    } else {
                        $this->stdout("х", Console::FG_RED);
                        print_r($leadModel->getErrors()); exit;
                    }
                }
                echo "\n";
                $page++;
            } while(true);
            $this->stdout("Done", Console::FG_GREEN);
            $this->stdout(" \n", 0);
        } else {
            $this->stdout("Fail on connection to AMO\n", Console::FG_RED);
        }
    }

}
