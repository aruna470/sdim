<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->pageTitle = Yii::t('app', 'Update User');
$this->pageTitleDescription = Yii::t('app', 'Modify user details');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Manage Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update User');
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
