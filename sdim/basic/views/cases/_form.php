<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Cases */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cases-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<div class="row">
		<div class="col-md-6">
			<?= $form->field($model, 'lastName')->textInput(['maxlength' => true]) ?>

			<?= $form->field($model, 'startDate')->widget(
				DatePicker::className(), [
					// inline too, not bad
					 'inline' => false, 
					 // modify template for custom rendering
					//'template' => '<div class="well well-sm" style="background-color: #fff; width:250px">{input}</div>',
					'clientOptions' => [
						'autoclose' => true,
						'format' => 'yyyy-mm-dd'
					]
			]);?>

			<?= $form->field($model, 'dueDate')->textInput() ?>

			<?= $form->field($model, 'urgent')->textInput() ?>

			<?= $form->field($model, 'billingClientId')->textInput() ?>

			<?= $form->field($model, 'ultimateClientId')->textInput() ?>

			<?= $form->field($model, 'assignToId')->textInput() ?>
		</div>
		<div class="col-md-6">
		    <?= $form->field($model, 'status')->textInput() ?>

			<?= $form->field($model, 'createdAt')->textInput() ?>

			<?= $form->field($model, 'createdById')->textInput() ?>

			<?= $form->field($model, 'updatedAt')->textInput() ?>

			<?= $form->field($model, 'updatedById')->textInput() ?>
		</div>
	</div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
