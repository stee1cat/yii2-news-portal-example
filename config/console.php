<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');
$services = require(__DIR__ . '/services.php');

$config = [
    'id' => 'basic-console',
    'language' => 'ru',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'components' => array(
        'cache' => array(
            'class' => 'yii\caching\FileCache',
        ),
        'log' => array(
            'targets' => array(
                array(
                    'class' => 'yii\log\FileTarget',
                    'levels' => array('error', 'warning'),
                ),
            ),
        ),
        'db' => $db,
    ),
    'params' => $params,
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

$config['components'] = array_merge($config['components'], $services);

return $config;
