<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lead_status".
 *
 * @property integer $id
 * @property integer $ext_id
 * @property string $label
 * @property string $color
 */
class LeadStatus extends \yii\db\ActiveRecord
{

    private static $_statuses = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lead_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ext_id', 'label', 'color'], 'required'],
            [['ext_id'], 'integer'],
            [['label'], 'string', 'max' => 50],
            [['color'], 'string', 'max' => 10],
            [['ext_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ext_id' => 'Ext ID',
            'label' => 'Label',
            'color' => 'Color',
        ];
    }


    /**
     * Returns all lead statuses
     * @param boolean $noColors Set to true, if no need return colors
     * @return array
     */
    public static function statuses($noColors = false)
    {
        if (empty(self::$_statuses)) {
            $all = self::find()->orderBy(['label' => SORT_ASC])->asArray()->all();
            foreach ($all as $item) {
                self::$_statuses[$item['ext_id']] = $item['label'] . ($noColors ? '' : " =" . $item['color']);
            }
        }
        return self::$_statuses;
    }


    /**
     * Returns status name by ExtID
     * @param $extId
     * @return string
     */
    public static function getStatusByExtId($extId)
    {
        $statuses = self::statuses(true);
        if (isset($statuses[$extId])) {
            return $statuses[$extId];
        }
        return '---';
    }

}
