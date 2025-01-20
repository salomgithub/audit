<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset2 extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/fonts/boxicons.css',
//        'css/core.css',
//        'css/theme-default.css',
//        'css/demo.css',
//        'css/libs/perfect-scrollbar/perfect-scrollbar.css',
//        'css/libs/apex-charts/apex-charts.css',
    ];
    public $js = [
//        'js/helpers.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
