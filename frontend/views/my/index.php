<?php

/* @var $this yii\web\View */
use yii\helpers\Html;


$this->title = 'Index';
//$this->params['breadcrumbs'][] = $this->title;
$this->params[ 'breadcrumbs' ] = [
	[
		'label' => 'My',
		'url'   => \yii\helpers\Url::toRoute ( [ 'my/index' ] )
	],
	[ 'label' => 'Index' ]
];
$this->registerCssFile ( '@web/css/jquery.toast.min.css', ['depends'=>['frontend\assets\AppAsset']]);
?>
<div class="templatemo-content-wrapper">
    <div class="templatemo-content">
        <ol class="breadcrumb">
            <li><a href="<?= \yii\helpers\Url::toRoute ( 'my/index' ); ?>">个人中心</a></li>
            <li class="active">控制面板</li>
        </ol>
        <h1>Dashboard</h1>
        <p>....</p>

    </div>
</div>