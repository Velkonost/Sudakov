<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "assignment_leads".
 *
 * @property integer $id
 * @property integer $manager_id
 * @property integer $lead_id
 * @property integer $log
 * @property integer $status
 * @property integer $created_at
 */
class AssigmentLeads extends \yii\db\ActiveRecord
{
    const STATUS_NONE = 0;
    const STATUS_MISSED = 1;
    const STATUS_REFUSED = 2;
    const STATUS_ACCEPTED = 3;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'assignment_leads';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['manager_id', 'lead_id'], 'required'],
            [['manager_id', 'lead_id', 'status', 'created_at', 'log'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'manager_id' => 'ID мэнеджера',
            'lead_id' => 'ID сделки',
            'status' => 'Status',
            'log' => 'Журнал? ', // Запись рассматривается как журнал если !=0
            'created_at' => 'Created At',
        ];
    }
}
