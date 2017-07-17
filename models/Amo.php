<?php
/**
 *
 */

namespace app\models;


class Amo
{
    const LEAD_ACCOUNT = '723567'; // ID аккаунта под которым проводятся операции

    // только некоторые необходимые статусы. Остальные коды статусов хранятся в таблице lead_status
    // и периодически обновляются. self::reloadStatusesList()
    const STATUS_NEW_LEAD = '7633870'; // новая заявка
    const STATUS_COMPLETED = '142'; // Успешно реализовано
    const STATUS_FAILED = '143'; // Закрыто и не реализовано
    const STATUS_TEST = '11282800';
    const STATUS_FACTORY_BEGIN = '10308990'; //Статус сделки "Начало производства"
    const STATUS_SHIPPING = '8551408'; // на доставке
    const STATUS_PRODUCT_DONE = '10308993'; // изделие готово

    // AMO Lead custom fields ids
    const FIELD_ROISTAT = '1286186';
    const FIELD_PAYLINK_1 = '1284916';
    const FIELD_PAYLINK_2 = '1286484';
    const FIELD_DEADLINE = '952428';
    const FIELD_COMMENT = '1286130';
    const FIELD_COUNT = '1286745';
    const FIELD_UNITS = '1286743';
    const ENUM_UNITS_PIECE = '2958251'; // шт.
    const ENUM_UNITS_PAIR = '2958253'; // пара
    const FIELD_FINAL_AMOUNT = '1286480';
    const FIELD_FIRST_PAYMENT_AMOUNT = '952452';
    const FIELD_FIRST_PAYMENT_DATE = '1286555';
    const FIELD_FIRST_PAYMENT_METHOD = '1284916';
    const FIELD_SECOND_PAYMENT_AMOUNT = '1286482';
    const FIELD_SECOND_PAYMENT_DATE = '1286557';
    const FIELD_SECOND_PAYMENT_METHOD = '1286484';
    const ENUM_PAYMENT_CASH = '2958191';
    const ENUM_PAYMENT_YANDEX = '2958175';
    const ENUM_PAYMENT_CARD = '2958173';
    const ENUM_PAYMENT_BSO = '2958171';
    const ENUM_PAYMENT_BANK = '2958181';
    const ENUM_PAYMENT_BANK_RS = '2958177';
    const ENUM_PAYMENT_2_CASH = '2958191';
    const ENUM_PAYMENT_2_YANDEX = '2958187';
    const ENUM_PAYMENT_2_CARD = '2958185';
    const ENUM_PAYMENT_2_BSO = '2958183';
    const ENUM_PAYMENT_2_BANK = '2958193';
    const ENUM_PAYMENT_2_BANK_RS = '2958189';
    const FIELD_COMMENT_R = '1286486';
    const FIELD_COLLECTION = '1286504';
    const FIELD_COMMENT_FIN = '1286502'; // комментарий из финансового блока сделки

    const FIELD_SKETCH1 = '952534'; // поле "1-й эскиз"
    const FIELD_SKETCH2 = '1286453'; // поле "2-й эскиз"
    const FIELD_PLAN_DXF1 = '1286451'; // поле "1-й план DXF"
    const FIELD_PLAN_DXF2 = '1286457'; // поле "2-й план DXF"
    const FIELD_PLAN_AI1 = '952594'; // поле "1-й план AI"
    const FIELD_PLAN_AI2 = '1286455'; // поле "2-й план AI"
    const FIELD_PLAN_DESC1 = '1284836'; // поле "1-е описание"
    const FIELD_PLAN_DESC2 = '1286459'; // поле "2-е описание"
    const FIELD_DESCRIPTION = '1286130'; // поле "Описание"
    //const ENUM_COLLECTION = ''; // no need

    // AMO Contact fields
    const USER_FIELD_CITY = '952386';
    const USER_FIELD_SOURCE = '952390';
    const USER_FIELD_PHONE = '952364';
    const USER_ENUM_PHONE_MOBILE = '2159764';
    const USER_FIELD_EMAIL = '952366';
    const USER_ENUM_EMAIL = '2159774';


    private $login = '';

    private $password = '';

    private $subdomain = '';

    private $isConnected = false;

    private $error = '';

    private $errorCode = 0;

    private $authToken = '';

    private $curl = null;


    public function getErrorCode()
    {
        return $this->errorCode;
    }

    public function getError()
    {
        return $this->error;
    }

    /**
     * Amo constructor.
     * @param array $params Keys: amoLogin, amoToken, amoSubdomain
     */
    public function __construct($params)
    {
        $this->login = $params['amoLogin'];
        $this->password = $params['amoToken'];
        $this->subdomain = $params['amoSubdomain'];
        $this->curl = curl_init();
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($this->curl, CURLOPT_HEADER, false);
        curl_setopt($this->curl, CURLOPT_COOKIEFILE, 'cookie.txt');
        curl_setopt($this->curl, CURLOPT_COOKIEJAR, 'cookie.txt');
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, 0);
        $this->connect();
    }


    /**
     * Return array of custom field by name and value
     * @param string $name Any of: roistat, phone, email, pay_link_1, pay_link_2,
     *      deadline, comment, final_amount, pay_amount_1, pay_amount_2, pay_date_1, pay_date_2,
     *      pay_method_1_cash, pay_method_1_yandex, pay_method_1_card, pay_method_1_bso, pay_method_1_bank, pay_method_1_bank_rs,
     *      pay_method_2_cash, pay_method_2_yandex, pay_method_2_card, pay_method_2_bso, pay_method_2_bank, pay_method_2_bank_rs,
     * @param string $value
     * @return array
     */
    public function getCustomField($name, $value = null)
    {
        $customFields = [
            // Contact (user)
            'phone' => ['id' => self::USER_FIELD_PHONE, 'enum' => self::USER_ENUM_PHONE_MOBILE, 'key' => 'value'], // мобильный телефон
            'email' => ['id' => self::USER_FIELD_EMAIL, 'enum' => self::USER_ENUM_EMAIL, 'key' => 'value'], // Email
            'city' => ['id' => self::USER_FIELD_CITY, 'key' => 'value'], // Email
            // Lead
            'roistat' => ['id' => self::FIELD_ROISTAT, 'key' => 'value'], // доп поле ROISTAT
            'deadline' => ['id' => self::FIELD_DEADLINE, 'key' => '0'],
            'comment' => ['id' => self::FIELD_COMMENT, 'key' => 'value'],
            'comment_fin' => ['id' => self::FIELD_COMMENT_FIN, 'key' => 'value'],
            'count' => ['id' => self::FIELD_COUNT, 'key' => 'value'],
            'units_piece' => ['id' => self::FIELD_UNITS, 'key' => 'value', 'enum' => self::ENUM_UNITS_PIECE],
            'units_pair' => ['id' => self::FIELD_UNITS, 'key' => 'value', 'enum' => self::ENUM_UNITS_PAIR],
            'final_amount' => ['id' => self::FIELD_FINAL_AMOUNT, 'key' => 'value'],
            'pay_link_1' => ['id' => self::FIELD_PAYLINK_1, 'key' => 'value'], // 'Как внесли 1-ю'
            'pay_link_2' => ['id' => self::FIELD_PAYLINK_2, 'key' => 'value'], // 'Как внесли 2-ю'
            'pay_amount_1' => ['id' => self::FIELD_FIRST_PAYMENT_AMOUNT, 'key' => 'value'], // сумма первой оплаты
            'pay_amount_2' => ['id' => self::FIELD_SECOND_PAYMENT_AMOUNT, 'key' => 'value'], // сумма первой оплаты
            'pay_date_1' => ['id' => self::FIELD_FIRST_PAYMENT_DATE, 'key' => '0'], // дата первой оплаты
            'pay_date_2' => ['id' => self::FIELD_SECOND_PAYMENT_DATE, 'key' => '0'], // дата первой оплаты
            'pay_method_1_cash' => ['id' => self::FIELD_FIRST_PAYMENT_METHOD, 'key' => 'value', 'enum' => self::ENUM_PAYMENT_CASH],
            'pay_method_1_yandex' => ['id' => self::FIELD_FIRST_PAYMENT_METHOD, 'key' => 'value', 'enum' => self::ENUM_PAYMENT_YANDEX],
            'pay_method_1_card' => ['id' => self::FIELD_FIRST_PAYMENT_METHOD, 'key' => 'value', 'enum' => self::ENUM_PAYMENT_CARD],
            'pay_method_1_bso' => ['id' => self::FIELD_FIRST_PAYMENT_METHOD, 'key' => 'value', 'enum' => self::ENUM_PAYMENT_BSO],
            'pay_method_1_bank' => ['id' => self::FIELD_FIRST_PAYMENT_METHOD, 'key' => 'value', 'enum' => self::ENUM_PAYMENT_BANK],
            'pay_method_1_bank_rs' => ['id' => self::FIELD_FIRST_PAYMENT_METHOD, 'key' => 'value', 'enum' => self::ENUM_PAYMENT_BANK_RS],
            'pay_method_2_cash' => ['id' => self::FIELD_SECOND_PAYMENT_METHOD, 'key' => 'value', 'enum' => self::ENUM_PAYMENT_2_CASH],
            'pay_method_2_yandex' => ['id' => self::FIELD_SECOND_PAYMENT_METHOD, 'key' => 'value', 'enum' => self::ENUM_PAYMENT_2_YANDEX],
            'pay_method_2_card' => ['id' => self::FIELD_SECOND_PAYMENT_METHOD, 'key' => 'value', 'enum' => self::ENUM_PAYMENT_2_CARD],
            'pay_method_2_bso' => ['id' => self::FIELD_SECOND_PAYMENT_METHOD, 'key' => 'value', 'enum' => self::ENUM_PAYMENT_2_BSO],
            'pay_method_2_bank' => ['id' => self::FIELD_SECOND_PAYMENT_METHOD, 'key' => 'value', 'enum' => self::ENUM_PAYMENT_2_BANK],
            'pay_method_2_bank_rs' => ['id' => self::FIELD_SECOND_PAYMENT_METHOD, 'key' => 'value', 'enum' => self::ENUM_PAYMENT_2_BANK_RS],
        ];
        if (!isset($customFields[$name])) {
            return null;
        }
        $custom = [
            'id' => $customFields[$name]['id'],
            'values' => []
        ];
        $key = $customFields[$name]['key'];
        if ($key == '0') {
            $custom['values'][] = $value;
        } else {
            if (isset($customFields[$name]['enum'])) {
                if ($value !== null) {
                    $custom['values'][] = ['enum' => $customFields[$name]['enum'], $key => $value];
                } else {
                    $custom['values'][] = [$key => $customFields[$name]['enum']]; // only enum value needed
                }
            } else {
                $custom['values'][] = [$key => $value];
            }
        }
        return $custom;
    }


    /**
     * Sends request
     * @param $path
     * @param null $get
     * @param null $post
     * @param bool $asPlain
     * @return bool|mixed
     */
    private function sendRequest($path, $get = null, $post = null, $asPlain = false)
    {
        $host = $link='https://'.$this->subdomain.'.amocrm.ru/' . ltrim($path, '/');
        if (!empty($post)) {
            curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, json_encode($post));
        } else {
            curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'GET');
            if (!empty($get)) {
                $host .= '?' . http_build_query($get);
            }
        }

        // логи (временно)
        $now = date('dmY_H');
        $time = date("H:i:s");
        $log = \Yii::$app->params['amoLogPath'] . "api_request_{$now}.log";
        $text = "Request {$time}\n";
        $text .= "Path: {$path}\n";
        $text .= "Post: " . var_export($post, true) . "\n\n";
        file_put_contents($log, $text, 8);

        curl_setopt($this->curl, CURLOPT_URL, $host);
        $out = curl_exec($this->curl);
        $code = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
        $code = (int)$code;
        $errors = [
            301 => 'Moved permanently',
            400 => 'Bad request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not found',
            429 => 'Too many requests. Try again later.',
            500 => 'Internal server error',
            502 => 'Bad gateway',
            503 => 'Service unavailable'
        ];
        try {
            if ($code != 200 && $code != 204) {
                if ($code == 429) {
                    // try again
                    usleep(500000); // delay 0.5 seconds
                    return $this->sendRequest($path, $get, $post);
                }
                $this->errorCode = $code;
                $this->error = isset($errors[$code]) ? $errors[$code] : 'unknown error';
                return false;
            }
        } catch(\Exception $E) {
            $this->errorCode = $E->getCode();
            $this->error = $E->getMessage();
            return false;
        }
        if ($asPlain) {
            return $out;
        }
        return json_decode($out, true);
    }


    public function connect()
    {
        if ($this->isConnected) return true;
        $link = '/private/api/auth.php?type=json';
        $userInfo = [
            'USER_LOGIN' => $this->login, #Ваш логин (электронная почта)
            'USER_HASH' => $this->password #Хэш для доступа к API (смотрите в профиле пользователя)
        ];
        $res = $this->sendRequest($link, null, $userInfo);
        if(isset($res['response']['auth'])) {
            $this->authToken = $res['response']['auth'];
            return true;
        }
        return false;
    }


    /**
     * @param string $leadId
     * @return bool|mixed
     */
    public function getLinks($leadId)
    {
        $param = ['deals_link' => [$leadId]];
        $link = '/private/api/v2/json/contacts/links';
        $res = $this->sendRequest($link, $param);
        if (isset($res['response'])) {
            return $res['response'];
        }
        return [];
    }


    /**
     * @param string $leadId
     * @return bool|mixed
     */
    public function getContactByLead($leadId)
    {
        $res = $this->getLinks($leadId);
        if (!empty($res['links'][0]['contact_id'])) {
            $link = '/private/api/v2/json/contacts/list';
            $params = [
                'id' => $res['links'][0]['contact_id'],
                'type' => 'all'
            ];
            $res = $this->sendRequest($link, $params);
            if(isset($res['response']['contacts'][0])) {
                return $res['response']['contacts'][0];
            }
        }
        return [];
    }


    /**
     * Create new contact
     * @param string $name
     * @param array $custom ['field_name' => 'value'] @see self::getCustomField($name, $value)
     *    Example: ['name' => 'FIO', 'email' => 'dddd@mmmm.com']
     * @param int $leadId
     * @return bool
     */
    public function createContact($name, $custom = [], $leadId = null)
    {
        $customFields = [];
        if (!empty($custom)) {
            foreach ($custom as $key => $value) {
                $customFields[] = $this->getCustomField($key, $value);
            }
        }
        $contact = ['name' => $name, 'custom_fields' => $customFields];
        if (!empty($leadId)) {
            $contact['linked_leads_id'] = [$leadId];
        }
        $params['request']['contacts']['add'][] = $contact;
        $link = '/private/api/v2/json/contacts/set';
        $resp = $this->sendRequest($link, null, $params);
        return $resp['response']['contacts']['add'];
    }


    /**
     * Returns contact
     * @param int $contactId
     * @return bool
     */
    public function getContact($contactId)
    {
        $param = ['id' => $contactId];
        $link = '/private/api/v2/json/contacts/list';
        $resp = $this->sendRequest($link, $param);
        return $resp['response'];
    }

    /**
     * Returns accounts
     * @return array
     */
    public function getAccounts()
    {
        $link = '/private/api/v2/json/accounts/current';
        $resp = $this->sendRequest($link);
        return $resp['response'];
    }


    /**
     * Create new lead
     * @param $name
     * @param array $custom ['field_name' => 'value'] @see self::getCustomField($name, $value)
     *      or ['field_name_enum_type', 'field_name' => 'value']
     *  Example:
     *      ['pay_method_1_bank', 'comment' => 'Hello!', 'deadline' => time()]
     *  'pay_method_1_bank' hasn't any value. It's enum type by field name. Real name of field is "pay_method_1",
     *    so "_bank" is type of enum suffix.
     * @return bool
     */
    public function createLead($name, $custom)
    {
        $customFields = [];
        if (!empty($custom)) {
            foreach ($custom as $key => $value) {
                $customFields[] = $this->getCustomField($key, $value);
            }
        }
        $leads = [
            'request' => [
                'leads' => [
                    'add' => [
                        [
                            'name' => $name,
                            'status_id' => self::STATUS_NEW_LEAD,
                            'responsible_user_id' => self::LEAD_ACCOUNT,
                            'custom_fields' => $customFields
                        ]
                    ],
                ]
            ]
        ];
        $link = '/private/api/v2/json/leads/set';
        $resp = $this->sendRequest($link, null, $leads);
        return $resp['response']['leads']['add'];
    }


    /**
     * Get lead
     * @param int $leadId
     * @return array
     */
    public function getLead($leadId)
    {
        $params = ['id' => $leadId];
        $link = '/private/api/v2/json/leads/list';
        $resp = $this->sendRequest($link, $params);
        return (isset($resp['response']['leads'][0])) ? $resp['response']['leads'][0] : [];
    }


    /**
     * Adds new comment to exists lead
     * @param int $leadId
     * @param string $comment
     * @return bool
     */
    public function addLeadComment($leadId, $comment)
    {
        $params['request']['notes']['add'][] =
            ['element_id' => $leadId, 'element_type' => 2, 'note_type' => 4, 'text' => $comment];
        $link = '/private/api/v2/json/notes/set';
        $res = $this->sendRequest($link, null, $params);
        if (isset($res['response']['notes']['add'])) {
            return $res['response']['notes']['add'];
        }
        return [];
    }


    /**
     * Set custom field
     * @param int $leadId
     * @param array $custom ['field_name' => 'value'] @see self::getCustomField($name, $value)
     *      or ['field_name_enum_type', 'field_name' => 'value']
     *  Example:
     *      ['pay_method_1_bank', 'comment' => 'Hello!', 'deadline' => time()]
     *  'pay_method_1_bank' hasn't any value. It's enum type by field name. Real name of field is "pay_method_1",
     *    so "_bank" is type of enum suffix.
     * @return array
     */
    public function setLeadCustomField($leadId, $custom)
    {
        $customFields = [];
        if (!empty($custom)) {
            foreach ($custom as $key => $value) {
                if (is_numeric($key)) {
                    $customFields[] = $this->getCustomField($value);
                } else {
                    $customFields[] = $this->getCustomField($key, $value);
                }
            }
        }
        $params['request']['leads']['update'][] = [
            'id' => $leadId,
            'custom_fields' => $customFields,
            'last_modified' => time()
        ];
        $link = '/private/api/v2/json/leads/set';
        $resp = $this->sendRequest($link, null, $params);
        return $resp['response']['leads']['update'];
    }


    /**
     * Set base field
     * @param int $leadId
     * @param array $fields ['field_name' => 'value']
     * @return array
     */
    public function setLeadField($leadId, $fields)
    {
        $data = [
            'id' => $leadId,
            'custom_fields' => [],
            'last_modified' => time()
        ];
        foreach ($fields as $field => $value) {
            $data[$field] = $value;
        }
        $params['request']['leads']['update'][] = $data;
        $link = '/private/api/v2/json/leads/set';
        $resp = $this->sendRequest($link, null, $params);
        return $resp['response']['leads']['update'];
    }


    /**
     * Load sum (amounts) from AMOCRM
     * @param $leadId
     * @return array [0 => first_amount_float, 1 => second_amount_float] OR [empty_array]
     */
    public function loadLeadAmounts($leadId)
    {
        // обновляем суммы из AMO
        $data = $this->getLead($leadId);
        if (!empty($data)) {
            if (isset($data['custom_fields'])) {
                $amounts = ['0' => 0, '1' => 0];
                $data = $data['custom_fields'];
                foreach ($data as $field) {
                    if ($field['id'] == Amo::FIELD_FIRST_PAYMENT_AMOUNT) {
                        $amounts[0] = $field['values'][0]['value'];
                    }
                    if ($field['id'] == Amo::FIELD_SECOND_PAYMENT_AMOUNT) {
                        $amounts[1] = $field['values'][0]['value'];
                    }
                }
                return $amounts;
            }
        }
        return [];
    }

    /**
     * Загружает список статусов из AMO (просто html страницу) и парсит ее, затем сохраняет в таблицу
     */
    public function reloadStatusesList()
    {
        //https://jbyss.amocrm.ru/settings/statuses/
        $statusesList = [];
        $resp = $this->sendRequest('/settings/statuses', ['get' => 1], null, true);
        // parse page
        $cnt1 = preg_match_all("/\\<input[^>].*data\\-id\\='(\\d+)'[^>]*value=\"([^\"]+)\"[^>]*\\>/Umu", $resp, $statuses);
        $cnt2 = preg_match_all("/\\<span[^>].*class=\"color-picker\"[^>]*id=\"status_(\\d+)-color-picker\"[^>]*style=\"([^\"]+)\"[^>]*\\>/Umu", $resp, $colors);
        if ($cnt1 && $cnt2) {
            foreach ($statuses[1] as $k => $code) {
                $statusesList[$code] = [
                    'ext_id' => $code,
                    'label' => $statuses[2][$k],
                    'color' => '#fff'
                ];
            }
            foreach ($colors[1] as $k => $code) {
                $color = str_replace('background-color:', '', $colors[2][$k]); // background-color: #ffff99
                $statusesList[$code]['color'] = trim($color);
            }
        }
        if (!empty($statusesList)) {
            // save or update
            foreach ($statusesList as $status) {
                $model = LeadStatus::findOne(['ext_id' => $status['ext_id']]); /* @var $model LeadStatus */
                if (!$model) {
                    $model = new LeadStatus();
                }
                $model->setAttributes($status);
                $model->save();
            }
        }
        return $statusesList;
    }

    /**
     * Get leads by IDs
     * @param array $ids
     * @return array
     */
    public function getLeads($ids)
    {
        $link = '/private/api/v2/json/leads/list';
        $resp = $this->sendRequest($link, ['id' => $ids]);
        return (isset($resp['response']['leads'][0])) ? $resp['response']['leads'] : [];

    }

    /**
     * Get all leads (by pages)
     * @param integer $page
     * @return array
     */
    public function getAllLeads($page = 0)
    {
        $link = '/private/api/v2/json/leads/list';
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, ['IF-MODIFIED-SINCE: Fri, 01 Jun 2010 00:00:00']);
        $resp = $this->sendRequest($link, ['limit_rows' => 500, 'limit_offset' => ($page * 500)]);
        return (isset($resp['response']['leads'][0])) ? $resp['response']['leads'] : [];
    }

    public function reloadManagersList()
    {
        $link = '/private/api/v2/json/accounts/current';
        $resp = $this->sendRequest($link);

        if (!isset($resp["response"]["account"]["users"])) {
            var_dump($resp, $this->errorCode, $this->error); exit;
        }

        return $resp["response"]["account"]["users"];
    }

}