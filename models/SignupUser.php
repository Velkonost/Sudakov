<?php
namespace app\models;

use yii\base\Model;


/**
 * Signup form
 */
class SignupUser extends Model
{
    public $username;

    public $email;

    public $password;

    public $fio;

    public $role;

    public $status;

    public $isNewRecord = true;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            [['username', 'role', 'status', 'password'], 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 4, 'max' => 255],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['fio', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->fio = $this->fio;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        if ($user->save()) {
            if ($user->setRole($this->role)) {
                return $user;
            }
        }
        return null;
    }

    public function isNewRecord()
    {
        return true;
    }
}