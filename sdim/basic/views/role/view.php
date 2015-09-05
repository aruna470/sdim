<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Role */

$this->pageTitle = Yii::t('app', 'View Role');
$this->pageTitleDescription = Yii::t('app', 'Role details');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Manage Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'View Role');
?>
<div class="role-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'description',
			[
				'label' => 'Permissions',
				'format'=>'raw',
				'value' => $permissions,
			],
        ],
    ]) ?>

</div>
