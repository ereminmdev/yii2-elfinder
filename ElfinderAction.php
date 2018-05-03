<?php

namespace ereminmdev\yii2\elfinder;

use Yii;
use yii\base\Action;

/**
 * Class ElfinderAction
 * @package ereminmdev\yii2\elfinder
 */
class ElfinderAction extends Action
{
    public function run()
    {
        $bundle = ElfinderBaseAsset::register(Yii::$app->view);
        $iconUrl = $bundle->baseUrl . '/img/volume_icon_local.png';

        $dir = Yii::getAlias('@vendor/studio-42/elfinder/php/');
        include_once $dir . 'elFinderConnector.class.php';
        include_once $dir . 'elFinder.class.php';
        include_once $dir . 'elFinderVolumeDriver.class.php';
        include_once $dir . 'elFinderVolumeLocalFileSystem.class.php';

        $basePath = Yii::$app->urlManagerFrontend->getBaseUrl();

        // Documentation for connector options:
        // https://github.com/Studio-42/elFinder/wiki/Connector-configuration-options
        $opts = array(
            'debug' => YII_ENV_DEV,
            'roots' => [
                [
                    'driver' => 'LocalFileSystem',
                    'path' => Yii::getAlias('@frontend/web/files'),//Yii::getAlias('@webroot/files'),
                    'URL' => $basePath . '/files',//Yii::getAlias('@web/files'),
                    'alias' => Yii::t('app', 'Files'),
                    'icon' => $iconUrl,
                    'tmbPath' => Yii::getAlias('@frontend/web/files/.temp/elfinder/.tmb'),
                    'tmbURL' => $basePath . '/files/.temp/elfinder/.tmb',//Yii::getAlias('@web/files/.temp/elfinder/.tmb'),
                    'tmpPath' => '',
                    'quarantine' => Yii::getAlias('@frontend/web/files/.temp/elfinder/.quarantine'),
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
                            'pattern' => '/\.temp/',
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
                    'URL' => $basePath . '/',//Yii::getAlias('@web'),
                    'alias' => Yii::t('app', 'Site'),
                    'icon' => $iconUrl,
                    'tmbPath' => Yii::getAlias('@frontend/web/files/.temp/elfinder/.tmb'),
                    'tmbURL' => $basePath . '/files/.temp/elfinder/.tmb',//Yii::getAlias('@web/files/.temp/elfinder/.tmb'),
                    'tmpPath' => '',
                    'quarantine' => Yii::getAlias('@frontend/web/files/.temp/elfinder/.quarantine'),
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
                            'pattern' => '/\.temp/',
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

        @mkdir(Yii::getAlias('@frontend/web/files/.temp/elfinder'), 0777, true);

        // run elFinder
        $connector = new \elFinderConnector(new \elFinder($opts));
        $connector->run();
    }
}
