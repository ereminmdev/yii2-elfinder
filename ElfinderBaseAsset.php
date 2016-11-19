<?php

namespace ereminmdev\yii2\elfinder;

use yii\web\AssetBundle;

class ElfinderBaseAsset extends AssetBundle
{
    public $sourcePath = '@vendor/studio-42/elfinder';

    public $js = [
        'js/elfinder.min.js',
        'js/i18n/elfinder.ru.js',
    ];

    public $css = [
        'css/elfinder.min.css',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\jui\JuiAsset',
    ];

    public $publishOptions = [
        'except' => ['php/', '/*.*'],
        //'only' => ['css/', 'img/', '*.png', '*.gif', '*.wav'], // include JavaScript only
    ];
}
