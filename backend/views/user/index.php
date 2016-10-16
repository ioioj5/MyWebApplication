<?php

/* @var $this yii\web\View */

use yii\helpers\Url;

$this->title = '用户管理' . Yii::$app->params[ 'siteName' ];
// 设置 keywords
$this->registerMetaTag ( [ 'name' => 'keywords', 'content' => '' ] );
// 设置description
$this->registerMetaTag ( [ 'name' => 'description', 'content' => '' ] );
?>
<div class="templatemo-content-wrapper">
	<div class="templatemo-content">
		<ol class="breadcrumb">
			<li><a href="<?= Url::toRoute ( 'site/index' ); ?>">后台管理</a></li>
			<li><a href="#">用户管理</a></li>
			<li class="active">用户列表</li>
		</ol>
		<h1>用户列表</h1>
		<p>readme:</p>

		<div class="row">
			<div class="col-md-12">
				<ul class="nav nav-pills">
					<li role="presentation" class="active"><a href="#">全部</a></li>
					<li role="presentation"><a href="<?= Url::toRoute('user/add')?>">添加用户</a></li>
				</ul>
				<div class="table-responsive">
					<p>
						搜索共获得: <b><?php echo $total; ?></b> 条记录(共计 <b><?php echo $totalPage; ?></b> 页, 每页
						<b><?php echo $limit; ?></b> 条, 当前第 <b><?php echo $page; ?></b> 页)
					</p>
					<table class="table table-striped table-hover table-bordered">
						<thead>
						<tr>
							<th>#</th>
							<th>email</th>
							<th>regtime</th>
							<th>status</th>
							<th>Action</th>
						</tr>
						</thead>
						<tbody>
						<?php if(! empty($list['fields'])): ?>
						<?php foreach($list['fields'] as $key=>$val):?>
						<tr>
							<td><?= $val->id; ?></td>
							<td><?= $val->email; ?></td>
							<td><?= date('Y-m-d H:i:s', $val->regtime); ?></td>
							<td><?= $val->status; ?></td>
							<td>
								<?php if($val->status == 0 ): ?>
									<a href="">解封</a>
								<?php elseif($val->status == 1): ?>
									<a href="">封禁</a>
								<?php endif; ?>
								<a href="<?= Url::toRoute(['user/add', 'goodsId'=>$val->id]); ?>" class="btn btn-link">编辑</a>
								<a href="<?= Url::toRoute(['user/delete', 'goodsId'=>$val->id]); ?>" class="btn btn-link">删除</a>
							</td>
						</tr>
						<?php endforeach; ?>
						<?php endif; ?>
						</tbody>
					</table>
				</div>
				<ul class="pagination pull-right">
					<?= $navbar; ?>
				</ul>
			</div>
		</div>
	</div>
</div>