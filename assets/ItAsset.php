<?php

namespace app\assets;

use yii\web\AssetBundle;


class ItAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        "css/it.css",
    ];

    public $js = [
        "/js/it.js",
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
