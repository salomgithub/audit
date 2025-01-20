<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset3 extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'main/css/style.css',
        "main/vendor/bootstrap/css/bootstrap.min.css",
        "main/vendor/bootstrap-icons/bootstrap-icons.css",
        "main/vendor/boxicons/css/boxicons.min.css",
        "main/vendor/quill/quill.snow.css",
        "main/vendor/quill/quill.bubble.css",
        "main/vendor/remixicon/remixicon.css",
        "main/vendor/simple-datatables/style.css",

    ];
    public $js = [
        'main/vendor/bootstrap/js/bootstrap.bundle.min.js',
        'main/js/main.js',
        'js/script.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}
