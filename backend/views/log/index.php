<?php

/* @var $this yii\web\View */

use yii\helpers\Url;

$this->title = '日志管理' . Yii::$app->params[ 'siteName' ];
// 设置 keywords
$this->registerMetaTag ( [ 'name' => 'keywords', 'content' => '' ] );
// 设置description
$this->registerMetaTag ( [ 'name' => 'description', 'content' => '' ] );
?>
<div class="templatemo-content-wrapper">
	<div class="templatemo-content">
		<ol class="breadcrumb">
			<li><a href="<?= Url::toRoute ( 'site/index' ); ?>">后台管理</a></li>
			<li><a href="#">日志管理</a></li>
			<li class="active">日志列表</li>
		</ol>
		<h1>日志列表</h1>
		<p>readme:</p>

		<div class="row">
			<div class="col-md-12">
				<ul class="nav nav-pills">
					<li role="presentation" class="active"><a href="#">全部</a></li>
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
							<th>错误级别</th>
							<th>消息分类</th>
							<th>时间</th>
							<th>消息前缀</th>
							<th>主体</th>
						</tr>
						</thead>
						<tbody>
                        <?php if(isset($list['fields']) and ! empty($list['fields'])): ?>
                        <?php foreach($list['fields'] as $key=>$val): ?>
                            <tr>
                                <td><?= $val->id; ?></td>
                                <td><?= $val->level; ?></td>
                                <td><?= $val->category; ?></td>
                                <td><?= \common\components\Utils::udate ('Y-m-d H:i:s.u T', $val->log_time); ?></td>
                                <td><?= $val->prefix; ?></td>
                                <td><?= $val->message; ?></td>
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