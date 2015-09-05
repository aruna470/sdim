<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Cases */

$this->pageTitle = Yii::t('app', 'Create Case');
$this->pageTitleDescription = Yii::t('app', 'Add new case');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cases'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Add Case');
?>
<div class="cases-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
