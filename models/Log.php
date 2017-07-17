<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log".
 *
 * @property integer $id
 * @property integer $job_id
 * @property integer $old_status
 * @property integer $new_status
 * @property integer $created_at
 * @property string $username
 */
class Log extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['job_id', 'old_status', 'new_status', 'created_at'], 'required'],
            [['job_id', 'old_status', 'new_status', 'created_at'], 'integer'],
            [['username'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'job_id' => 'Job ID',
            'old_status' => 'Old Status',
            'new_status' => 'New Status',
            'created_at' => 'Created At',
        ];
    }
}
