<?php
/**
 * Created by PhpStorm.
 * User: coder
 * Date: 29.11.16
 * Time: 13:43
 */

namespace app\commands;

use app\models\AmoLeadsLog;
use InstagramAPI\Instagram;
use yii\base\Exception;
use yii\console\Controller;
use yii\helpers\Console;
use app\models\Amo;
use app\models\InstagramMedia;


/**
 * Class InstagramController
 * @package app\commands
 */
class InstagramController  extends Controller
{
    private $login = '';

    private $password = '';

    // Итервал времени в течении которого лида не отправляем в базу, если итервал между комментариями больше то отправляем повторно
    const WEEK = 3600 * 24 * 7;

    /** @var $instagram \InstagramAPI\Instagram  */
    private $instagram;


    public function init()
    {
        $this->login = \Yii::$app->params['instagram']['login'];
        $this->password = \Yii::$app->params['instagram']['password'];
        $this->instagram = new Instagram();
    }


    public function actionIndex()
    {
        $this->stdout("Use:\n   $ php yii instagram/get-medias\n", Console::FG_GREEN);
        $this->stdout("   $ php yii instagram/check-comments\n", Console::FG_GREEN);
    }

    /**
     * Скрипт №1 Загружаем медиа поочерёдно
     */
    public function actionGetMedias()
    {
        $this->auth();
        $maxId = null;
        $totalNewMedias = 0;
        $this->stdout("Запуск обновления ленты Media...\n", Console::FG_GREEN);
        while (($result = $this->instagram->getSelfUserFeed($maxId)) && $result && $result->num_results > 0) {
            $this->stdout("Загружено {$result->num_results} записей\n", Console::FG_GREEN);
            $newMedias = 0;
            foreach ($result->items as $mediaItem) {
                if (!InstagramMedia::isExists($mediaItem->id)) {
                    $this->stdout("   New {$mediaItem->id} Url: " . $mediaItem->getItemUrl() . " ... ", Console::FG_CYAN);
                    $maxId = $mediaItem->id;
                    if (InstagramMedia::insertMedia($mediaItem)) {
                        $newMedias++;
                        $this->stdout("saved\n", Console::FG_GREEN);
                    } else {
                        $this->addToLog('Не получается сохранить media (' . $mediaItem->id . ') в таблицу');
                        $this->stdout("Ошибка сохранения {$mediaItem->id} в таблицу\n", Console::FG_RED);
                    }
                }
            }
            if ($newMedias == 0) {
                // новых записей не найдено, можно выходить
                $this->stdout("Больше нет новых записей\n", Console::FG_GREEN);
                break;
            }
            $totalNewMedias += $newMedias;
            sleep(3); // инстаграм боится частых запросов
        }
        $this->stdout("Считывание завершено. Всего сохранено {$totalNewMedias} новых записей\n", Console::FG_GREEN);
    }


    /**
     * Скрипт №2 Устанавливаем сделки согластно условиям читая комментарии медиа.
     */
    public function actionCheckComments()
    {
        $this->auth();
        $medias = InstagramMedia::find()->all();
        foreach ($medias as $media) {
            $this->stdout("Проверяю {$media['media_id']} ... ", Console::FG_GREEN);
            $data = $this->instagram->getMediaComments($media['media_id']);
            $this->stdout("{$data->comment_count} комментариев\n", Console::FG_GREEN);
            if (!empty($data->comments)) {
                $this->stdout("Анализ ... ", Console::FG_GREEN);
                $this->process($data->comments, $media['media_url']);
            } else {
                $this->stdout("Нет данных для анализа\n", Console::FG_GREEN);
            }
        }
    }


    /**
     * Авторизация в инстаграм
     */
    private function auth()
    {
        $this->stdout("Авторизуюсь в Instagram ... ", Console::FG_GREEN);
        $this->instagram->setUser($this->login, $this->password);
        try {
            $this->instagram->login();
        } catch (\Exception $e) {
            if (strrpos($e->getMessage(), 'login')) {
                try {
                    $this->instagram->login(true);
                } catch (\Exception $e) {
                    $this->stdout('ошибка: ' . $e->getMessage() . "\n", Console::FG_RED);
                    $this->addToLog('Ошибка авторизации: ' . $e->getMessage() . "\n");
                    exit;
                }
            }
        }
        if (!$this->instagram->isLoggedIn) {
            $this->stdout("ошибка", Console::FG_RED);
            $this->addToLog("не удалось авторизоваться в Instagram\n");
            exit;
        }
        $this->stdout("OK\n", Console::FG_GREEN);
    }


    /**
     * Анализ комментариев и создание сделок
     * @param $comments \InstagramAPI\Comment[]
     * @param $mediaUrl string
     * @return bool
     */
    public function process($comments, $mediaUrl)
    {
        $num = 0;
        $amo = new Amo(\Yii::$app->params);
        if ($amo->getErrorCode() == 0) {
            if (!empty($comments)) {
                foreach ($comments as $comment) {
                    $commentTime = $comment->created_at;
                    if ($comment->user->pk == 406216890) continue; // пропускаем самого владельца // todo брать ID из запроса личных данных
                    if ($commentTime < time() - InstagramController::WEEK) continue;
                    /* @var $log AmoLeadsLog */
                    $log = AmoLeadsLog::find()->where(['pk' => $comment->user->pk])
                        ->orderBy(['updated_at' => SORT_DESC])->one();
                    // если логи найдены, то проверяем статус последней сделки пользователя.
                    // если сделка активна, то добавляем туда коммент
                    // иначе создаем новую сделку
                    if (!empty($log)) {
                        // Сделка уже существует и новый коммент, читаем её чтобы узнать статус
                        $lead = $amo->getLead($log->lead_ext_id);
                    } else {
                        //Комментарий новый и его нет в базе то следовательно создаём новую сделку
                        $lead = $this->createNewLead($comment, $amo, $mediaUrl);
                        if (!empty($lead)) {
                            $num++;
                        }
                        $this->stdout("+(new comment {$comment->user->pk})", Console::FG_GREEN);
                        continue;
                    }
                    if (!empty($lead)) {
                        if (!empty($commentTime) && $commentTime > $log['updated_at']) {
                            if ($lead['status_id'] == Amo::STATUS_COMPLETED || $lead['status_id'] == Amo::STATUS_FAILED) {
                                // Сделка уже закрыта, надо бы новую создать!
                                $lead = $this->createNewLead($comment, $amo, $mediaUrl, $log);
                                if (!empty($lead)) {
                                    $num++;
                                }
                            } else {
                                // Сделка ещё открыта, чтобы не плодить сущностей добавляем комментарий в неё.
                                $amo->addLeadComment($lead['id'], $comment->text . ' ' . $mediaUrl);
                                $this->stdout("+(new comment {$comment->user->pk})", Console::FG_GREEN);
                            }
                        }
                    } else {
                        // для старых записей без ID сделки
                        // если поле сделки пустое, то сверяем дату последнего коммента
                        // - если с последнего коммента прошло больше 2х недель, то создаем новую сделку
                        $difTime = (time() - $commentTime);
                        if (!empty($commentTime) && $commentTime > strtotime('-3 days') && $log->created_at < $commentTime && $difTime > self::TIME_TO_REGARD_AS_NEW_LEAD) {
                            $lead = $this->createNewLead($comment, $amo, $mediaUrl, $log);
                            if (!empty($lead)) {
                                $num++;
                            }
                        } else {
                            $this->stdout(".", Console::FG_GREEN);
                        }
                    }
                    sleep(3); // Чтобы инстаграм не банил
                }
            }
        } else {
            $this->stdout("не удалось подключиться к AMOCRM\n", Console::FG_RED);
            $this->addToLog("не удалось подключиться к AMOCRM\n");
            return false;
        }
        if ($num) {
            $this->stdout("\nДобавлено сделок: {$num}\n", Console::FG_GREEN);
        }
        return true;
    }


    /**
     * Создаём новую сделку в амо из комментария и если её небыло в таблице заносим туда.
     * @param \InstagramAPI\Comment $comment
     * @param Amo $amo
     * @param $url string
     * @param AmoLeadsLog $log
     * @return array|bool
     */
    public function createNewLead($comment, $amo, $url = null, $log = null)
    {
        $commentTime = intval($comment->created_at);
        // Сделка существует или нет, если нет то создаёт, если да то только обновляем время
        if (empty($log)) {
            $log = new AmoLeadsLog();
            $log->pk = $comment->user->pk;
            $log->name = \utf8_encode($comment->user->full_name);
            $log->lead_ext_id = 0;
            $log->text = \utf8_encode($comment->text);
            $log->username = \utf8_encode($comment->user->username);
            $log->created_at = $commentTime;
        }
        $log->updated_at = $commentTime;
        if (!$log->save()) {
            $error = "Error save log!\n" . var_export($log->getErrors(), true) . "\n";
            $this->stdout($error, Console::FG_RED);
            $this->addToLog($error . ' -> ' . $log->getErrors());
            return false;
        }
        $commentArray = [
            'created_at' => $comment->created_at,
            'text' => $comment->text,
            'status' => $comment->status,
            'roistat' => 'Инстаграм',
            'URL' => $url
        ];
        $amoLead = $amo->createLead('Заявка Instagram (' . date('d-m-Y H:i', $comment->created_at) . ')', $commentArray)[0];
        $amo->createContact($comment->user->username, [], $amoLead['id']);
        $note = "{$comment->user->username}: {$comment->text}\nURL = {$url}";
        $amo->addLeadComment($amoLead['id'], $note);
        $this->stdout("+[{$comment->user->pk}]", Console::FG_GREEN);
        $log->lead_ext_id = $amoLead['id'];
        $log->save();
        return $amoLead;
    }

    /** Добавляет в лог файл запись об ошибке
     * @param $item string
     * @return int
     */
    private function addToLog($item)
    {
        if (is_array($item)) {
            $item = json_encode($item, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
        try {
            file_put_contents(
                '/var/www/instagram.php.log',
                "\n".date('d-m-Y H:i:s', time()). ' - '. trim(strval($item)),
                FILE_USE_INCLUDE_PATH | FILE_APPEND | LOCK_EX);
        } catch(\Exception $e) {
            // nope
        }
    }
}