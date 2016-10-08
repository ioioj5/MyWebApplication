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
					<td><?= $val['name']; ?></td>
					<td><?= $val['num']; ?></td>
					<td>
						<a href="javascript:void(0);" class="btn btn-link">-</a>
						<a href="javascript:void(0);" class="btn btn-link">+</a>
						<a href="javascript:void(0);" class="removeCart btn btn-link" data-id="<?= $val['id']; ?>">删除全部</a>
					</td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
	</table>
</div>