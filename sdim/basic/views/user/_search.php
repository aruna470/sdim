<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-search">

    <?php $form = ActiveForm::begin([
		'layout' => 'inline',
        'action' => ['advertiser'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'firstName')->textInput(['placeholder' => $model->getAttributeLabel('firstName')]) ?>
    <?= $form->field($model, 'lastName')->textInput(['placeholder' => $model->getAttributeLabel('lastName')]) ?>
	<?= $form->field($model, 'email')->textInput(['placeholder' => $model->getAttributeLabel('email')]) ?>

	<p></p>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <!--<?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>-->
    </div>
	<p></p>
	
    <?php ActiveForm::end(); ?>

</div>
