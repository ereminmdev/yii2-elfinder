<?php

namespace ereminmdev\yii2\elfinder;

use yii\web\AssetBundle;

class ElfinderAsset extends AssetBundle
{
    public $sourcePath = '@vendor/ereminmdev/yii2-elfinder/assets';

    public $css = [
        'css/elfinder.tinymce.theme.css',
    ];

    public $depends = [
        'ereminmdev\yii2\elfinder\ElfinderBaseAsset',
    ];
}
