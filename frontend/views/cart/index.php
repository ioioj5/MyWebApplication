<?php

/* @var $this yii\web\View */
use yii\helpers\Html;


$this->title = 'Cart';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">
	<table class="table">
		<?php if(! empty($list['fields'])): ?>
			<?php foreach($list['fields'] as $key=>$val): ?>
				<tr>
					<td><?= $val->id; ?></td>
					<td><a href="javascript:void(0);" class="addCart" data-id="<?= $val->id; ?>">加入购物车</a> <a href="javascript:void(0);">购买</a></td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
	</table>
</div>