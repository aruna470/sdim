<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
	'modules' => [
		'gii' => [
            'class' => 'yii\gii\Module',
        ],
    ],
	// 'as AccessBehavior' => [
		// 'class' => '\app\components\AccessBehavior'
	// ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '123654',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
			'class' => 'app\components\WebUser',
            'identityClass' => 'app\models\Auth',
            'enableAutoLogin' => true,
			'loginUrl' => ['site/login']
        ],
		'util' => [
			'class' => 'app\components\Util',
		],
		'appLog' => [
			'class' => 'app\components\AppLogger',
			'logType' => 1,
			'logParams' => [
				1 => [
					'logPath' => dirname(__DIR__) . '/runtime/logs/',
					'logName' => '-activity.log',
					'logLevel' => 3, // Take necessary value from apploger class
					'logSocket' => '',
					'isConsole' => false
				]
			]
		],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
			'transport' => [
				'class' => 'Swift_SmtpTransport',
				'host' => '',
				'username' => '',
				'password' => '',
				'port' => '25',
				'encryption' => 'tls',
			]
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
		'view' => [
			'class' => 'app\components\View',
			'theme' => [
				'pathMap' => ['@app/views' => '@webroot/themes/default/views'],
				'baseUrl' => '@web/themes/default',
			],
		],
		'assetManager' => [
			'bundles' => [
				/*'yii\web\JqueryAsset' => [
					'js'=>[]
				],*/
				'yii\bootstrap\BootstrapPluginAsset' => [
					'js'=>[]
				],
				'yii\bootstrap\BootstrapAsset' => [
					'css' => [],
				],

			],
		],
		'urlManager' => [
			'class' => 'yii\web\UrlManager',
			'enablePrettyUrl' => true,
			//'showScriptName' => false,
			'rules' => [
				'book/read/<t>/<c>' => 'book/read',
				'site/registerInterest' => 'site/register-interest',
			]
		],
        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    //$config['bootstrap'][] = 'debug';
    //$config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
