<?php

namespace app\assets;

use yii\web\AssetBundle;


class CollectionAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        "css/main-page.css",
        "css/manager.css",
    ];

    public $js = [
        "/js/collection.js",
        "https://www.gstatic.com/charts/loader.js",
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
