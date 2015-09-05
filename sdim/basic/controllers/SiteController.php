<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\SampleForm;
use app\controllers\BaseController;

class SiteController extends BaseController
{
    public function behaviors()
    {
        return [

        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

	public function allowed()
	{
		return [
			'Site.Index',
			'Site.Login',
			'Site.AccessDenied',
			'Site.Error',
			'Site.Logout',
			'Site.Captcha',
		];
	}
	
    public function actionIndex()
    {
		if (!\Yii::$app->user->isGuest) {
			return $this->render('index');
		} else {
			return $this->redirect(['login']);
		}
    }

    public function actionLogin()
    {
		$this->layout = 'login';
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
			Yii::$app->appLog->writeLog('Login success');
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
	
	public function actionTabSample()
	{
		$model = new SampleForm();
		return $this->render('tabSample', ['model' => $model]);
	}
	
	public function actionAccessDenied()
	{
		return $this->render('accessDenied', []);
	}

    public function actionLogout()
    {
		Yii::$app->appLog->writeLog('Logout success');
        Yii::$app->user->logout();
        return $this->redirect(['login']);
    }
}
