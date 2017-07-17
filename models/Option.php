<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "options".
 *
 * @property integer $id
 * @property string $option
 * @property string $value
 */
class Option extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'options';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['option'], 'string', 'max' => 1024],
            [['value'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'option' => 'Option',
            'value' => 'Value',
        ];
    }

    /**
     * @param $option string
     * @param $value string
     * @return bool
     */
    public static function setOption($option, $value)
    {
        $currentOption = self::findOne(['option' => $option]);
        if (empty($currentOption)) {
            $currentOption = new self();
        }
        $currentOption->option = $option;
        $currentOption->value = $value;
        return $currentOption->save();
    }

    /**
     * @param $option
     * @return null|string
     */
    public static function getOption($option)
    {
        $option = self::findOne(['option' => $option]);
        if (empty($option)) {
            return null;
        }
        return $option->value;
    }


    /**
     * Добывает из параметров текущего менеджера в очереди и количество
     * пошедших заявок его текущей очереди
     * @return array
     */
    public static function getCurrentManagerForLead()
    {
        $managerId = self::getOption('managerForLead');
        if (empty($managerId)) {
            // текущего менеджера нет, пытаемся найти следующего
            $managerId = ManagerOption::getNextActiveManager(0)['manager_id'];
            self::setOption('managerForLead', $managerId);
            self::setOption('amountOfLeadsForManager', 0);
        } else {
            // проверяем текущего менеджера, он мог быть деактивирован
            $isActiveManager = ManagerOption::find()->where(['>', 'is_manager', '0'])
                ->andWhere(['>', 'member_allocation', '0'])
                ->andWhere(['=', 'user_ext_id', $managerId])->one();
            if (empty($isActiveManager)) {
                $managerId = ManagerOption::getNextActiveManager(0)['manager_id'];
                self::setOption('managerForLead', $managerId);
                self::setOption('amountOfLeadsForManager', 0);
            }
        }
        // количество заявок, которое уже распределено на данного менеджера
        $amountOfLeads = self::getOption('amountOfLeadsForManager');
        if (empty($amountOfLeads)) {
            $amountOfLeads = 0;
        }
        if (!empty($managerId)) {
            return ['manager_id' => $managerId, 'amount' => intval($amountOfLeads)];
        }
        return ['manager_id' => 0, 'amount' => 0];
    }

}
