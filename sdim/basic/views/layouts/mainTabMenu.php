<?php
use yii\bootstrap\Tabs;
?>
<div style="margin-bottom:30px">
<?php
echo Tabs::widget([
    'items' => [
        [
            'label' => 'Matter Details',
            'active' => true,
			'url' => Yii::$app->urlManager->createUrl(['site/tab-sample']),
        ],
        [
            'label' => 'QC Searches',
            'active' => false,
			'url' => Yii::$app->urlManager->createUrl(['site/tab-sample']),
        ],
        [
            'label' => 'Client Response',
            'url' => Yii::$app->urlManager->createUrl(['site/tab-sample']),
			'active' => false
        ],
		[
            'label' => 'QC Briefing',
            'url' => Yii::$app->urlManager->createUrl(['site/tab-sample']),
			'active' => false
        ],
		[
            'label' => 'Clinical Assess.',
            'url' => Yii::$app->urlManager->createUrl(['site/tab-sample']),
			'active' => false
        ],
		[
            'label' => 'Financial Assess.',
            'url' => Yii::$app->urlManager->createUrl(['site/tab-sample']),
			'active' => false
        ],
		[
            'label' => 'Folder Matter',
            'url' => Yii::$app->urlManager->createUrl(['site/tab-sample']),
			'active' => false
        ],
		[
            'label' => 'Accounting',
            'url' => Yii::$app->urlManager->createUrl(['site/tab-sample']),
			'active' => false
        ],
    ],
]);
?>
</div>