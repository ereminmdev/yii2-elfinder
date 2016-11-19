# yii2-elfinder

Elfinder widget for Yii framework.

This widget depend on elFinder file manager: https://github.com/Studio-42/elFinder

## Install

``composer require ereminmdev/yii2-elfinder``

## Use

```
<?= Elfinder::widget([
    'language' => Yii::$app->language,
    'clientOptions' => [
        ...
    ],
    'fullSize' => false,
]) ?>
```

## Client options

https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
