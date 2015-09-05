<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Permission */

$this->pageTitle = Yii::t('app', 'Permissions');
$this->pageTitleDescription = Yii::t('app', 'Add new permission');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Permissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Add Permission');
?>
<div class="permission-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
