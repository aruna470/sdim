<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;
use yii\console\Controller;

class TestController extends Controller
{
	public function actionTest()
	{
		Yii::$app->appLog->username = __class__;
		Yii::$app->appLog->writeLog("started");
		while (true) {
			sleep(10);
			Yii::$app->appLog->writeLog("running..");
		}
	}
}
