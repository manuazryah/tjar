<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/fontawsome.css',
        'css/menu-style.css',
        'css/ionicons.min.css',
        'css/flag-icon.min.css',
        'css/msdropdown/dd.css',
        'css/msdropdown/skin2.css',
        'css/msdropdown/flags.css',
        'css/magiczoom.css',
        'css/style.css',
        'css/responsive.css',
    ];
    public $js = [
        'js/jquary_slim_min.js',
        'js/bootstrap.min.js',
//        'js/vendor/jquery-1.12.0.min.js',
        'js/vendor/modernizr-2.8.3.min.js',
        'js/megamenu.js',
        'js/starrating.js',
        'js/product-slider.js',
        'js/msdropdown/jquery.dd.min.js',
        'js/msdropdown/jquery.dd.js',
        'js/magiczoom.js',
//        'js/custom.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
