<?php

namespace app\models;

use Yii;


/**
 * This is the model class for table "amo_leads_log".
 *
 * @property integer $id
 * @property integer $pk
 * @property string $name
 * @property string $username
 * @property string $text
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $lead_ext_id
 */
class AmoLeadsLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'amo_leads_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pk', 'created_at', 'updated_at', 'lead_ext_id'], 'integer'],
            [['name'], 'string', 'max' => 512],
            [['username'], 'string', 'max' => 120],
            [['text'], 'string', 'max' => 4096],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pk' => 'Pk',
            'name' => 'Name',
            'username' => 'username',
            'text' => 'Text',
            'created_at' => 'Дата создания комментария',
        ];
    }
}
