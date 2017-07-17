<?php

namespace app\assets;

use yii\web\AssetBundle;


class AirAsset extends AssetBundle
{
    public $sourcePath = '@bower/air-datepicker/dist';

    public $css = [
        'css/datepicker.min.css',
    ];

    public $js = [
        'js/datepicker.min.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];
}
