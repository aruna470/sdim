<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['enableClientValidation' => false]); ?>

	<div class="row">
		<div class="col-md-6">
			<?= $form->field($model, 'firstName')->textInput(['placeholder' => $model->getAttributeLabel('firstName')]) ?>
			<?= $form->field($model, 'lastName')->textInput(['placeholder' => $model->getAttributeLabel('lastName')]) ?>
			<?= $form->field($model, 'contactNumber')->textInput(['placeholder' => $model->getAttributeLabel('contactNumber')]) ?>
		</div>
		
		<div class="col-md-6">		
			<?= $form->field($model, 'email')->textInput(['placeholder' => $model->getAttributeLabel('email'), 'disabled' => true]) ?>
			<?= $form->field($model, 'timeZone')->dropDownList(
					Yii::$app->util->getTimeZoneList(),
					['prompt' => Yii::t('app', '- TimeZone -')]
			); ?>
		</div>
	</div>
	
	<div class="form-group">
		<?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
	</div>
	
    <?php ActiveForm::end(); ?>
	
</div>
