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

    /**
     * @return array
     * получаем массив Id менеджера => ФИО менеджера
     */

    public static function managerIds()
    {
        $managers = Manager::find()
            ->asArray()
            ->all();

        $response = [];
        foreach ($managers as $manager) {
            $response[$manager['responsible_user_id']] = $manager['name'];
        }
        return $response;

    }

    /** Обновлет менеджеров полученных из амо
     * @param $users array
     */
    public function changeUsersName($users)
    {
        //var_dump($users);
        foreach($users as $user) {
            $manager = new Manager();
            //Если новый пользователь то добавляем
            $queueUser = $manager->findOne(['responsible_user_id'=>$user['id']]);
            //Если такой менеджер есть то обновляем
            if(!$queueUser) {
                $manager->responsible_user_id = $user['id'];
                $manager->name = $user['name'];
                $manager->save(false);
                // Если нет то добавляем
            }else{
                // Если поменялось имя менеджера
                $manager = $manager->findOne(['responsible_user_id'=>$user['id']]);
                if($manager->name != $user['name'] && $manager->responsible_user_id == $user['id']){
                    $manager->name = $user['name'];
                    $manager->save(false);
                }
            }

        }
    }

}
