<?php

/* @var $this yii\web\View */
use yii\helpers\Html;


$this->title = 'Index';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile ( '@web/css/jquery.toast.min.css', ['depends'=>['frontend\assets\AppAsset']]);
?>
<div class="site-index">
    <table class="table table-condensed table-striped">
        <tr>
            <td>#</td>
            <td>商品名称</td>
            <td>库存</td>
            <td>操作</td>
        </tr>
        <?php if(! empty($list['fields'])): ?>
			<?php foreach($list['fields'] as $key=>$val): ?>
				<tr>
					<td><?= $val->id; ?></td>
                    <td><?= $val->name; ?></td>
                    <td><?= $val->stock; ?></td>
					<td><a href="javascript:void(0);" class="btn btn-link addCart" data-id="<?= $val->id; ?>">加入购物车</a> <a href="javascript:void(0);" class="btn btn-link">购买</a></td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
    </table>
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