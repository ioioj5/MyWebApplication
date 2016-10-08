<?php

/* @var $this yii\web\View */
use yii\helpers\Html;


$this->title = 'Index';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">
    <table class="table table-condensed table-striped">
        <?php if(! empty($list['fields'])): ?>
			<?php foreach($list['fields'] as $key=>$val): ?>
				<tr>
					<td><?= $val->id; ?></td>
					<td><?= $val->name; ?></td>
					<td><a href="javascript:void(0);" class="btn btn-link addCart" data-id="<?= $val->id; ?>">加入购物车</a> <a href="javascript:void(0);" class="btn btn-link">购买</a></td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
    </table>
</div>

<?php
// 添加购物车url
$addCartUrl = \yii\helpers\Url::toRoute('ajax/add-cart');

$js = <<<JS
$(".addCart").click(function(){
	var goodsId = $(this).data('id');
	
	$.ajax({
	    url: '{$addCartUrl}',
	    data: {goodsId: goodsId},
	    type: 'post',
	    cache: false,
	    dataType: 'json',
	    
	    success: function(response){
	        if(response.code == 1) {
	            console.log(response.msg);
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