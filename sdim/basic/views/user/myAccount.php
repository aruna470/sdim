<?php

use yii\helpers\Html;
use app\models\Role;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */

$this->pageTitle = Yii::t('app', 'My Account');
$this->pageTitleDescription = Yii::t('app', 'Update your profile details');
$this->params['breadcrumbs'][] = Yii::t('app', 'My Account');
?>

<?php 
if (Yii::$app->user->identity->role == Role::ADVERTISER) {
	echo $this->render('_myAccountAdvertiser', [
		'model' => $model,
	]);
} else {
	echo $this->render('_myAccountSysUser', [
		'model' => $model,
	]);
}
?>
