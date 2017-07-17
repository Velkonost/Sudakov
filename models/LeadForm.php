<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Amo;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LeadForm extends Model
{
    public $name;
    public $phone;
    public $city;
    public $request;
    public $email;
    public $source;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'source'], 'required', 'message' => 'Не может быть пустым'],
            [['phone', 'request', 'source', 'city'], 'safe'],
            ['email', 'email']
        ];
    }



    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function saveLead()
    {
        $amo = new Amo(\Yii::$app->params);
        if ($amo->getErrorCode() == 0) {
            $caption = empty($this->request) ? $this->name : $this->request;
            $custom['roistat'] = $this->source;
            $result = $amo->createLead($caption, $custom);
            if ($amo->getErrorCode() != 0) {
                return false;
            }
            $leadId = @$result[0]['id'];
            if (!empty($leadId)) {
                $custom = ['phone' => $this->phone, 'email' => $this->email, 'city' => $this->city];
                $contact = $amo->createContact($this->name, $custom, $leadId);
                if (!is_array($contact)) {
                    return false;
                }
                $anketa = 'http://sergeysudakov.ru/zaponki/anketa/index.php?id=' . $leadId;
                $amo->addLeadComment($leadId, 'Анкета: ' . $anketa);
            }
            return true;
        }
        return false;
    }

}
