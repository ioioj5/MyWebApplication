<?php

/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register ( $this );
?>
<?php $this->beginPage () ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<?= Html::csrfMetaTags () ?>
    <title><?= Html::encode ( $this->title ) ?></title>
	<?php $this->head () ?>
</head>
<body>
<?php $this->beginBody () ?>

<div class="wrap">
	<?php
	NavBar::begin ( [
		'brandLabel' => 'MyWebApplication',
		'brandUrl'   => Yii::$app->homeUrl,
		'options'    => [
			'class' => 'navbar-default navbar-fixed-top'
		]
	] );
	$menuItems = [
		[
			'label' => 'Home',
			'url'   => [
				'/site/index'
			]
		],
		[
			'label' => 'About',
			'url'   => [
				'/site/about'
			]
		]
	];
	if ( Yii::$app->user->isGuest ) {
		$menuItems [] = [
			'label' => 'Signup',
			'url'   => [
				'/auth/sign-up'
			]
		];
		$menuItems [] = [
			'label' => 'Signin',
			'url'   => [
				'/auth/sign-in'
			]
		];
	} else {
		$menuItems [] = [
			'label' => 'Cart',
			'url'   => [
				'/cart/index'
			]
		];
		$menuItems [] = [
			'label' => Yii::$app->user->identity->email,
			'url'   => [
				'/my/index'
			]
		];
		$menuItems[]  = [
			'label' => 'Logout',
			'url'   => [
				'/auth/logout'
			]
		];
	}
	echo Nav::widget ( [
		'options' => [
			'class' => 'navbar-nav navbar-right'
		],
		'items'   => $menuItems
	] );
	NavBar::end ();
	?>

    <div class="container">
		<?= Breadcrumbs::widget ( [ 'links' => isset ( $this->params [ 'breadcrumbs' ] ) ? $this->params [ 'breadcrumbs' ] : [] ] ) ?>
		<?= Alert::widget () ?>
		<?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date ( 'Y' ) ?></p>

        <p class="pull-right"><?= Yii::powered () ?></p>
    </div>
</footer>

<?php $this->endBody () ?>
</body>
</html>
<?php $this->endPage () ?>
