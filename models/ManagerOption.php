<?php

namespace app\models;

use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "manager_options".
 *
 * @property integer $manager_id
 * @property string $user_ext_id
 * @property string $user_name
 * @property integer $is_manager
 * @property integer $member_allocation
 * @property integer $coefficient
 */
class ManagerOption extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'manager_option';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_manager', 'member_allocation', 'coefficient'], 'integer'],
            [['name'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'manager_id' => 'ID',
            'user_ext_id' => 'Внешний id из амо',
            'user_name' => 'Name',
            'is_manager' => 'Is Manager',
            'member_allocation' => 'Member Allocation',
            'coefficient' => 'Coefficient',
        ];
    }

    public function changeValues($data){
        $lead = new ManagerOption();
        $lead = $lead->findOne(['manager_id'=>$data['manager_id']]);
        //var_dump($data['value']);
        $lead->{$data['field']} = $data['value'];
        $lead->update(false);
        return $lead->save(false);

        /*
        foreach ($data as $manager) {
            $lead = new QueueLeads();
            $lead = $lead->findOne(['queue_leads_id'=>$manager['queue_leads_id']]);
            if($lead) {
                $lead->is_manager = $manager['is_manager'] == "true" ? 1 : 0;
                $lead->member_allocation = $manager['member_allocation'] == "true" ? 1 : 0;
                //foreach ($manager as $key => $item) {
                //    $lead->$key = intval($item);
                //}
                $lead->save(false);
            }
        }
        */
    }


    /** Обновлет менеджеров полученных из амо
     * @param $users array
     */
    public function changeUsersName($users)
    {
        //var_dump($users);
        foreach($users as $user) {
            $manager = new ManagerOption();
            //Если новый пользователь то добавляем
            $queueUser = $manager->findOne(['user_ext_id'=>$user['id']]);
            //Если такой менеджер есть то обновляем
            if(!$queueUser) {
                $manager->user_ext_id = $user['id'];
                $manager->coefficient = 1;
                $manager->user_name = $user['name'];
                $manager->is_manager = 1;
                $manager->save(false);
                // Если нет то добавляем
            }else{
                // Если поменялось имя менеджера
                $manager = $manager->findOne(['user_ext_id'=>$user['id']]);
                if($manager->user_name != $user['name'] && $manager->user_ext_id == $user['id']){
                    $manager->manager_id = $queueUser->manager_id;
                    $manager->user_name = $user['name'];
                    $manager->save(false);
                }
            }

        }
    }


    /** Получаем следующего менеджера
     * @param $managerId integer  - id пользователя из amocrm (ext_id)
     * @return array [integer, integer] ext_id следующего пользователя и его коэффициент
     */
    public static function getNextActiveManager($managerId)
    {
        $activeManagers =  self::find()->where(['>', 'is_manager', '0'])
            ->andWhere(['>', 'member_allocation', '0'])->all();
        if (!empty($activeManagers)) {
            $currentManager = self::findOne(['user_ext_id' => $managerId]);
            //Переберём всех и найдём на 1 большего текущему
            if (!empty($currentManager)) {
                foreach ($activeManagers as $activeManager) {
                    if ($currentManager->manager_id < $activeManager->manager_id) {
                        return ['manager_id' => $activeManager->user_ext_id, 'coefficient' => intval($activeManager->coefficient)];
                    }
                }
            }
            // Похоже это последний менеджер, возвращаем первого
            return ['manager_id' => $activeManagers[0]->user_ext_id, 'coefficient' => intval($activeManagers[0]->coefficient), 'amount' => 0];
        }
        return ['manager_id' => 0, 'coefficient' => 0, 'amount' => 0];
    }


    /**
     * @param int $managerExtId
     * @return int
     */
    public static function getCoefficient($managerExtId)
    {
        $manager = self::find()->where(['user_ext_id' => $managerExtId])->one();
        if (!empty($manager)) {
            return intval($manager['coefficient']);
        }
        return 0;
    }
}
