<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */

$this->pageTitle = Yii::t('app', 'Change Password');
$this->pageTitleDescription = Yii::t('app', 'Change your password');
$this->params['breadcrumbs'][] = Yii::t('app', 'Change password');
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['enableClientValidation' => false]); ?>

	<div class="row">		
		<div class="col-md-6">		
			<?= $form->field($model, 'oldPassword')->passwordInput(['autocomplete'=>"off", 'placeholder' => $model->getAttributeLabel('oldPassword')]) ?>
			<?= $form->field($model, 'newPassword')->passwordInput(['autocomplete'=>"off", 'placeholder' => $model->getAttributeLabel('newPassword')]) ?>
			<?= $form->field($model, 'confPassword')->passwordInput(['autocomplete'=>"off", 'placeholder' => $model->getAttributeLabel('confPassword')]) ?>
		</div>
	</div>
	
	<div class="form-group">
		<?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
	</div>
	
    <?php ActiveForm::end(); ?>
	
</div>
