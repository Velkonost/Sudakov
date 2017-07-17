<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lead_log".
 *
 * @property integer $id
 * @property integer $lead_id
 * @property integer $lead_ext_id
 * @property integer $lead_status_id
 * @property integer $lead_ext_status_id
 * @property integer $updated_at
 */
class LeadLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lead_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lead_id', 'lead_ext_id'], 'required'],
            [['lead_id', 'lead_ext_id', 'lead_status_id', 'lead_ext_status_id', 'updated_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('apit', 'ID'),
            'lead_id' => Yii::t('apit', 'Lead ID'),
            'lead_ext_id' => Yii::t('apit', 'Lead Ext ID'),
            'lead_status_id' => Yii::t('apit', 'Lead Status ID'),
            'lead_ext_status_id' => Yii::t('apit', 'Lead Ext Status ID'),
            'updated_at' => Yii::t('apit', 'Updated At'),
        ];
    }
}
