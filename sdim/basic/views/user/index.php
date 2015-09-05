<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\View;
use app\models\Role;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->pageTitle = Yii::t('app', 'Manage Users');
$this->pageTitleDescription = Yii::t('app', 'Listing all system users');
$this->params['breadcrumbs'][] = Yii::t('app', 'Manage System Users');
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

<div class="user-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<?php if (Yii::$app->user->can('User.Create')): ?>
    <p>
        <?= Html::a(Yii::t('app', 'Create User'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
	<?php endif ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
		'tableOptions' => ['class'=>'table table-striped'],
        'columns' => [
            'firstName',
            'lastName',
            'email',
			'role',
			[
				'class' => 'yii\grid\DataColumn',
				'attribute' => 'createdAt',
				'value' => function ($model) {
					return Yii::$app->util->getLocalDateTime($model->createdAt, Yii::$app->user->identity->timeZone);
				}
			],
			[  
				'class' => 'yii\grid\ActionColumn',
				'contentOptions' => ['style' => 'text-align:right'],
				'template' => '{update} {delete}',
				'buttons' => [
					/*'view' => function ($url, $model, $key) {
						return Yii::$app->user->can('User.View') ? Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url) : '';
					},*/
					'update' => function ($url, $model, $key) {
						$return = '';
						if (Yii::$app->user->can('User.Update')) {
							$return = Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url);
							if ($model->role == Role::SUPERADMIN) {
								$return = '';
							} else if($model->email == Yii::$app->user->identity->email) {
								$return = '';
							}
						}
						return $return;
					},
					'delete' => function ($url, $model, $key) {
						$return = '';
						if (Yii::$app->user->can('User.Delete')) {
							$return = Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ['id' => 'delete']);
							if ($model->role == Role::SUPERADMIN) {
								$return = '';
							} else if($model->email == Yii::$app->user->identity->email) {
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
