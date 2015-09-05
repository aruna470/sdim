<?php

use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\bootstrap\Tabs;
use app\assets\CalendarAsset;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->tabMenu = '@app/views/layouts/mainTabMenu';
$this->pageTitle = Yii::t('app', 'Matter Details');
//$this->pageTitleDescription = Yii::t('app', 'Casses assigned to you.');
$this->params['breadcrumbs'][] = Yii::t('app', 'Matter Details');
?>

<div class="sample-form">

    <?php $form = ActiveForm::begin(['enableClientValidation' => false]); ?>
	
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Target Basic Details</h3>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-md-4">
					<?= $form->field($model, 'firstName') ?>
					<?= $form->field($model, 'lastName') ?>
				</div>
				<div class="col-md-4">
					<?= $form->field($model, 'middleName') ?>
					<?= $form->field($model, 'dateOfBirth') ?>
				</div>
				<div class="col-md-4">
					<?= $form->field($model, 'age') ?>
					<?= $form->field($model, 'maritalStatus') ?>
				</div>
			</div>
		</div>
	</div>
	
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Target Address</h3>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-md-4">
					<?= $form->field($model, 'unitNo') ?>
					<?= $form->field($model, 'streetNo') ?>
				</div>
				<div class="col-md-4">
					<?= $form->field($model, 'streetName') ?>
					<?= $form->field($model, 'suburb') ?>
				</div>
				<div class="col-md-4">
					<?= $form->field($model, 'postCode') ?>
					<?= $form->field($model, 'state') ?>
				</div>
			</div>
		</div>
	</div>
		
	<div class="form-group">
		<?= Html::submitButton(Yii::t('app', 'Save Changes'), ['class' => 'btn btn-primary']) ?>
	</div>
		
    <?php ActiveForm::end(); ?>
</div>		