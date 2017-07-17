<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "collections".
 *
 * @property integer $id
 * @property string $label
 * @property string $color
 */
class Collections extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'collections';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['label'], 'required'],
            [['label'], 'string', 'max' => 255],
            [['color'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'label' => 'Label',
            'color' => 'Color',
        ];
    }
}
