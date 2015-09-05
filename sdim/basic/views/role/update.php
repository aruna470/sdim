<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Role */

$this->pageTitle = Yii::t('app', 'Update Role');
$this->pageTitleDescription = Yii::t('app', 'Modify permissions of the role');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Manage Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update Role');
?>
<div class="role-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'dataProvider' => $dataProvider
    ]) ?>

</div>
