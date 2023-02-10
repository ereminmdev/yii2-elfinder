<?php

namespace ereminmdev\yii2\elfinder;

use elFinderConnector;
use Exception;
use Yii;
use yii\base\Action;

/**
 * Class ElfinderAction
 * @package ereminmdev\yii2\elfinder
 */
class ElfinderAction extends Action
{
    /**
     * @throws Exception
     */
    public function run()
    {
        $bundle = ElfinderBaseAsset::register(Yii::$app->view);
        $iconUrl = $bundle->baseUrl . '/img/volume_icon_local.png';

        $dir = Yii::getAlias('@vendor/studio-42/elfinder/php/');
        include_once $dir . 'elFinderConnector.class.php';
        include_once $dir . 'elFinder.class.php';
        include_once $dir . 'elFinderVolumeDriver.class.php';
        include_once $dir . 'elFinderVolumeLocalFileSystem.class.php';

        $basePath = Yii::getAlias('@frontend/web');
        $baseUrl = Yii::$app->has('urlManagerFrontend') ? Yii::$app->urlManagerFrontend->baseUrl : Yii::$app->urlManager->baseUrl;

        // https://github.com/Studio-42/elFinder/wiki/Connector-configuration-options
        $opts = array(
            'debug' => YII_ENV_DEV,
            'roots' => [
                [
                    'driver' => 'LocalFileSystem',
                    'path' => $basePath . '/files', //Yii::getAlias('@webroot/files'),
                    'URL' => $baseUrl . '/files', //Yii::getAlias('@web/files'),
                    'alias' => Yii::t('app', 'Files'),
                    'icon' => $iconUrl,
                    'tmbPath' => $basePath . '/files/temp/elfinder/tmb',
                    'tmbURL' => $baseUrl . '/files/temp/elfinder/tmb', //Yii::getAlias('@web/files/temp/elfinder/tmb'),
                    'tmpPath' => '',
                    'uploadOverwrite' => false,
                    'attributes' => [
                        [
                            'pattern' => '/\.gitignore/',
                            'read' => false,
                            'write' => false,
                            'hidden' => true,
                            'locked' => true,
                        ],
                        [
                            'pattern' => '/\.htaccess/',
                            'read' => false,
                            'write' => false,
                            'hidden' => true,
                            'locked' => true,
                        ],
                        [
                            'pattern' => '/temp/',
                            'read' => false,
                            'write' => false,
                            'hidden' => true,
                            'locked' => true,
                        ],
                    ],
                ],
                [
                    'driver' => 'LocalFileSystem',
                    'path' => Yii::getAlias('@frontend/web'),
                    'URL' => $baseUrl . '/', //Yii::getAlias('@web'),
                    'alias' => Yii::t('app', 'Site'),
                    'icon' => $iconUrl,
                    'tmbPath' => $basePath . '/files/temp/elfinder/tmb',
                    'tmbURL' => $baseUrl . '/files/temp/elfinder/tmb', //Yii::getAlias('@web/files/temp/elfinder/tmb'),
                    'tmpPath' => '',
                    'uploadOverwrite' => false,
                    'attributes' => [
                        [
                            'pattern' => '/\.gitignore/',
                            'read' => false,
                            'write' => false,
                            'hidden' => true,
                            'locked' => true,
                        ],
                        [
                            'pattern' => '/\.htaccess/',
                            'read' => false,
                            'write' => false,
                            'hidden' => true,
                            'locked' => true,
                        ],
                        [
                            'pattern' => '/temp/',
                            'read' => false,
                            'write' => false,
                            'hidden' => true,
                            'locked' => true,
                        ],
                        [
                            'pattern' => '/\.php$/',
                            'read' => false,
                            'write' => false,
                            'hidden' => true,
                            'locked' => true,
                        ],
                    ],
                ],
            ],
        );

        @mkdir($basePath . '/files/temp/elfinder', 0777, true);

        $connector = new elFinderConnector(new \elFinder($opts));
        $connector->run();
    }
}
