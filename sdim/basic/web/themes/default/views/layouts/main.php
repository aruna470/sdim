<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
$title = '' == $this->title ? Yii::$app->params['productName'] : $this->title;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($title) ?></title>
    <?php $this->head() ?>
</head>
<body <?= $this->ngData ?>>

<?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => Yii::$app->params['productName'],
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
			if (!Yii::$app->getUser()->isGuest):
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav'],
				'activateItems' => true,
				'activateParents' => true,
                'items' => [
					['label' => Yii::t('app', 'Home'), 'url' => ['/site/index'], 'visible' => true],					
					[
						'label' => Yii::t('app', 'System'),
						'visible' => Yii::$app->user->canList(['Permission.Index', 'Role.Index', 'User.Index']),
						'items' => [
							 ['label' => Yii::t('app', 'Manage Permissions'), 'url' => ['/permission/index'], 'visible' => Yii::$app->user->can('Permission.Index')],
							 ['label' => Yii::t('app', 'Manage Roles'), 'url' => ['/role/index'], 'visible' => Yii::$app->user->can('Role.Index')],
							 ['label' => Yii::t('app', 'Manage System Users'), 'url' => ['/user/index'], 'visible' => Yii::$app->user->can('User.Index')],
						],
					],
					['label' => Yii::t('app', 'Cases'), 'url' => ['/cases/index'], 'visible' => Yii::$app->user->can('Cases.Index')],					
                ],
            ]);
			echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
				'activateItems' => true,
				'activateParents' => true,
                'items' => [
					[
						'label' => Yii::$app->user->identity->firstName,
						'items' => [
							['label' => Yii::t('app', 'My Account'), 'url' => ['/user/my-account'], 'visible' => Yii::$app->user->can('User.MyAccount')],
							//['label' => Yii::t('app', 'Credit/Debit Card'), 'url' => ['/user/card'], 'visible' => Yii::$app->user->can('User.Card')],
							['label' => Yii::t('app', 'Change Password'), 'url' => ['/user/change-password'], 'visible' => Yii::$app->user->can('User.ChangePassword')],
							['label' => Yii::t('app', 'Logout'), 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']],
						],
					],
                ],
            ]);
			endif;
            NavBar::end();
        ?>

        <div class="container page">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
			<div class="card">
				<div id="statusMsg"></div>
				<?php
					foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
						if ($key == 'error') {
							$key = 'danger';
						}
						echo '<div class="alert alert-' . $key . '">' . $message . '</div>';
					}
				?>
				<?php
					if ('' != $this->tabMenu) {
						echo $this->render('@app/views/layouts/mainTabMenu', []);
					} 
				?>
				<?php if (null != $this->pageTitle): ?>
					<div class="card-header">
						<h2><?= $this->pageTitle ?> 
							<?php if (null != $this->pageTitleDescription): ?>
								<small><?= $this->pageTitleDescription ?></small>
							<?php endif;?>
						</h2>
					</div>
				<?php endif; ?>
				<?= $content ?>
			</div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
			<p style="text-align:center">&copy; <?= Yii::t('app', 'SDIM Ltd.')?> <?= date('Y') ?></p>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
