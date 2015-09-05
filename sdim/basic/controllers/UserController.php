<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\UserSearch;
use app\models\Role;
use app\models\CcInfoForm;
use app\controllers\BaseController;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends BaseController
{
    public function behaviors()
    {
        return [
        ];
    }

	public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
	
	/**
     * Lists all acctions that do not require login
     * @return mixed
     */
	public function allowed()
	{
		return [
			'User.Register',
			'User.EmailConfirm',
			'User.Captcha',
			'User.Card'
        ];
	}
	
    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		Yii::$app->appLog->writeLog('View all system users');
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	/**
     * Reset advertiser password and email
     * @param integer $id Advertiser id
     * @return mixed
     */
    public function actionResetPw($id)
    {
		$model = $this->findModel($id);
		$newPassword = $model->getNewPassword();
		$encryptedPw = $model->encryptPassword($newPassword);
		
		$model->password = $encryptedPw;
		
		try {		
			if ($model->save()) {
			
				Yii::$app->session->setFlash('success', Yii::t('app', 'Password reset success.'));
				
				$message = Yii::t('app', 'Dear {name}, Your {productName} password has been reset. New password is:{newPassword}', [
					'name' => $model->firstName,
					'productName' => Yii::$app->params['productName'],
					'newPassword' => $newPassword
				]);
				
				$response = Yii::$app->mailer->compose('@app/views/emailTemplate/notificationTemplate', ['content' => $message])
					->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->params['productName']])
					->setTo($model->email)
					->setSubject(Yii::t('app', '{name} Reset Password', ['name' => Yii::$app->params['productName']]))
					->send();
					
				if (!$response) {
					Yii::$app->session->setFlash('error', Yii::t('app', 'Email sending failed. Try again later.'));
				}
			} else {
				Yii::$app->session->setFlash('error', Yii::t('app', 'Password reset failed.'));
			}
		} catch (Exception $e) {
			Yii::$app->session->setFlash('error', Yii::t('app', 'Password reset failed.'));
		}
		
        return $this->redirect(['advertiser']);
    }
	
	/**
     * Change user status. Activate/Deactivate
     * @param integer $id Advertiser id
	 * @param integer $status 1-Active, 0-Inactive
     * @return mixed
     */
    public function actionChangeStatus($id, $status)
    {
		$model = $this->findModel($id);		
		$model->status = $status;
		
		try {
			if ($model->save()) {
				Yii::$app->session->setFlash('success', Yii::t('app', 'User status changed.'));
			} else {
				Yii::$app->session->setFlash('error', Yii::t('app', 'User status change failed.'));
			}
		} catch (Exception $e) {
			Yii::$app->session->setFlash('error', Yii::t('app', 'User status change failed.'));
		}
		
        return $this->redirect(['advertiser']);
    }

    /**
     * Displays a single User model.
     * @param integer $_id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
		$model->scenario = 'create';
		
		if ($model->load(Yii::$app->request->post())) {
			if ($model->validate()) {
				$password = $model->password;
				$model->password = $model->encryptPassword();
				$model->createdAt = Yii::$app->util->getUtcDateTime();
				$model->createdById = Yii::$app->user->identity->id;
				$model->status = User::ACTIVE;
				try {
					if ($model->save(false)) {
						Yii::$app->session->setFlash('success', Yii::t('app', 'User created'));
						Yii::$app->appLog->writeLog("System user created.", [$model->attributes]);
						return $this->redirect(['index']);
					} else {
						Yii::$app->appLog->writeLog("System user create failed.", [$model->attributes]);
						Yii::$app->session->setFlash('error', Yii::t('app', 'User create failed'));
					}
				} catch (Exception $e) {
					Yii::$app->appLog->writeLog("System user create failed.", [$e->getMessage(), $model->attributes]);
					Yii::$app->session->setFlash('error', Yii::t('app', 'User create failed'));
				}
				$model->password = $password;
			} else {
				Yii::$app->appLog->writeLog("System user create. Validation failed.", [$model->errors]);
			}
        }
		
		return $this->render('create', [
			'model' => $model,
		]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$model->scenario = 'update';
		$curPassword = $model->password;

		if ($model->load(Yii::$app->request->post())) {
			$model->updatedAt = Yii::$app->util->getUtcDateTime();
			$model->updatedById = Yii::$app->user->identity->id;
			if ($model->validate()) {
				$password = '';
				if ('' == $model->password) {
					$model->password = $curPassword;
				} else {
					$password = $model->password;
					$model->password = $model->encryptPassword();
				}
				try {
					if ($model->save(false)) {
						Yii::$app->appLog->writeLog("System user updated", [$model->attributes]);
						Yii::$app->session->setFlash('success', Yii::t('app', 'User updated'));
						return $this->redirect(['index']);
					} else {
						Yii::$app->appLog->writeLog("System user update failed", [$model->attributes]);
						Yii::$app->session->setFlash('error', Yii::t('app', 'User update failed'));
					}
				} catch (Exception $e) {
					Yii::$app->appLog->writeLog("System user update failed", [$e->getMessage, $model->attributes]);
					Yii::$app->session->setFlash('error', Yii::t('app', 'User update failed'));
				}
				
				$model->password = $password;
			} else {
				Yii::$app->appLog->writeLog("System user update failed. Validation failed", [$model->errors]);
			}
        } else {
			$model->password = '';
		}
		
		return $this->render('update', [
			'model' => $model,
		]);
    }

	/**
     * Update own profile details.
     * @return mixed
     */
    public function actionMyAccount()
    {
		$id = Yii::$app->user->identity->id;
        $model = $this->findModel($id);
		
		if (Yii::$app->user->identity->role == Role::ADVERTISER) {
			$model->scenario = 'myAccount';
		} else {
			$model->scenario = 'myAccountSysUser';
		}

		if ($model->load(Yii::$app->request->post())) {
			$model->updatedAt = Yii::$app->util->getUtcDateTime();
			$model->updatedById = Yii::$app->user->identity->id;
			if ($model->validate()) {
				try {
					if ($model->save(false)) {
						Yii::$app->appLog->writeLog("User profile details updated", [$model->attributes]);
						Yii::$app->user->identity->timeZone = $model->timeZone;
						Yii::$app->session->setFlash('success', Yii::t('app', 'Profile details updated.'));
					} else {
						Yii::$app->appLog->writeLog("User profile details update failed", [$model->attributes]);
						Yii::$app->session->setFlash('error', Yii::t('app', 'Profile details update failed.'));
					}
				} catch (Exception $e) {
					Yii::$app->appLog->writeLog("User profile details update failed.", [$e->getMessage(), $model->errors]);
					Yii::$app->session->setFlash('error', Yii::t('app', 'Profile details update failed.'));
				}
			} else {
				Yii::$app->appLog->writeLog("User profile details update failed. Validation failed", [$model->errors]);
			}
        }
		
		return $this->render('myAccount', [
			'model' => $model,
		]);
    }
	
	/**
     * Change password.
     * @return mixed
     */
    public function actionChangePassword()
    {
		$id = Yii::$app->user->identity->id;
        $model = $this->findModel($id);
		$model->scenario = 'changePassword';
		$model->curOldPassword = $model->password;

		if ($model->load(Yii::$app->request->post())) {
			$model->updatedAt = Yii::$app->util->getUtcDateTime();
			$model->updatedById = Yii::$app->user->identity->id;
			$oldPassword = '';
			if ('' != $model->oldPassword) {
				$oldPassword = $model->oldPassword;
				$model->oldPassword = $model->encryptPassword($model->oldPassword);
			}
			if ($model->validate()) {
				$model->password = $model->encryptPassword($model->newPassword);
				try {
					if ($model->save(false)) {
						Yii::$app->appLog->writeLog("User password changed", [$model->attributes]);
						Yii::$app->session->setFlash('success', Yii::t('app', 'Password changed.'));
						return $this->redirect(['change-password']);
					} else {
						Yii::$app->appLog->writeLog("User password change failed", [$model->attributes]);
						Yii::$app->session->setFlash('error', Yii::t('app', 'Password change failed.'));
					}
				} catch (Exception $e) {
					Yii::$app->appLog->writeLog("User password change failed", [$e->getMessage(), $model->attributes]);
					Yii::$app->session->setFlash('error', Yii::t('app', 'Password change failed.'));
				}
			} else {
				Yii::$app->appLog->writeLog("User passwor change failed. Validation failed", [$model->errors]);
			}
			
			$model->oldPassword = $oldPassword;
        }
		
		return $this->render('changePassword', [
			'model' => $model,
		]);
    }
	
    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionDelete($id)
    {
		try {
			$this->findModel($id)->delete();
			Yii::$app->appLog->writeLog("User deleted.", ['id'=>$id]);
			Yii::$app->session->setFlash('success', Yii::t('app', 'User deleted'));
		} catch (Exception $e) {
			Yii::$app->appLog->writeLog("User delete failed.", [$e->getMessage(), 'id'=>$id]);
			Yii::$app->session->setFlash('error', Yii::t('app', 'User delete failed'));
		}
		
        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $_id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
