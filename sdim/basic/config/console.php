<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

return [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'gii'],
    'controllerNamespace' => 'app\commands',
    'modules' => [
        'gii' => 'yii\gii\Module',
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
		'appLog' => [
			'class' => 'app\components\AppLogger',
			'logType' => 2,
			'logParams' => [
				2 => [
					'logPath' => dirname(__DIR__) . '/runtime/logs/',
					'logName' => '-daemon.log',
					'logLevel' => 3, // Take necessary value from apploger class
					'logSocket' => '',
					'isConsole' => true
				]
			]
		],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
		'util' => [
			'class' => 'app\components\Util',
		],
		'mongodb' => [
            'class' => 'yii\mongodb\Connection',
            'dsn' => DSN,
        ],
        'db' => $db,
    ],
    'params' => $params,
];
