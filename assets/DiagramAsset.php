<?php

namespace app\assets;

use yii\web\AssetBundle;


class DiagramAsset extends AssetBundle
{
    public $sourcePath = '@webroot';
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        '/js/jqplot/src/jquery.jqplot.css',
    ];

    public $js = [
        "/js/jqplot/src/jquery.jqplot.js",
        "/js/jqplot/src/plugins/jqplot.pieRenderer.js",
        "/js/jqplot/src/plugins/jqplot.dateAxisRenderer.js",
        "/js/jqplot/src/plugins/jqplot.cursor.js",
        "/js/jqplot/src/plugins/jqplot.highlighter.js",
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];
}
