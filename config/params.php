<?php

$_subdomain = explode('.', @$_SERVER['HTTP_HOST']);
$_subdomain = count($_subdomain) >= 3 ? $_subdomain[0] : '';

return [
    'adminEmail' => 'admin@example.com',
    'amoSubdomain' => 'jbyss', // домен с которого мы принимаем данные
    'amoLogin' => 'contact@sudakovsergey.com',
    'amoToken' => 'ec218359cdab51d37019342a309b8dad', #Хэш для доступа к API (смотрите в профиле пользователя)
    'amoLogPath' => dirname(__FILE__) . '/../logs/',
    'amoLogToDate' => strtotime('2016-12-30 00:00:00'), // дата, до которой будут писаться логи по запросам из amo
    'subdomain' => $_subdomain,
    // Test account
    //'amoSubdomain' => 'activeprogramming',
    //'amoLogin' => 'pavel@act-prog.ru',
    //'amoToken' => '802d23dc37eec73fc78328a63472c15f',

    // путь к старым платежкам
    'old_payments_path' => dirname(__FILE__) . '/../../sergeysudakov.ru/payment/orders_archive',

    // платежки
    // Пароли со страницы технических настроек магазина (требовались для настройки страниц ответов)
    // Пароль1: vw0v6jtyu0
    // Пароль2: c8gjkd450
    'yandex' => [
        'shopDoc' => 'jbyss@yandex.ru',
        'shopID' => '31132',
        'cSID' => '22619',
        'password' => 'DjfdoYEOS845jfsf74lm',
        'paymentUrl' => 'https://money.yandex.ru/eshop.xml',
        'gateways' => [
            'AC' => 'Банковской карты',
            'PC' => 'Из кошелька в Яндекс.Деньгах',
            //'MC' => 'Платеж со счета мобильного телефона',
            'GP' => 'Наличными через кассы и терминалы',
            //'WM' => 'Из кошелька в системе WebMoney',
            //'SB' => 'Через Сбербанк: оплата по SMS или Сбербанк Онлайн',
            //'MP' => 'Через мобильный терминал (mPOS)',
            'AB' => 'Через Альфа-Клик',
            //'МА' => 'Через MasterPass',
            //'PB' => 'Через Промсвязьбанк'
        ]
    ],

    'instagram' => [
        'login' => 'Sudakov.jewellery',
        'password' => 'suprasadadas1',
    ]
];
