<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payment".
 *
 * @property integer $id
 * @property integer $ext_id
 * @property integer $pnum // первый или второй счет (предоплата и постоплата)
 * @property string $client
 * @property string $comment
 * @property string $items For json of products
 * @property string $manager
 * @property double $sum
 * @property integer $status
 * @property integer $created_at
 * @property integer $paid_at
 */
class Payment extends \yii\db\ActiveRecord
{

    const STATUS_WAIT = 0;
    const STATUS_PAID = 1;
    const STATUS_TO_DELETE = 10;

    const TYPE_P1 = 1;
    const TYPE_P2 = 2;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pnum'], 'required'],
            [['ext_id', 'pnum', 'status', 'created_at', 'paid_at'], 'integer'],
            [['sum'], 'number'],
            [['client'], 'string', 'max' => 100],
            [['comment', 'manager'], 'string', 'max' => 255],
            [['items'], 'string', 'max' => 5000],
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
            'pnum' => 'Pnum',
            'client' => 'Client',
            'comment' => 'Comment',
            'manager' => 'Manager',
            'sum' => 'Sum',
            'status' => 'Status',
            'created_at' => 'Created At',
            'paid_at' => 'Paid At',
        ];
    }

    public static function statuses()
    {
        return [
            self::STATUS_WAIT => 'Ожидает оплаты',
            self::STATUS_PAID => 'Оплачен',
            self::STATUS_TO_DELETE => 'Удалить',
        ];
    }

    public static function types($all = true)
    {
        $types = [
            self::TYPE_P1 => '1-я оплата',
            self::TYPE_P2 => '2-я оплата',
        ];
        if ($all) {
            $types[0] = '1-я оплата';
        }
        return $types;
    }


    /*
     *   @param integer $payment
     *   @param integer $payment_amount
     *   @return string
     */
    public static function get_colour($acquiring=0, $payment_amount=0){
        // $payment = str_replace(' ', '', $payment);
        if($acquiring!=0) // оплата прошла, но деньги ещё не пришли
        {
            if (intval($acquiring) != intval($payment_amount)) return 'red';
            else return 'green';
        }
        return '';
    }


    /*
     * Получение из модели оплаты лида
     * @param $payments integer
     * @param $num integer номер оплаты
     * return integer
     */
    public static function get_payment($payments, $num = 1){
        $pay=0;
        if ($payments) {
            foreach ($payments as $payment) {
                if ($payment->pnum == $num && $payment->status == Payment::STATUS_PAID) {
                    $pay = intval($payment->sum);
                }
            }
        }
        return $pay;
    }

}
