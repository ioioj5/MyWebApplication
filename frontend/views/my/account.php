<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


$this->title = '我的订单_订单管理';
//$this->params['breadcrumbs'][] = $this->title;
$this->params[ 'breadcrumbs' ] = [
	[
		'label' => 'My',
		'url'   => \yii\helpers\Url::toRoute ( [ 'my/index' ] )
	],
	['label'=>'Order']
];
$this->registerCssFile ( '@web/css/jquery.toast.min.css', ['depends'=>['frontend\assets\AppAsset']]);
?>

<div class="templatemo-content-wrapper">
	<div class="templatemo-content">
		<ol class="breadcrumb">
			<li><a href="<?= Url::toRoute ( 'my/index' ); ?>">个人中心</a></li>
			<li><a href="#">个人信息</a></li>
			<li class="active">账号管理</li>
		</ol>
		<h1>账号管理</h1>

		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<?php $form = ActiveForm::begin ( [ 'id' => 'account-form', 'class' => 'form-control' ] ); ?>
					<table class="table table-bordered">
						<tr>
							<td width="10%">邮箱</td>
							<td><?= Html::encode ($model->email); ?></td>
						</tr>
						<tr>
							<td width="10%">注册时间</td>
							<td><?= date('Y-m-d H:i:s', $model->regtime); ?></td>
						</tr>
						<tr>
							<td width="10%">最后登录时间</td>
							<td><?= date('Y-m-d H:i:s', $model->loginTime); ?></td>
						</tr>
					</table>
					<?php ActiveForm::end (); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
$js = <<<JS
    // 取消订单
    $(".cancelOrder").click(function(){
        var orderId = $(this).data('id');
        console.log('orderId:' + orderId);
    });
JS;
$this->registerJs ($js);
?>
