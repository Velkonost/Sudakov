<?php
/**
 * Application configuration for unit tests
 */
return yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../../config/web.php'),
    require(__DIR__ . '/config.php'),
    [
        'id' => 'app-console',
        'class' => 'yii\console\Application',
        'basePath' => \Yii::getAlias('@tests'),
        'runtimePath' => \Yii::getAlias('@tests/_output'),
        'bootstrap' => [],
        'components' => [
            'db' => [
                'class' => '\yii\db\Connection',
                'dsn' => 'sqlite:'.\Yii::getAlias('@tests/_output/temp.db'),
                'username' => '',
                'password' => '',
            ]
        ]
    ]
);
