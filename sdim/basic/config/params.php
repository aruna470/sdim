<?php
return [
	'supportEmail' => 'sdim@gmail.com',
	'productName' => 'SDIM',
    'adminEmail' => 'admin@example.com',
	'salt' => '$r!lanka',
	'accessDeniedUrl' => ['site/access-denied'],
	'defaultTimeZone' => date_default_timezone_get(), // TimeZone set on php.ini file
	'tempPath' => dirname(__DIR__) . '/runtime/temp/',
	'consoleCmdPath' => 'c:\/wamp\/www\/sdim\/basic\/yii',
	'audittrail.table' => 'AuditTrail'
];
