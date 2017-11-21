<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


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
                    <li role="presentation"><a href="<?= \yii\helpers\Url::toRoute(['my/address']); ?>">收货地址</a></li>
                    <li role="presentation" class="active"><a href="<?= \yii\helpers\Url::toRoute(['my/add-address']);?>">添加收货地址</a></li>
                </ul>

				<?php $form = ActiveForm::begin ( [ 'id' => 'login-form', 'class' => 'form-control'] ); ?>
                <div class="form-group">
					<?= $form->field ( $model, 'name' )->textInput () ?>
                </div>
                <div class="form-group">
					<?= $form->field ( $model, 'contact' )->textInput () ?>
                </div>
                <div class="form-group">
					<?= $form->field ( $model, 'address' )->textInput () ?>
                </div>

                <div class="form-group">
					<?= $form->field($model, 'isDefault')->radioList(['1'=>'默认','0'=>'非默认']) ?>
                </div>

                <div class="row templatemo-form-buttons">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary"><?php if ( isset( $model->id ) and $model->id > 0 ): ?>编辑<?php else: ?>添加<?php endif; ?></button>
                        <button type="reset" class="btn btn-default">重置</button>
                    </div>
                </div>

				<?php if ( isset( $model->id ) and $model->id > 0 ): ?>
                    <input type="hidden" name="addressId" value="<?= $model->id; ?>">
				<?php endif; ?>
				<?php ActiveForm::end (); ?>
            </div>


        </div>
    </div>
</div>