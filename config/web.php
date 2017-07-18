<?php

$params = require(__DIR__ . '/params.php');

$cookieDomain = explode('.', $_SERVER['HTTP_HOST']);
$_last = count($cookieDomain) - 1;
$cookieDomain = '.' . $cookieDomain[$_last-1] . '.' . $cookieDomain[$_last];

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 't-lnKmnKme3E8f5mZa_5ooOx4lS7NWhv',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => (is_file(__DIR__ . '/local-db.php') ? require(__DIR__ . '/local-db.php') : require(__DIR__ . '/db.php')),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'users' => 'user/index',
                'factory' => 'erp/index',
                'factory/view' => 'erp/view',
                'factory/delete' => 'erp/delete',
                'factory/update-status' => 'erp/update-status',
            ],
        ],
        'session' => [
            'cookieParams' => [
                'domain' => $cookieDomain,
                'httpOnly' => true,
            ],
        ],
        'assetManager' => [
            'appendTimestamp' => true,
        ],
    ],
    'modules' => [

    ],
    'params' => $params,
    'on beforeRequest' => function () {
        //exit("TECH");
    }
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
