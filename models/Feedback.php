<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "feedbacks".
 *
 * @property integer $id
 * @property string $date
 * @property string $fio
 * @property string $budget
 * @property string $thumbnail
 * @property string $text
 * @property string $phone
 */
class Feedback extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'feedbacks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'fio', 'budget'], 'required'],
            [['date'], 'safe'],
            [['budget', 'ext_id'], 'number'],
            [['text'], 'string'],
            [['fio'], 'string', 'max' => 100],
            [['thumbnail'], 'string', 'max' => 500],
            [['phone'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'fio' => 'Fio',
            'budget' => 'Budget',
            'thumbnail' => 'Thumbnail',
            'text' => 'Text',
            'phone' => 'Phone',
            'ext_id' => 'Lead Id',
        ];
    }
}
