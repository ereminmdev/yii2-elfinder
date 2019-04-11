<?php

namespace ereminmdev\yii2\elfinder;

use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;

/**
 * Class Elfinder
 * @package ereminmdev\yii2\elfinder
 */
class Elfinder extends Widget
{
    /**
     * @var string the language to use. Defaults to Yii::$app->language.
     */
    public $language;
    /**
     * @var array the options for the Elfinder JS plugin.
     * @see https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
     */
    public $clientOptions = [];
    /**
     * @var bool show in full size mode
     */
    public $fullSize = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->language = $this->language ?? mb_substr(Yii::$app->language, 0, 2);
        $this->language = $this->language != 'en' ? $this->language : null;

        $clientOptions = $this->clientOptions;

        $defaultOptions = [
            'url' => Url::toRoute(['/files/connector']),
            'lang' => $this->language,
            'height' => 500,
            'debug' => YII_ENV_DEV ? ['error', 'warning', 'event-destroy'] : false,
        ];

        $defaultOptions['uiOptions']['toolbar'] = !isset($clientOptions['uiOptions']['toolbar']) ? [
            ['home', 'up'],
            ['back', 'forward'],
            //['netmount'],
            //['reload'],
            ['mkdir', 'mkfile', 'upload'],
            ['open', 'download', 'getfile'],
            ['info'],
            ['quicklook'],
            ['copy', 'cut', 'paste'],
            ['rm'],
            ['duplicate', 'rename', 'edit', 'resize'],
            ['extract', 'archive'],
            ['search'],
            ['view', 'sort'],
            //['help'],
        ] : [];

        if (Yii::$app->request->enableCsrfValidation) {
            $defaultOptions['customData'][Yii::$app->request->csrfParam] = Yii::$app->request->csrfToken;
        }

        if ($this->fullSize) {
            $defaultOptions['cssClass'] = 'elfinder-fullsize';
            $defaultOptions['resizable'] = false;
        }

        $this->clientOptions = ArrayHelper::merge($defaultOptions, $clientOptions);
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->registerClientScript();

        echo '<div id="' . $this->id . '"></div>';
    }

    protected function registerClientScript()
    {
        ElfinderAsset::register($this->view);

        $this->view->registerJs("
// Keep bootstrap no conflict to buttons.
if($.fn.button.noConflict) { $.fn.btn = $.fn.button.noConflict(); }
$('#" . $this->id . "').elfinder(" . Json::encode($this->clientOptions) . ").elfinder('instance');
        ");
    }
}
