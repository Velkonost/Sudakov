<?php

namespace app\assets;

use yii\web\AssetBundle;


class SiteAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        "css/main-page.css",
    ];

    public $js = [
        "/js/bootstrap.js",
        "/js/main-page.js",

    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
