<?php

/* @var $this yii\web\View */

use yii\helpers\Url;

$this->title = '商品管理' . Yii::$app->params[ 'siteName' ];
// 设置 keywords
$this->registerMetaTag ( [ 'name' => 'keywords', 'content' => '' ] );
// 设置description
$this->registerMetaTag ( [ 'name' => 'description', 'content' => '' ] );
$this->registerCssFile ( '@web/css/jquery.toast.min.css', ['depends'=>['frontend\assets\AppAsset']]);
?>
<div class="templatemo-content-wrapper">
	<div class="templatemo-content">
		<ol class="breadcrumb">
			<li><a href="<?= Url::toRoute ( 'site/index' ); ?>">后台管理</a></li>
			<li><a href="#">商品管理</a></li>
			<li class="active">商品列表</li>
		</ol>
		<h1>商品列表</h1>
		<p>readme:</p>

		<div class="row">
			<div class="col-md-12">
				<ul class="nav nav-pills">
					<li role="presentation" class="active"><a href="#">全部</a></li>
					<li role="presentation"><a href="<?= Url::toRoute('goods/add')?>">添加商品</a></li>
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
							<th>商品名称</th>
                            <th>商品价格</th>
                            <th>商品库存</th>
							<th>添加时间</th>
							<th>Action</th>
						</tr>
						</thead>
						<tbody>
						<?php if(! empty($list['fields'])): ?>
						<?php foreach($list['fields'] as $key=>$val):?>
						<tr>
							<td><?= $val->id; ?></td>
							<td><?= $val->name; ?></td>
							<td><?= $val->price; ?></td>
                            <td><?= $val->stock; ?></td>
							<td><?= date('Y-m-d H:i:s', $val->postTime); ?></td>
							<td>
								<?php if($val->status == 0 or $val->status == 2): ?>
									<a href="javascript:void(0);" class="shelve" data-id="<?= $val->id; ?>">上架</a>
								<?php elseif($val->status == 1): ?>
									<a href="javascript:void(0);" class="off-shelve" data-id="<?= $val->id; ?>">下架</a>
								<?php endif; ?>
								<a href="<?= Url::toRoute(['goods/add', 'goodsId'=>$val->id]); ?>" class="btn btn-link">编辑</a>
								<a href="<?= Url::toRoute(['goods/delete', 'goodsId'=>$val->id]); ?>" class="btn btn-link">删除</a>
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
<?php
// AJAX: 更改商品上下架状态
$ajaxGoodsStatusUrl = Url::toRoute('goods/ajax-status');

$js = <<< JS
    // 上架, 下架
    $(".shelve,.off-shelve").click(function(){
        var goodsId = $(this).data('id'); // 商品id
        
        if(goodsId < 1) {
            $.toast({
                text:"缺少商品Id",
                position: 'bottom-right',
            });
            return false;
        }
        
        $.ajax({
            url: '{$ajaxGoodsStatusUrl}',
            data: {goodsId:goodsId},
            type: 'post',
            cache: false,
            dataType: 'json',
            
            success: function(response){
                if(response.code == 0) {
                    window.location.reload();
                }
                $.toast({
                    text:response.msg,
                    position: 'bottom-right',
                });
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log('异常: ' + jqXHR.responseText + jqXHR.status + jqXHR.readyState + jqXHR.statusText);
                console.log('textStatus: ' + textStatus);
                console.log('errorThrown: ' + errorThrown);
            }
        });
    });
JS;
$this->registerJs($js);