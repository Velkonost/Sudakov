<?php

namespace app\assets;

use yii\web\AssetBundle;


class ManagerAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        "css/main-page.css",
        "css/manager.css",
    ];

    public $js = [
        "/js/bootstrap.js",
        "/js/manager.js",

    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
