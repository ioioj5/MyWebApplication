<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
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
<div id="main-wrapper">
	<div class="navbar navbar-inverse" role="navigation">
		<div class="navbar-header">
			<div class="logo"><h1>Dashboard - <?= Yii::$app->params[ 'siteName' ]; ?></h1></div>
		</div>
	</div>
	<div class="template-page-wrapper">
		<?= $content; ?>
	</div>
</div>

<?php $this->endBody () ?>
</body>
</html>
<?php $this->endPage () ?>
