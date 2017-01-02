<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
$this->title = 'Cart';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile ( '@web/css/jquery.toast.min.css', ['depends'=>['frontend\assets\AppAsset']]);
?>
<div class="site-index">
	<table class="table">
		<tr>
			<td>ID</td>
			<td>商品名称</td>
            <td>单价</td>
			<td>数量</td>
			<td>操作</td>
		</tr>
		<?php if(! empty($list['fields'])): ?>
			<?php foreach($list['fields'] as $key=>$val): ?>
				<tr>
					<td><input type="checkbox" class="selectGoods" value="<?= $val['id']; ?>" <?php if($val['isChecked'] == 1): ?>checked<?php endif; ?>></td>
					<td><?= $val->goods->name; //['name']; ?></td>
                    <td><?= $val->goods->price; ?></td>
					<td id="goodsNum<?= $val['id']; ?>"><?= $val['num']; ?></td>
					<td>
						<a href="javascript:void(0);" class="btn btn-link minusCart" data-id="<?= $val['id']; ?>">-</a>
						<a href="javascript:void(0);" class="btn btn-link plusCart" data-id="<?= $val['id']; ?>">+</a>
						<a href="javascript:void(0);" class="removeCart btn btn-link removeCart" data-id="<?= $val['id']; ?>">删除全部</a>
					</td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
	</table>
    <div class="pull-right">
        <a href="<?= \yii\helpers\Url::toRoute(['order/index']); ?>" class="btn btn-default toSettleAccounts">去结算</a>
    </div>
</div>
<?php
// 更改购物车商品数量
$changeGoodsNumFromCartUrl = \yii\helpers\Url::toRoute('ajax/change-goods-num');
// 从购物车删除商品
$removeCartUrl = \yii\helpers\Url::toRoute('ajax/remove-from-cart');
// 选中购物车商品
$selectGoodsInCartUrl = \yii\helpers\Url::toRoute('ajax/select-goods-in-cart');
$js = <<<JS
// 选中商品
$(".selectGoods").click(function(){
    var cartId = $(this).val();
    var act = null;
    if($(this).is(":checked")) {
        act = 'checked';
    }else {
        act = 'unchecked';
    }
    $.ajax({
	    url: '{$selectGoodsInCartUrl}',
	    data: {cartId: cartId, act:act},
	    type: 'post',
	    cache: false,
	    dataType: 'json',
	    
	    success: function(response){
	        if(response.code == 1) {
	            $.toast({
					text:response.msg,
					position: 'bottom-right',
				});
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
// 减少购物车商品数量
$(".minusCart").click(function(){
	var cartId = $(this).data('id');
	
	$.ajax({
	    url: '{$changeGoodsNumFromCartUrl}',
	    data: {cartId: cartId, act:'minus'},
	    type: 'post',
	    cache: false,
	    dataType: 'json',
	    
	    success: function(response){
	        if(response.code == 1) {
	            console.log(response.msg);
	        }else {
	            if(response.data.num > 0) {
	                $("#goodsNum" + cartId).text(response.data.num);
	            }else {
	                $("#goodsNum" + cartId).parent().remove();
	                // $(".toSettleAccounts").attr("disabled");
	            }
	        }
	    },
	    error: function(){
	        console.log('异常...');
	    }
	});
});
// 增加购物车商品数量
$(".plusCart").click(function(){
	var cartId = $(this).data('id');
	
	$.ajax({
	    url: '{$changeGoodsNumFromCartUrl}',
	    data: {cartId: cartId, act:'plus'},
	    type: 'post',
	    cache: false,
	    dataType: 'json',
	    
	    success: function(response){
	        if(response.code == 1) {
	            console.log(response.msg);
	        }else {
	            $("#goodsNum" + cartId).text(response.data.num);
	        }
	    },
	    error: function(){
	        console.log('异常...');
	    }
	});
});
// 从购物车删除商品
$(".removeCart").click(function(){
	var cartId = $(this).data('id');
	
	$.ajax({
	    url: '{$removeCartUrl}',
	    data: {cartId: cartId},
	    type: 'post',
	    cache: false,
	    dataType: 'json',
	    
	    success: function(response){
	        if(response.code == 1) {
	            console.log(response.msg);
	        }else {
	            //$("#goodsNum" + cartId).text(response.data.num);
	            window.location.reload();
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