<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PermissionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->pageTitle = Yii::t('app', 'Permissions');
$this->pageTitleDescription = Yii::t('app', 'Listing all system permissions');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Permissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="permission-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Permission', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
		'tableOptions' => ['class'=>'table table-striped'], 
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'name',
            'description',
            'category',

			[  
				'class' => 'yii\grid\ActionColumn',
				'contentOptions' => ['style' => 'text-align:right'],
				'template' => '{update} {delete}',
				'buttons' => [

				],
			],
        ],
    ]); ?>

</div>
