<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "queue_leads".
 *
 * @property integer $id
 * @property integer $lead_id
 * @property integer $created_at
 */
class QueueLeads extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'queue_leads';
    }

    /**
     *
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lead_id', 'created_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lead_id' => 'Lid',
            'created_at' => 'Дата поступления сделки',
        ];
    }
    /**
     * @param $lead AssigmentLeads
     */
    static public function addLeads($lead)
    {
        $queue = new self();
        $queue->lead_id = $lead->lead_id;
        $queue->created_at = 0;//$lead->created_at;
        $queue->save();
    }
}
