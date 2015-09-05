<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Role */

$this->pageTitle = Yii::t('app', 'Create Role');
$this->pageTitleDescription = Yii::t('app', 'Create new user role with different permissions');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Manage Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Create Role');
?>
<div class="role-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'dataProvider' => $dataProvider
    ]) ?>

</div>
