<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RolePermission */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="role-permission-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'roleName') ?>

    <?= $form->field($model, 'permissionName') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
