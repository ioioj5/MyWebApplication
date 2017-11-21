<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
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
	<?= Html::csrfMetaTags() ?>
</head>
<body>
<?php $this->beginBody () ?>

<div class="navbar navbar-inverse" role="navigation">
	<div class="navbar-header">
		<div class="logo"><h1>个人中心 - <?= Yii::$app->params[ 'siteName' ]; ?></h1></div>
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
	</div>
</div>
<div class="template-page-wrapper">
	<!-- 导航开始 -->
	<div class="navbar-collapse collapse templatemo-sidebar">
		<ul class="templatemo-sidebar-menu">
			<li>
				<form class="navbar-form">
					<input type="text" class="form-control" id="templatemo_search_box" placeholder="Search...">
					<span class="btn btn-default">Go</span>
				</form>
			</li>
			<li <?php if($this->context->id == 'site'): ?>class="active"<?php endif; ?>><a href="<?= Url::toRoute('my/index');?>"><i class="fa fa-home"></i>控制面板</a></li>
            <li <?php if($this->context->id == 'my-order'): ?>class="active"<?php endif; ?>>
                <a href="<?= Url::toRoute('my-order/index')?>"><i class="fa fa-cubes"></i>订单管理</a>
            </li>
            <li class="sub <?php if($this->context->id == 'my' and $this->context->action->id != 'index'): ?>open<?php endif; ?>">
                <a href="javascript:;">
                    <i class="fa fa-database"></i> 个人信息 <div class="pull-right"><span class="caret"></span></div>
                </a>
                <ul class="templatemo-submenu">
                    <li><a href="<?= Url::toRoute (['my/account']); ?>">账号管理</a></li>
                    <li><a href="<?= Url::toRoute (['my/address']); ?>">收货地址</a></li>
                </ul>
            </li>

            <li>
				<a href="<?= Url::toRoute(['auth/logout'])?>"><i class="fa fa-sign-out"></i>Sign Out</a>
			</li>
		</ul>
	</div>
	<!-- 导航结束 -->
	<!-- 正文开始 -->
	<?= $content ?>
	<!-- 正文结束 -->
	<!-- footer开始 -->
	<footer class="templatemo-footer">
		<div class="templatemo-copyright">
			<p>Copyright &copy; 2084 Your Company Name Collect from
				<a href="http://www.mianfeimoban.com/" target="_blank">网站模板</a></p>
		</div>
	</footer>
	<!-- footer结束 -->
</div>
<?php $this->endBody () ?>
</body>
</html>
<?php $this->endPage () ?>
