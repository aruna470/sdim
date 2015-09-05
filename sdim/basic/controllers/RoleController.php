<?php

namespace app\controllers;

use Yii;
use app\models\Role;
use app\models\RoleSearch;
use app\models\PermissionSearch;
use app\models\RolePermission;
use app\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RoleController implements the CRUD actions for Role model.
 */
class RoleController extends BaseController
{
    public function behaviors()
    {
        return [
            
        ];
    }

    /**
     * Lists all Role models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RoleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Role model.
     * @param integer $_id
     * @return mixed
     */
    public function actionView($id)
    {
		$model = $this->findModel($id);
		$rps = RolePermission::findAll(['roleName' => $model->name]);
		$permissions = '';
		foreach ($rps as $rp) {
			$permissions .= "<p>{$rp->permissionName}</p>";
		}
        return $this->render('view', [
            'model' => $model,
			'permissions' => $permissions
        ]);
    }

    /**
     * Creates a new Role model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Role();
		$searchModel = new PermissionSearch();
		$dataProvider = $searchModel->search([]);

		if ($model->load(Yii::$app->request->post())) {
			$postData = Yii::$app->request->post();
			$model->createdAt = Yii::$app->util->getUtcDateTime();
			$model->createdById = Yii::$app->user->identity->id;
			if (!empty($postData['selection'])) {
				if ($model->validate()) {
					try {
						if ($model->save()) {
							Yii::$app->session->setFlash('success', Yii::t('app', 'Role created'));
							foreach ($postData['selection'] as $permission) {
								$modelRolePermission = new RolePermission();
								$modelRolePermission->roleName = $model->name;
								$modelRolePermission->permissionName = $permission;
								try {
									$modelRolePermission->save();
								} catch (Exception $e) {
								}
							}
							return $this->redirect(['index']);
						} else {
							Yii::$app->session->setFlash('success', Yii::t('app', 'Role create failed'));
						}
					} catch (Exception $e) {
						if ($e->getCode() == 11000) {
							Yii::$app->session->setFlash('error', Yii::t('app', 'Role exists'));
						} else {
							Yii::$app->session->setFlash('error', Yii::t('app', 'Role create failed'));
						}
					}
				}
			} else {
				Yii::$app->session->setFlash('error', Yii::t('app', 'Please select atleast one permission'));
			}
		}

		return $this->render('create', [
			'model' => $model,
			'dataProvider' => $dataProvider
		]);
    }

    /**
     * Updates an existing Role model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

		$searchModel = new PermissionSearch();
		$dataProvider = $searchModel->search([]);

		if ($model->load(Yii::$app->request->post())) {
			$postData = Yii::$app->request->post();
			$model->updatedAt = Yii::$app->util->getUtcDateTime();
			$model->updatedById = Yii::$app->user->identity->id;
			if (!empty($postData['selection'])) {
				if ($model->validate()) {
					try {
						if ($model->save()) {
							Yii::$app->session->setFlash('success', Yii::t('app', 'Role updated'));
							RolePermission::deleteAll(['roleName' => $model->name]);
							foreach ($postData['selection'] as $permission) {
								$modelRolePermission = new RolePermission();
								$modelRolePermission->roleName = $model->name;
								$modelRolePermission->permissionName = $permission;
								try {
									$modelRolePermission->save();
								} catch (Exception $e) {
								}
							}
							return $this->redirect(['index']);
						} else {
							Yii::$app->session->setFlash('success', Yii::t('app', 'Role update failed'));
						}
					} catch (Exception $e) {
						Yii::$app->session->setFlash('success', Yii::t('app', 'Role update failed'));
					}
				}
			} else {
				Yii::$app->session->setFlash('error', Yii::t('app', 'Please select atleast one permission'));
			}
		}

		return $this->render('update', [
			'model' => $model,
			'dataProvider' => $dataProvider
		]);
    }

    /**
     * Deletes an existing Role model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
		
		$userModel = User::findOne(['role' => $model->name]);
		
		if (empty($userModel)) {
			try {
				$model->delete();
				Yii::$app->session->setFlash('success', Yii::t('app', 'Role deleted'));
				try {
					RolePermission::deleteAll(['roleName' => $model->name]);
				} catch (Exception $e) {
				}
			} catch (Exception $e) {
				Yii::$app->session->setFlash('error', Yii::t('app', 'Role delete failed'));
			}
		} else {
			Yii::$app->session->setFlash('error', Yii::t('app', 'Role cannot be deleted. First delete users attached to this role.'));
		}
		
        return $this->redirect(['index']);
    }

    /**
     * Finds the Role model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $_id
     * @return Role the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Role::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
