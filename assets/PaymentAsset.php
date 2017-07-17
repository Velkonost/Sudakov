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
class PaymentAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/payment.css',
        'css/bootstrap-multiselect.css',
    ];

    public $js = [
        'js/bootstrap-multiselect.js',
        'js/payment.js'
    ];

    public $depends = [
        'app\assets\AppAsset'
    ];
}
