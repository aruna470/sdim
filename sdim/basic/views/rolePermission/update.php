<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RolePermission */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Role Permission',
]) . ' ' . $model->_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Role Permissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->_id, 'url' => ['view', 'id' => (string)$model->_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="role-permission-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
