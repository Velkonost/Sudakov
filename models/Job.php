<?php

namespace app\models;

use Yii;
use app\models\Amo;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "job".
 *
 * @property integer $id
 * @property integer $ext_id
 * @property string $name
 * @property string $client
 * @property integer $deadline
 * @property string $collection
 * @property string $plan_description
 * @property string $sketch
 * @property string $plan
 * @property string $plan_ai
 * @property string $description
 * @property integer $status
 * @property integer $created_at
 * @property integer $started_at
 * @property integer $finished_at
 * @property tinyint $adminchek
 */
class Job extends \yii\db\ActiveRecord
{

    const STATUS_NEW = 0; // не обработан
    const STATUS_ETCHING = 20; // гравировка
    const STATUS_ETCHING_DONE = 25; // гравировка готова
    const STATUS_WOOD_MILLING = 30; // дерево фрезировка
    const STATUS_WOOD_DONE = 31; //Дерево готово
    const STATUS_WAX_MILLING = 40; // воск фрезировка
    const STATUS_WAX_DONE = 41; //Воск готов
    const STATUS_CASTING = 50; // литье
    const STATUS_GRINDING = 60; // Шлифовка, монтировка
    const STATUS_PILOTING = 70; // Опробирование
    const STATUS_TRASH = 80; // Мусор
    const STATUS_DONE = 90; // Успешно реализовано
    const STATUS_FAIL = 100; // Закрыто и не реализовано


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'job';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ext_id'], 'required'],
            [['ext_id', 'deadline', 'status'], 'integer'],
            [['name', 'client', 'collection'], 'string', 'max' => 255],
            [['sketch', 'plan', 'plan_ai', 'description', 'plan_description'], 'string', 'max' => 5000],
            [['ext_id'], 'unique'],
            [['name', 'client', 'collection', 'sketch', 'plan', 'plan_ai', 'description', 'plan_description',
                'started_at', 'finished_at', 'adminchek'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ext_id' => 'Ext ID',
            'name' => 'Name',
            'client' => 'Client',
            'deadline' => 'Deadline',
            'collection' => 'Collection',
            'sketch' => 'Sketch',
            'plan' => 'Plan',
            'plan_ai' => 'Plan',
            'description' => 'Description',
            'status' => 'Status',
            'created_at' => 'Created At',
            'started_at' => 'Started At',
            'finished_at' => 'Finished At',
        ];
    }


    public static function getStatuses($emptyCaption = false)
    {
        $items = [];
        if ($emptyCaption) {
            $items[-1] = 'Все';
        }
        $items[ self::STATUS_NEW ] = 'Не обработан';
        $items[ self::STATUS_ETCHING ] = 'Гравировка';
        $items[ self::STATUS_ETCHING_DONE ] = 'Гравировка готова';
        $items[ self::STATUS_WOOD_MILLING ] = 'Дерево фрезеровка';
        $items[ self::STATUS_WOOD_DONE ] = 'Дерево готово';
        $items[ self::STATUS_WAX_MILLING ] = 'Воск фрезеровка';
        $items[ self::STATUS_WAX_DONE ] = 'Воск готов';
        $items[ self::STATUS_CASTING ] = 'Литье';
        $items[ self::STATUS_GRINDING ] = 'Шлифовка, монтировка';
        $items[ self::STATUS_PILOTING ] = 'Опробирование';
        $items[ self::STATUS_TRASH ] = 'Мусор';
        $items[ self::STATUS_DONE ] = 'Успешно реализовано';
        $items[ self::STATUS_FAIL ] = 'Закрыто и не реализовано';
        return $items;
    }


    public static function getStatusCaption($status)
    {
        $statuses = self::getStatuses();
        return isset($statuses[$status]) ? $statuses[$status] : '---';
    }

    /**
     * Загружает данные в новую работу
     * @param $post
     */
    public function insertFromAmo($lead)
    {
        $sketch = [];
        $planDXF = [];
        $planAI = [];
        $planDescription = [];
        $this->ext_id = @$lead['id'];
        $this->created_at = time();
        $nm = $this->generateNameByLead($lead);
        $this->name = !empty($nm) ? $nm : @$lead['name'];
        $this->status = 0;
        if (isset($lead['custom_fields'])) {
            foreach ($lead['custom_fields'] as $key => $field) {
                if ($field['id'] == Amo::FIELD_DEADLINE) {
                    $this->deadline = $field['values'][0];
                } else if ($field['id'] == Amo::FIELD_COLLECTION) {
                    $this->collection = $field['values'][0]['value'];
                } else if ($field['id'] == Amo::FIELD_SKETCH1 || $field['id'] == Amo::FIELD_SKETCH2) {
                    $key = ($field['id'] == Amo::FIELD_SKETCH2) ? 'k2' : 'k1';
                    $file = $field['values'][0]['value'];
                    if (stripos($file, 'dropbox') !== false) {
                        $file = str_replace('?dl=0', '?dl=1', $file);
                    }
                    $sketch[$key] = $file;
                } else if ($field['id'] == Amo::FIELD_PLAN_DXF1 || $field['id'] == Amo::FIELD_PLAN_DXF2) {
                    $key = ($field['id'] == Amo::FIELD_PLAN_DXF2) ? 'k2' : 'k1';
                    $file = $field['values'][0]['value'];
                    if (stripos($file, 'dropbox') !== false) {
                        $file = str_replace('?dl=0', '?dl=1', $file);
                    }
                    $name = explode('?', basename($file))[0];
                    $planDXF[$key] = [$name, $file];
                } else if ($field['id'] == Amo::FIELD_PLAN_AI1 || $field['id'] == Amo::FIELD_PLAN_AI2) {
                    $key = ($field['id'] == Amo::FIELD_PLAN_AI2) ? 'k2' : 'k1';
                    $file = $field['values'][0]['value'];
                    if (stripos($file, 'dropbox') !== false) {
                        $file = str_replace('?dl=0', '?dl=1', $file);
                    }
                    $name = explode('?', basename($file))[0];
                    $planAI[$key] = [$name, $file];
                } else if ($field['id'] == Amo::FIELD_PLAN_DESC1 || $field['id'] == Amo::FIELD_PLAN_DESC2) {
                    $key = ($field['id'] == Amo::FIELD_PLAN_DESC2) ? 'k2' : 'k1';
                    $planDescription[$key] = $field['values'][0]['value'];
                } else if ($field['id'] == Amo::FIELD_DESCRIPTION) {
                    $this->description = $field['values'][0]['value'];
                }
            }
            $this->sketch = json_encode($sketch);
            $this->plan = json_encode($planDXF);
            $this->plan_ai = json_encode($planAI);
            $this->plan_description = json_encode($planDescription);
            // get client name
            $amo = new Amo(\Yii::$app->params);
            if ($amo->getErrorCode() == 0) {
                $links = $amo->getLinks($this->ext_id);
                if (!empty($links['links'][0]['contact_id'])) {
                    $contacts = $amo->getContact($links['links'][0]['contact_id']);
                    if (!empty($contacts['contacts'][0]['name'])) {
                        $this->client = $contacts['contacts'][0]['name'];
                    } else {
                        file_put_contents(\Yii::$app->params['amoLogPath'] . "_error_amo3.log", var_export('Job: empty contact name', true));
                    }
                } else {
                    file_put_contents(\Yii::$app->params['amoLogPath'] . "_error_amo2.log", var_export('Job: empty contact_id', true));
                }
            } else {
                file_put_contents(\Yii::$app->params['amoLogPath'] . "_error_amo1.log", var_export('Job: AMO connection error" ' . $amo->getError(), true));
            }
        }
    }


    public function generateNameByLead($lead)
    {

        $name = 'Основа: ';
        if (isset($lead['custom_fields'])) {
            $result = ArrayHelper::index($lead['custom_fields'], 'id');
            $name .= $result[1288284]['values'][0]['value'].', ';
            $name .= $result[1288212]['values'][0]['value'].', ';
            if($result[1288214]['values'][0]['value'] !== 'Нет')
                $name .= $result[1288214]['values'][0]['value'].', ';
            if($result[1288282]['values'][0]['value'] !== 'Нет')
                $name .= 'Ножки: '.$result[1288282]['values'][0]['value'].', ';
            $name .= 'Накладки: ';
            if($result[1288220]['values'][0]['value'] !== 'Нет')
                $name .= $result[1288220]['values'][0]['value'].', ';
            if($result[1288224]['values'][0]['value'] !== 'Нет')
                $name .= $result[1288224]['values'][0]['value'].', ';
            if($result[1288304]['values'][0]['value'] !== 'Нет')
                $name .= $result[1288304]['values'][0]['value'].', ';
            if($result[1288286]['values'][0]['value'] !== 'Нет')
                $name .= $result[1288286]['values'][0]['value'].', ';
            if($result[1288222]['values'][0]['value'] !== 'Нет')
                $name .= $result[1288222]['values'][0]['value'].', ';
            if($result[1288226]['values'][0]['value'] !== 'Нет')
                $name .= $result[1288226]['values'][0]['value'].', ';
            if($result[1288228]['values'][0]['value'] !== 'Нет')
                $name .= $result[1288228]['values'][0]['value'].', ';
            if($result[1288306]['values'][0]['value'] !== 'Нет')
                $name .= $result[1288306]['values'][0]['value'].', ';
            if($result[1288230]['values'][0]['value'] !== 'Нет')
                $name .= $result[1288230]['values'][0]['value'].', ';
            if($result[1288288]['values'][0]['value'] !== 'Нет')
                $name .= $result[1288288]['values'][0]['value'].', ';
            $name = substr($name, 0, -2);
        }else{
            $name = '';
        }

        return $name;
    }


    /**
     * @param $lead
     * @return bool
     */
    public static function updateFromAmo($lead)
    {
        $job = Job::findOne(['ext_id' => $lead['id']]); /* @var $job Job */
        if ($job) {
            // дедлайн, наименование, коллекция
            if (!empty($lead['name'])) {
                $job->name = $lead['name'];
            }
            if (!empty($lead['custom_fields'])) {
                foreach ($lead['custom_fields'] as $cf) {
                    // обновляем поля, за исключением тех, которые уже фиксированны
                    if ($cf['id'] == Amo::FIELD_COLLECTION) {
                        // коллекция
                        $job->collection = $cf['values'][0]['value'];
                    } else if ($cf['id'] == Amo::FIELD_DEADLINE) {
                        // deadline
                        $job->deadline = $cf['values'][0];
                    }
                }
            }
            if ($job->save()) {
                return true;
            }
        }
        return false;
    }


    /**
     *
     */
    public function saveData()
    {
        $check = Job::find()->where(['ext_id' => $this->ext_id])->count();
        if ($check == 0) {
            if ($this->validate() && $this->save()) {
                return true;
            }
        }
        return false;
    }

}
