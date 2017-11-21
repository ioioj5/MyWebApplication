<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;


$this->title = 'Index';
//$this->params['breadcrumbs'][] = $this->title;
$this->params[ 'breadcrumbs' ] = [
	[
		'label' => 'My',
		'url'   => \yii\helpers\Url::toRoute ( [ 'my/index' ] )
	],
	[
	    'label' => 'Setting' ,
        'url'=>\yii\helpers\Url::toRoute(['my/setting'])
    ],
    ['label'=>'address']
];
$this->registerCssFile ( '@web/css/jquery.toast.min.css', ['depends'=>['frontend\assets\AppAsset']]);
?>
<div class="templatemo-content-wrapper">
    <div class="templatemo-content">
        <ol class="breadcrumb">
            <li><a href="<?= Url::toRoute ( 'my/index' ); ?>">个人中心</a></li>
            <li><a href="#">个人信息</a></li>
            <li class="active">收货地址</li>
        </ol>
        <h1>收货地址</h1>
        <div class="panel panel-default">
            <div class="panel-heading">&nbsp;</div>
            <div class="panel-body">
                <ul class="nav nav-pills" role="tablist">
                    <li role="presentation" class="active"><a href="<?= \yii\helpers\Url::toRoute(['my/address']); ?>">收货地址</a></li>
                    <li role="presentation"><a href="<?= \yii\helpers\Url::toRoute(['my/add-address']);?>">添加收货地址</a></li>
                </ul>
            </div>

            <table class="table table-condensed table-striped">
                <tr>
                    <td>姓名</td>
                    <td>联系方式</td>
                    <td>收货地址</td>
                    <td>是否默认</td>
                    <td>操作</td>
                </tr>
				<?php if(isset($list) and ! empty($list)): ?>
					<?php foreach($list as $key=>$val): ?>
                        <tr>
                            <td><?= $val->name; ?></td>
                            <td><?= $val->contact; ?></td>
                            <td><?= $val->address; ?></td>
                            <td><?php if($val->isDefault == 1): ?>默认<?php else: ?>非默认<?php endif; ?></td>
                            <td>
                                <a href="<?= \yii\helpers\Url::toRoute(['my/add-address', 'addressId'=>$val->id]); ?>">编辑</a>
                                <a href="<?= \yii\helpers\Url::toRoute(['my/del-address', 'addressId'=>$val->id])?>">删除</a>
                            </td>
                        </tr>
					<?php endforeach; ?>
				<?php endif; ?>
            </table>
        </div>
    </div>
</div>