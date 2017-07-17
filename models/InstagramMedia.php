<?php

namespace app\models;

use Yii;
use InstagramAPI;

/**
 * This is the model class for table "{{%instagram_media}}".
 *
 * @property integer $id
 * @property integer $media_id
 * @property string $media_url
 */
class InstagramMedia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%instagram_media}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['media_id'],  'string', 'max' => 31],
            [['media_url'], 'string', 'max' => 40],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'media_id' => 'Media ID',
            'media_url' => 'Media Url',
        ];
    }

    /**
     * Проверяет наличие записи
     * @param $mediaId
     * @return bool
     */
    public static function isExists($mediaId)
    {
        $mediaLog = self::find()->where(['media_id' => $mediaId])->one();
        return empty($mediaLog) ? false : true;
    }

    /**
     * Добавляет media если оно не существует
     * @param $media InstagramAPI\item
     * @return bool
     */
    public static function insertMedia($media, $noCheck = false)
    {
        $mediaLog = self::find()->where(['media_id' => $media->id])->one();
        if (empty($mediaLog) || $noCheck) {
            $mediaModel = new InstagramMedia();
            $mediaModel->media_id = $media->id;
            $mediaModel->media_url = $media->getItemUrl();
            return $mediaModel->save();
        }
        return false;
    }
}
