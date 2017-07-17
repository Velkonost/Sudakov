<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "manager".
 *
 * @property integer $id
 * @property integer $responsible_user_id
 * @property string $name
 */
class Manager extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'manager';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['responsible_user_id', 'name'], 'required'],
            [['responsible_user_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'responsible_user_id' => 'Responsible User ID',
            'name' => 'Name',
        ];
    }
}
