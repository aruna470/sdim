<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Role;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RoleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->pageTitle = Yii::t('app', 'Manage Roles');
$this->pageTitleDescription = Yii::t('app', 'Listing all system roles');
$this->params['breadcrumbs'][] = Yii::t('app', 'Manage Roles');
?>
<?php
$confirmMsg = Yii::t('app', 'Are you sure you want to delete the record?');
$this->registerJs("
	$(document.body).on('click', '#delete' ,function(){
		var url = $(this).attr('href');
		bootbox.confirm('{$confirmMsg}', function(result) {
			if (result) {
				location.href = url;
			}
		}); 
		return false;
	});
", View::POS_END, 'del-confirm');
?>
<div class="role-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<?php if (Yii::$app->user->can('Role.Create')): ?>
    <p>
        <?= Html::a(Yii::t('app', 'Create Role'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
	<?php endif ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
		'tableOptions' => ['class'=>'table table-striped'],
        'columns' => [
            'name',
            'description',
			[
				'class' => 'yii\grid\ActionColumn',
				'contentOptions' => ['style' => 'text-align:right'],
				'template' => '{view} {update} {delete}',
				'buttons' => [
					'view' => function ($url, $model, $key) {
						$return = '';
						if (Yii::$app->user->can('Role.View')) {
							$return = Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url);
							if ($model->name == Role::SUPERADMIN) {
								$return = '';
							} else if($model->name == Role::ADMINISTRATOR && !Yii::$app->user->identity->isSuperadmin) {
								$return = '';
							}
						}
						return $return;
					},
					'update' => function ($url, $model, $key) {
						$return = '';
						if (Yii::$app->user->can('Role.Update')) {
							$return = Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url);
							if ($model->name == Role::SUPERADMIN) {
								$return = '';
							} else if($model->name == Role::ADMINISTRATOR && !Yii::$app->user->identity->isSuperadmin) {
								$return = '';
							}
						}
						return $return;
					},
					'delete' => function ($url, $model, $key) {
						$return = '';
						if (Yii::$app->user->can('Role.Delete')) {
							$return = Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ['id' => 'delete']);
							if ($model->name == Role::SUPERADMIN) {
								$return = '';
							} else if($model->name == Role::ADMINISTRATOR && !Yii::$app->user->identity->isSuperadmin) {
								$return = '';
							}
						}
						return $return;
					},
				],
			],
        ],
    ]); ?>

</div>
