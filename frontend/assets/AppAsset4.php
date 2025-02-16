<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset4 extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/adminlte.min.css',
        'css/sweetalert2-theme-bootstrap-4.css',
        'css/toastr.min.css',


    ];
    public $js = [

        'js/adminlte.min.js',
        'js/bootstrap.bundle.min.js',
        'js/jquery.min.js',
        'js/sweetalert2.min.js',
        'js/toastr.min.js',

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}
