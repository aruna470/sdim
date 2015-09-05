<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Role;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['enableClientValidation' => false]); ?>

	<div class="row">
		<div class="col-md-6">
			<?= $form->field($model, 'firstName') ?>
			<?= $form->field($model, 'lastName') ?>		
			<?= $form->field($model, 'role')->dropDownList(
					ArrayHelper::map(Role::find()->where('name != :name', ['name' => Role::SUPERADMIN])->all(), 'name', 'name'),
					['prompt' => Yii::t('app', '- Role -')]
					//$models = Book::find()->where('id != :id and type != :type', ['id'=>1, 'type'=>1])->all();Role::SUPERADMIN
			); ?>
			
			<?= $form->field($model, 'timeZone')->dropDownList(
					Yii::$app->util->getTimeZoneList(),
					['prompt' => Yii::t('app', '- TimeZone -')]
			); ?>
		</div>
		<div class="col-md-6">
			<?= $form->field($model, 'username') ?>
			<?php
				if ($model->isNewRecord) {
					echo $form->field($model, 'email');
				} else {
					echo $form->field($model, 'email')->textInput(['readonly' => true]);
				}
			?>
			<?= $form->field($model, 'password')->passwordInput(['autocomplete'=>"off"]) ?>
			<?= $form->field($model, 'confPassword')->passwordInput(['autocomplete'=>"off"]) ?>
		</div>
	</div>
	
	<div class="form-group">
		<?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	</div>
	
    <?php ActiveForm::end(); ?>
</div>

