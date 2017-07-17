<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/font-awesome-4.6.3/css/font-awesome.min.css',
        'css/common.css',
    ];

    public $js = [
        'js/jquery.tooltipster.min.js',
        'js/site.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'app\assets\AirAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
