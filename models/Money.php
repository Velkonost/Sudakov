<?php

namespace app\models;

use app\models\Amo;
use app\models\Payment;
use app\models\Manager;
use Yii;
use yii\data\Pagination;
use yii\helpers\Url;

/**
 * This is the model class for table "money".
 *
 * @property integer $id
 * @property integer $responsible_user_id
 * @property integer $ext_id
 * @property integer $created_at
 * @property integer $lead_status
 * @property string $client_name
 * @property string $phone
 * @property string $city
 * @property string $total_amount
 * @property string $first_payment_amount
 * @property integer $first_payment_status
 * @property integer $first_payment_method
 * @property integer $first_payment_date
 * @property string $second_payment_amount
 * @property integer $second_payment_status
 * @property integer $second_payment_method
 * @property integer $second_payment_date
 * @property integer $registry_check
 * @property integer $goods_bill_num
 * @property integer $goods_bill_date
 * @property string $goods_bill_comment
 * @property string $comment
 * @property string $comment_fin
 * @property string $collection
 * @property integer $count
 * @property string $units
 * @property integer $deadline
 * @property integer $finished_at
 * @property integer $first_payment_valid
 * @property integer $second_payment_valid
 */
class Money extends \yii\db\ActiveRecord
{

    const METHOD_YANDEX = 10;
    const METHOD_CARD = 20;
    const METHOD_BSO = 30;
    const METHOD_CASH = 40;
    const METHOD_BANK = 50;
    const METHOD_BANK_RS = 60;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'money';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ext_id', 'created_at', 'client_name'], 'required'],
            [['ext_id', 'responsible_user_id', 'created_at', 'first_payment_status', 'first_payment_method', 'first_payment_date',
                'second_payment_status', 'second_payment_method', 'second_payment_date', 'registry_check',
                'goods_bill_num', 'goods_bill_date', 'deadline', 'finished_at', 'first_payment_valid',
                'second_payment_valid', 'count', 'lead_status'], 'integer'],
            [['total_amount', 'first_payment_amount', 'second_payment_amount'], 'number'],
            //[['client_name', 'collection'], 'string', 'max' => 50],
            //[['phone'], 'string', 'max' => 20],
            //[['city'], 'string', 'max' => 30],
            //[['goods_bill_comment'], 'string', 'max' => 1000],
            //[['comment', 'comment_fin'], 'string', 'max' => 3000],
            //[['units'], 'string', 'max' => 10],
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
            '$responsible_user_id' => 'Ответственный',
            'ext_id' => 'Ext ID',
            'created_at' => 'Добавлено',
            'client_name' => 'Имя/Фамилия',
            'phone' => 'Телефон',
            'city' => 'Город',
            'total_amount' => 'Бюджет финальный',
            'first_payment_amount' => '1-я оплата',
            'first_payment_status' => 'First Payment Status',
            'first_payment_method' => 'Как внесли 1-ю оплату',
            'first_payment_date' => 'Дата 1-й оплаты',
            'second_payment_amount' => '2-я оплата',
            'second_payment_status' => 'Second Payment Status',
            'second_payment_method' => 'Как внесли 2-ю оплату',
            'second_payment_date' => 'Дата 2-й оплаты',
            'registry_check' => 'Registry Check',
            'goods_bill_num' => 'Номер ТТН',
            'goods_bill_date' => 'Дата ТТН',
            'goods_bill_comment' => 'Комментарий',
            'comment' => 'Комментарий',
            'comment_fin' => 'Комментарий',
            'collection' => 'Коллекция',
            'count' => 'Количество',
            'units' => 'Единицы',
            'deadline' => 'Deadline',
            'finished_at' => 'Успешно реализовано', // когда
            'first_payment_valid' => 'First Payment Valid',
            'second_payment_valid' => 'Second Payment Valid',
        ];
    }


    /**
     * @param $column
     * @return string
     */
    public static function getLabel($column)
    {
        $labels = (new self())->attributeLabels();
        if (isset($labels[$column])) {
            return $labels[$column];
        }
        return $column;
    }


    public static function paymentMethods()
    {
        return [
            self::METHOD_YANDEX => 'Эквайринг',
            self::METHOD_CARD => 'Карта (НПК)',
            self::METHOD_BSO => 'БСО',
            self::METHOD_CASH => 'Нал',
            self::METHOD_BANK_RS => 'Р/C',
            self::METHOD_BANK => 'Отдел. банка',
        ];
    }


    public static function convertAmoMethod($enumId)
    {
        $relations = [
            Amo::ENUM_PAYMENT_YANDEX => self::METHOD_YANDEX,
            Amo::ENUM_PAYMENT_CARD => self::METHOD_CARD,
            Amo::ENUM_PAYMENT_BSO => self::METHOD_BSO,
            Amo::ENUM_PAYMENT_CASH => self::METHOD_CASH,
            Amo::ENUM_PAYMENT_BANK_RS => self::METHOD_BANK_RS,
            Amo::ENUM_PAYMENT_BANK => self::METHOD_BANK,

            Amo::ENUM_PAYMENT_2_YANDEX => self::METHOD_YANDEX,
            Amo::ENUM_PAYMENT_2_CARD => self::METHOD_CARD,
            Amo::ENUM_PAYMENT_2_BSO => self::METHOD_BSO,
            Amo::ENUM_PAYMENT_2_CASH => self::METHOD_CASH,
            Amo::ENUM_PAYMENT_2_BANK_RS => self::METHOD_BANK_RS,
            Amo::ENUM_PAYMENT_2_BANK => self::METHOD_BANK,
        ];
        return isset($relations[$enumId]) ? $relations[$enumId] : 0;
    }


    public static function getMethodLabel($typeKey)
    {
        $titles = self::paymentMethods();
        return isset($titles[$typeKey]) ? $titles[$typeKey] : '';
    }


    public static function ttnComments()
    {
        return [
            '---' => '---',
            'Заполнено правильно' => 'Заполнено правильно',
            'Нет расшифровки' => 'Нет расшифровки',
            'Нет подписи' => 'Нет подписи',
            'Расписался другой' => 'Расписался другой',
            'Ушло в другой город' => 'Ушло в другой город',
        ];
    }


    /**
     * Relation to Payment model
     * @return \yii\db\ActiveQuery
     */
    public function getPayments()
    {
        return $this->hasMany(Payment::className(), ['ext_id' => 'ext_id']);
    }


    /**
     * Relation to Payment model
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(LeadStatus::className(), ['ext_id' => 'lead_status']);
    }


    /**
     * Checking payment
     * @param $num integer номер оплаты (1-2)
     * @return string
     */
    public function getColor($num)
    {
        $fieldMethod = ($num == 2) ? 'second_payment_method' : 'first_payment_method';
        $fieldSum = ($num == 2) ? 'second_payment_amount' : 'first_payment_amount';
        $fieldDate = ($num == 2) ? 'second_payment_date' : 'first_payment_date';
        $fieldStatus = ($num == 2) ? 'second_payment_status' : 'first_payment_status';
        $fieldValid = ($num == 2) ? 'second_payment_valid' : 'first_payment_valid';
        $color = '';
        if ($this->{$fieldMethod} == Money::METHOD_YANDEX) {
            $color = 'red';
            foreach ($this->payments as $payment) { /* @var $payment Payment */
                if ($payment->pnum == $num && $payment->status == Payment::STATUS_PAID) {
                    $color = ($this->{$fieldValid} && $this->{$fieldSum} == $payment->sum) ? 'green' : 'red';
                }
            }
        } else {
            if ($this->{$fieldStatus} == 1) {
                $color = $this->{$fieldValid} ? 'green' : 'red';
            }
        }
        // проверяем в каком месяце был платеж, если в прошлом, то
        $year = date('Y');
        $month = date('m');
        if (!empty($_GET['date_period'])) {
            $period = explode('-', $_GET['date_period']);
            $month = substr('0' . $period[0], -2, 2);
            $year = $period[1];
        }
        if(date('Y', $this->{$fieldDate}) == $year && date('m', $this->{$fieldDate}) != $month) {
            $color = 'gray';
        }

        return $color;
    }


    /**
     * Prepares values of attributes for "money/index" view
     */
    public function prepareColumnsValues()
    {
        $values = $this->getAttributes();
        foreach ($values as $key => $val) {
            if ($values == 0) {
                $values[$key] = '';
            }
        }
        $values['responsible_user_id'] = empty($this->responsible_user_id) ? '' : $this->responsible_user_id;
        $values['total_amount'] = number_format($this->total_amount, 0, ',', ' ');
        $values['first_payment_amount'] = number_format($this->first_payment_amount, 0, ',', ' ');
        $values['second_payment_amount'] = number_format($this->second_payment_amount, 0, ',', ' ');
        $values['first_payment_method'] = Money::getMethodLabel($this->first_payment_method);
        $values['second_payment_method'] = Money::getMethodLabel($this->second_payment_method);
        $values['first_payment_date'] = empty($this->first_payment_date) ? '' : date('d.m.y', $this->first_payment_date);
        $values['second_payment_date'] = empty($this->second_payment_date) ? '' : date('d.m.y', $this->second_payment_date);
        $values['goods_bill_num'] = empty($this->goods_bill_num) ? '' : $this->goods_bill_num;
        $values['units'] = empty($this->units) ? 'шт.' : $this->units;
        $values['deadline'] = empty($this->deadline) ? '' : date('d.m.y', $this->deadline);
        $values['finished_at'] = empty($this->finished_at) ? '' : date('d.m.y', $this->finished_at);
        // bill date
        $key = empty($this->goods_bill_date) ? '' : $this->id.'_'.$this->goods_bill_num;
        $url = ($key) ? Url::toRoute(['money/waybill', 'num' => $key]) : '';
        $values['goods_bill_date'] = empty($this->goods_bill_date) ? '' : date('d.m.y', $this->goods_bill_date);
        $values['goods_bill_date'] = '<a href="' . $url . '" title="" class="hidden-link" target="_blank">'
            . $values['goods_bill_date'] . '</a>';
        $values['count'] = empty($this->count) ? '1' : $this->count;

        // Источники
        foreach ([Money::METHOD_YANDEX, Money::METHOD_CARD, Money::METHOD_BSO, Money::METHOD_CASH, Money::METHOD_BANK] as $method) {
            $total = 0;
            if ($this->first_payment_method == $method) {
                $total += intval($this->first_payment_amount);
            }
            if ($this->second_payment_method == $method) {
                $total += intval($this->second_payment_amount);
            }
            $values['payment_amount_' . $method] = number_format($total, 0, ',', ' ');
        }

        // данные из эквайринга
        $values['yandex_1_amount'] = $values['yandex_2_amount'] = $values['yandex_1_date'] = $values['yandex_2_date'] = '';
        if ($this->payments) {
            foreach ($this->payments as $payment) { /* @var $payment Payment */
                if ($payment->pnum == 1 && $payment->status == Payment::STATUS_PAID) {
                    $values['yandex_1_amount'] = number_format($payment->sum, 0, ',', ' ');
                    $values['yandex_1_date'] = date('d.m.y', $payment->paid_at);
                }
                if ($payment->pnum == 2 && $payment->status == Payment::STATUS_PAID) {
                    $values['yandex_2_amount'] = number_format($payment->sum, 0, ',', ' ');
                    $values['yandex_2_date'] = date('d.m.y', $payment->paid_at);
                }
            }
        }

        // планирование
        $values['payments_before'] = $values['payments_present'] = $values['payments_next'] = '';
        $days = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
        $fromDate = strtotime(date('Y-m-01 00:00:00'));
        $toDate = strtotime(date('Y-m-' . $days . ' 23:59:59'));
        // предыдущий месяц
        $total = 0;
        if ($this->first_payment_date > 0 && $this->first_payment_date < $fromDate) {
            $total += intval($this->first_payment_amount);
        }
        if ($this->second_payment_date > 0 &&  $this->second_payment_date < $fromDate) {
            $total += intval($this->second_payment_amount);
        }
        $values['payments_before'] = number_format($total, 0, ',', ' ');
        // текущий месяц
        $total = 0;
        if ($this->total_amount > 0 && $this->deadline <= $toDate && $this->deadline >= $fromDate) {
            $total = $this->total_amount - $this->first_payment_amount;
            if ($this->second_payment_date > 0 &&  $this->second_payment_amount > 0) {
                $total -= $this->second_payment_amount;
            }
        }
        $values['payments_present'] = number_format($total, 0, ',', ' ');
        // в след месяце
        $total = 0;
        if ($this->total_amount > 0 && $this->deadline > $toDate) {
            $total = $this->total_amount - $this->first_payment_amount;
            if ($this->second_payment_date > 0 &&  $this->second_payment_amount > 0) {
                $total -= $this->second_payment_amount;
            }
        }
        $values['payments_next'] = number_format($total, 0, ',', ' ');

        return $values;
    }


    /**
     * Create TTN (товарная накладная, по сути просто номер и дата)
     * @return string TTN number
     */
    public function createTTN()
    {
        $maxNum = Money::find()->select(['MAX(goods_bill_num) AS goods_bill_num'])->one();
        $maxNum = $maxNum->goods_bill_num + 1;
        $this->goods_bill_num = $maxNum;
        $this->goods_bill_date = time();
        return $this->save() ? $maxNum : false;
    }


    /**
     * Load data from amo
     * @param array $lead
     * @return bool|Money
     */
    public static function createFromAmo($lead)
    {
        $money = Money::findOne(['ext_id' => $lead['id']]);
        if (!$money) {
            $money = new Money();
            $money->ext_id = intval($lead['id']);
            $money->created_at = time();
            $money->count = 1;
            $money->units = 'шт.';
        }
        $money->updateFromAmo($lead);
        $money->save();
        return $money;
    }


    /**
     * Update fields from lead
     * @param $lead
     * @param bool $dontChangeVerify
     */
    public function updateFromAmo($lead, $dontChangeVerify = false)
    {
        // todo было бы лучше эту часть вынести из модели
        // обновляем имя клиента



        $amo = new Amo(\Yii::$app->params);
        if ($amo->getErrorCode() == 0) {
            $contact = $amo->getContactByLead($lead['id']);
            if (!empty($contact)) {
                $this->client_name = !empty($contact['company_name'])
                    ? $contact['company_name'] : (!empty($contact['name']) ? $contact['name'] : '--нет имени--');
                $this->responsible_user_id = $contact['responsible_user_id'];
                foreach ($contact['custom_fields'] as $cf) {
                    if ($cf['id'] == Amo::USER_FIELD_CITY) {
                        $this->city = mb_substr($cf['values'][0]['value'], 0, 30, 'utf8');
                    }
                    if ($cf['id'] == Amo::USER_FIELD_PHONE) {
                        $this->phone = $cf['values'][0]['value'];
                    }
                }
            }
        }

        // статус сделки
        $this->lead_status = $lead['status_id'];

        // прочие поля (custom fields)
        // TODO удалить следующие три строки после ответа техподдержки АМО
        if ($this->first_payment_status == 0) {
            $this->first_payment_amount = 0;
        }
        if ($this->second_payment_status == 0) {
            $this->second_payment_amount = 0;
        }
        $this->comment_fin = '';
        if (!empty($lead['custom_fields'])) {
            foreach ($lead['custom_fields'] as $cf) {
                // обновляем поля, за исключением тех, которые уже фиксированны
                if ($cf['id'] == Amo::FIELD_COLLECTION) {
                    // коллекция
                    $this->collection = $cf['values'][0]['value'];
                } else if ($cf['id'] == Amo::FIELD_DEADLINE) {
                    // срок
                    if (isset($cf['values'][0]['value'])) {
                        $this->deadline = strtotime($cf['values'][0]['value']);
                    } else {
                        $this->deadline = intval($cf['values'][0]);
                    }
                } else if ($cf['id'] == Amo::FIELD_FINAL_AMOUNT) {
                    // бюджет финальный
                    $this->total_amount = floatval($cf['values'][0]['value']);
                } else if ($cf['id'] == Amo::FIELD_COMMENT_FIN) {
                    // комментарий бюджета
                    $this->comment_fin = $cf['values'][0]['value'];
                } else if ($cf['id'] == Amo::FIELD_FIRST_PAYMENT_AMOUNT) {
                    // сумма предоплаты
                    $amount = floatval($cf['values'][0]['value']);
                    if ($this->first_payment_status == 0) { // если галочкой не отмечено, то сумму можно менять
                        $this->first_payment_amount = $amount;
                        $this->first_payment_valid = 1;
                    } else {
                        if ($amount != $this->first_payment_amount) {
                            $this->first_payment_valid = 0;
                        }
                    }
                } else if ($cf['id'] == Amo::FIELD_FIRST_PAYMENT_METHOD && $this->first_payment_status == 0) {
                    // метод оплаты 1
                    $this->first_payment_method = Money::convertAmoMethod($cf['values'][0]['enum']);
                } else if ($cf['id'] == Amo::FIELD_FIRST_PAYMENT_DATE && $this->first_payment_status == 0) {
                    // дата первой оплаты
                    if (isset($cf['values'][0]['value'])) {
                        $this->first_payment_date = strtotime($cf['values'][0]['value']); // 2016-08-30 00:00:00
                    } else {
                        $this->first_payment_date = intval($cf['values'][0]);
                    }
                } else if ($cf['id'] == Amo::FIELD_SECOND_PAYMENT_METHOD && $this->second_payment_status == 0) {
                    // метод оплаты 2
                    $this->second_payment_method = Money::convertAmoMethod($cf['values'][0]['enum']);
                } else if ($cf['id'] == Amo::FIELD_SECOND_PAYMENT_DATE && $this->second_payment_status == 0) {
                    // дата второй оплаты
                    if (isset($cf['values'][0]['value'])) {
                        $this->second_payment_date = strtotime($cf['values'][0]['value']); // 2016-08-30 00:00:00
                    } else {
                        $this->second_payment_date = intval($cf['values'][0]);
                    }
                } else if ($cf['id'] == Amo::FIELD_SECOND_PAYMENT_AMOUNT) {
                    // сумма второй оплаты
                    $amount = floatval($cf['values'][0]['value']);
                    if ($this->second_payment_status == 0) {
                        $this->second_payment_amount = $amount;
                        $this->second_payment_valid = 1;
                    } else {
                        if ($amount != $this->second_payment_amount) {
                            $this->second_payment_valid = 0;
                        }
                    }
                } else if ($cf['id'] == Amo::FIELD_UNITS) {
                    // единицы
                    if ($cf['values'][0]['enum'] == Amo::ENUM_UNITS_PAIR) {
                        $this->units = 'пара';
                    } else {
                        $this->units = 'шт.';
                    }
                } else if ($cf['id'] == Amo::FIELD_COUNT) {
                    // количество
                    $count = intval($cf['values'][0]['value']);
                    $this->count = ($count > 0) ? $count : 1;
                }
            }
        }
    }


    /**
     * @param float|int|string $number
     * @param bool $asPrice Установить в FALSE если это не цена (дробная часть не будет учитываться)
     * @return string
     */
    public static function amountToStr($number, $asPrice = true)
    {
        $words = array(
            'null' => 'ноль',
            0 => '', 1 => 'один', 2 => 'два', 3 => 'три', 4 => 'четыре', 5 => 'пять', 6 => 'шесть', 7 => 'семь',
            8 => 'восемь', 9 => 'девять', '_0' => '', '_1' => 'одна', '_2' => 'две', '_3' => 'три', '_4' => 'четыре',
            '_5' => 'пять', '_6' => 'шесть', '_7' => 'семь', '_8' => 'восемь', '_9' => 'девять',
            11 => 'одиннадцать', 12 => 'двенадцать', 13 => 'тринадцать', 14 => 'четырнадцать', 15 => 'пятнадцать',
            16 => 'шестнадцать', 17 => 'семнадцать', 18 => 'восемнадцать', 19 => 'девятнадцать',
            10 => 'десять', 20 => 'двадцать',30 => 'тридцать', 40 => 'сорок', 50 => 'пятьдесят', 60 => 'шестьдесят',
            70 => 'семьдесят', 80 => 'восемьдесят', 90 => 'девяносто',
            100 => 'сто', 200 => 'двести', 300 => 'триста', 400 => 'четыреста', 500 => 'пятьсот', 600 => 'шестьсот',
            700 => 'семьсот', 800 => 'восемьсот', 900 => 'девятьсот',
            '1_1' => ' тысяча', '1_2' => ' тысячи', '1_5' => ' тысяч',
            '2_1' => ' миллион', '2_2' => ' миллиона', '2_5' => ' миллионов',
            '3_1' => ' миллиард', '3_2' => ' миллиарда', '3_5' => ' миллиардов',
            '0_1' => '', '0_2' => '', '0_5' => '', '4_1' => '', '4_2' => '', '4_5' => '', '5_1' => '', '5_2' => '', '5_5' => '',
            'r1' => ' рубль', 'r2' => ' рубля', 'r5' => ' рублей', 'cp' => 'коп.'
        );
        $number = str_replace(',', '.', '' . floatval($number));
        $number = explode('.', $number);
        $kop = substr((isset($number[1]) ? $number[1].'00' : '00'), 0, 2);
        $number = $number[0];
        if (intval($number) == 0) {
            $result = $words['null'];
        } else {
            $parts = str_split($number, 3);
            while (strlen($parts[count($parts) - 1]) < 3) {
                $number = '0' . $number;
                $parts = str_split($number, 3);
            }
            $parts = array_reverse($parts);
            foreach ($parts as $key => $part) {
                $val = intval(substr($part, -2, 2));
                if ($val > 10 && $val < 20) {
                    $label = $key . '_5';
                    $string = $words[$val];
                    $val = intval($part) - $val;
                    $string = $words[$val] . ' ' . $string;
                } else {
                    list($a, $b, $c) = str_split($part);
                    $a *= 100;
                    $b *= 10;
                    $c *= 1;
                    $string = trim($words[$a] . ' ' . $words[$b] . ' ' . $words[($key == 1 ? '_' . $c : $c)]);
                    $label = $key . (($c == 1) ? '_1' : (($c > 1 && $c < 5) ? '_2' : '_5'));
                }
                $string .= $words[$label];
                $parts[$key] = trim($string);
            }
            $parts = array_reverse($parts);
            $result = implode(' ', $parts);
        }
        if ($asPrice) {
            $c = intval(substr($number, -1, 1));
            $label = (($c == 1) ? 'r1' : (($c > 1 && $c < 5) ? 'r2' : 'r5'));
            $result .= $words[$label] . ' ' . $kop . ' ' . $words['cp'];
        }
        return $result;
    }


}
