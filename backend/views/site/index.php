<?php

/* @var $this yii\web\View */

$this->title = Yii::$app->params[ 'siteName' ];
// 设置 keywords
$this->registerMetaTag ( [ 'name' => 'keywords', 'content' => '' ] );
// 设置description
$this->registerMetaTag ( [ 'name' => 'description', 'content' => '' ] );
?>
<div class="templatemo-content-wrapper">
	<div class="templatemo-content">
		<ol class="breadcrumb">
			<li><a href="<?= \yii\helpers\Url::toRoute ( 'site/index' ); ?>">后台管理</a></li>
			<li class="active">Overview</li>
		</ol>
		<h1>Dashboard</h1>
		<p>....</p>

	</div>
</div>