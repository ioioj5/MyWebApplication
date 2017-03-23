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
	[ 'label' => 'Setting' ]
];
$this->registerCssFile ( '@web/css/jquery.toast.min.css', ['depends'=>['frontend\assets\AppAsset']]);
?>
<div class="site-index">
    <div class="row">
        <!-- 我的订单 -->
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-yellow">
                <a href="<?= \yii\helpers\Url::toRoute(['my/address']); ?>">
                    <div class="panel-footer">
                        <span class="pull-left">address</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <!-- 我的订单 -->
    </div>
</div>

<?php
// 添加购物车url
$addCartUrl = \yii\helpers\Url::toRoute('ajax/add-cart');
$isGuest = Yii::$app->user->isGuest ? 1 : 0;
$signInUrl = \yii\helpers\Url::toRoute('auth/sign-in');
$js = <<<JS
$(".addCart").click(function(){
	var goodsId = $(this).data('id');
	// 检测用户登录状态
	if({$isGuest}) {
	    $.toast({
	        text:'请<a href="{$signInUrl}">登录</a>后,进行此操作',
	        position: 'bottom-right',
	    });
	    return false;
	}
	$.ajax({
	    url: '{$addCartUrl}',
	    data: {goodsId: goodsId},
	    type: 'post',
	    cache: false,
	    dataType: 'json',
	    
	    success: function(response){
	        if(response.code == 1) {
	            $.toast({
					text:response.msg,
					position: 'bottom-right',
				});
	            console.log(response.msg);
	        }else {
	            $.toast({
					text:response.msg,
					position: 'bottom-right',
				});
	        }
	    },
	    error: function(){
	        console.log('异常...');
	    }
	});
});
JS;
$this->registerJs ( $js );
?>