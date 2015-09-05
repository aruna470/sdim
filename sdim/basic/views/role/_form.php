<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use app\models\RolePermission;

/* @var $this yii\web\View */
/* @var $model app\models\Role */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="role-form">

    <?php $form = ActiveForm::begin(); ?>

	<?php
		if ($model->isNewRecord) {
			echo $form->field($model, 'name');
		} else {
			echo $form->field($model, 'name')->textInput(['readonly' => true]);
		}
	?>

    <?= $form->field($model, 'description') ?>

	<?= GridView::widget([
        'dataProvider' => $dataProvider,
		'tableOptions' => ['class'=>'table table-striped'], 
        'columns' => [
			[
				'class' => 'yii\grid\CheckboxColumn',
				'checkboxOptions' => function($data, $key, $index, $column) use ($model) {
					$checked = false;
					if (!$model->isNewRecord) {
						$modelRP = RolePermission::find()->where(['roleName' => $model->name, 'permissionName' => $data->name])->one();
						if (!empty($modelRP)) {
							$checked = true;
						}
					}
					return ['value' => $data->name, 'checked' => $checked];
				}
			],
            'name',
            'description',
            'category',
        ],
    ]); ?>
	
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
