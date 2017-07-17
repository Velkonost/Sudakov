<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lead".
 *
 * @property integer $lead_id
 * @property integer $ext_id
 * @property string $name
 * @property string $total_sum
 * @property integer $created_at
 * @property string $city
 * @property integer $status_id Этот ID соотносится с полем ID таблицы `lead_status`, а не ext_id.
 */
class Lead extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lead';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['responsible_user_id', 'lead_id', 'ext_id', 'created_at', 'status_id'], 'integer'],
            [['total_sum'], 'number'],
            [['city'], 'string'],
            [['name'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'lead_id' => 'Lead ID',
            'ext_id' => 'Ext ID',
            'name' => 'Name',
            'total_sum' => 'Total Sum',
            'created_at' => 'Created At',
            'status_id' => 'Status ID',
            'responsible_user_id' => 'Responsible user',
        ];
    }

    /**
     * @inheritdoc
     * @return LeadQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LeadQuery(get_called_class());
    }


    /**
     * @param array $lead
     * @param array $log
     * @return Lead
     */
    public static function updateFromAmo($lead, &$log = [])
    {
        // запрашиваем город клиента
        $city = '';
        $amo = new Amo(\Yii::$app->params);
        if ($amo->getErrorCode() == 0) {
            $contact = $amo->getContactByLead($lead['id']);
            if (!empty($contact)) {
                foreach ($contact['custom_fields'] as $cf) {
                    if ($cf['id'] == Amo::USER_FIELD_CITY) {
                        $city = mb_substr($cf['values'][0]['value'], 0, 30, 'utf8');
                    }
                }

            }
        }
        $status = LeadStatus::find()->where(['ext_id' => $lead['status_id']])->one();
        if (!$status) {
            $status = 0;
            $log['no_status'] = true;
        } else {
            $status = $status['id'];
        }

        $responsible_user_id = $lead['responsible_user_id'];

        $model = self::find()->where(['ext_id' => $lead['id']])->one();
        if (empty($model)) {
            $model = new self();
        }
        $log['char'] = $model->isNewRecord ? '.' : '+';
        $model->setAttributes([
            'ext_id' => $lead['id'],
            'name' => $lead['name'],
            'total_sum' => floatval($lead['price']),
            'created_at' => intval($lead['date_create']),
            'status_id' => $status,
            'city' => $city,
            'responsible_user_id' => $responsible_user_id,
        ]);
        $model->save();
        return $model;
    }


    /**
     * Обновляет статус сделки в нашей базе, если он изменился
     * @param array $lead
     * @param bool $isChanged
     * @return bool
     */
    public static function updateLeadAmoStatus($lead, &$isChanged = false)
    {
        $leadStatus = LeadStatus::find()->where(['ext_id' => $lead['status_id']])->one(); /* @var $leadStatus LeadStatus */
        $ownStatusId = empty($leadStatus) ? 0 : $leadStatus->id;
        $model = self::find()->where(['ext_id' => $lead['id']])->one();
        if (!empty($model)) {
            if ($model->status_id != $ownStatusId) {
                $isChanged = true;
                $model->status_id = $ownStatusId;
                $model->save();
                $log = new LeadLog();
                $log->lead_id = $model->lead_id;
                $log->lead_ext_id = $lead['id'];
                $log->lead_status_id = $ownStatusId;
                $log->lead_ext_status_id = $lead['status_id'];
                $log->updated_at = time();
                return $log->save();
            } else {
                return true;
            }
        }
        return false;
    }


}
