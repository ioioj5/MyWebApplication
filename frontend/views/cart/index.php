<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
$this->title = 'Cart';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">
	<table class="table">
		<tr>
			<td>ID</td>
			<td>name</td>
			<td>num</td>
			<td>action</td>
		</tr>
		<?php if(! empty($list['fields'])): ?>
			<?php foreach($list['fields'] as $key=>$val): ?>
				<tr>
					<td><?= $val['id']; ?></td>
					<td><?= $val->goods->name; //['name']; ?></td>
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
	<a href="<?= \yii\helpers\Url::toRoute(['order/index']); ?>" class="btn btn-default">去结算</a>
</div>
<?php
// 更改购物车商品数量
$changeGoodsNumFromCart = \yii\helpers\Url::toRoute('ajax/change-goods-num');
$removeCart = \yii\helpers\Url::toRoute('ajax/remove-from-cart');

$js = <<<JS
// 减少购物车商品数量
$(".minusCart").click(function(){
	var cartId = $(this).data('id');
	
	$.ajax({
	    url: '{$changeGoodsNumFromCart}',
	    data: {cartId: cartId, act:'minus'},
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
// 增加购物车商品数量
$(".plusCart").click(function(){
	var cartId = $(this).data('id');
	
	$.ajax({
	    url: '{$changeGoodsNumFromCart}',
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
	    url: '{$removeCart}',
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