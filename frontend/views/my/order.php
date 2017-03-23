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
    ['label'=>'Order']
];
$this->registerCssFile ( '@web/css/jquery.toast.min.css', ['depends'=>['frontend\assets\AppAsset']]);
?>
<div class="site-index">

    <div class="panel panel-default">
        <div class="panel-heading">
            搜索共获得: <b><?php echo $total; ?></b> 条记录(共计 <b><?php echo $totalPage; ?></b> 页, 每页 <b><?php echo $limit; ?></b> 条, 当前第 <b><?php echo $page; ?></b> 页)
        </div>
        <div class="panel-body">

        </div>
        <table class="table table-condensed table-striped">
            <tr>
                <td>订单号</td>
                <td>价格</td>
                <td>支付状态</td>
                <td>订单状态</td>
                <td>下单时间</td>
                <td>操作</td>
            </tr>
			<?php if(isset($list) and ! empty($list)): ?>
				<?php foreach($list['fields'] as $key=>$val): ?>
                    <tr>
                        <td>
                            <a href="<?= \yii\helpers\Url::toRoute(['my/order-details', 'orderId'=>$val->id]); ?>" title="点击查看订单详情">
                            <?= $val->orderCode; ?>
                            </a>
                        </td>
                        <td><?= $val->price; ?></td>
                        <td>
							<?php if ( $val->payStatus == 1 ): ?>
                                已支付
                            <?php else: ?>
                                未支付
							<?php endif; ?>
                        </td>
                        <td>
							<?= \backend\models\Order::orderStatus($val->orderStatus); ?>
							<?php if($val->orderStatus == 7): ?>
                                ( <?= $val->orderLog->remarks; ?> )
							<?php endif; ?>
                        </td>
                        <td><?= date('Y-m-d H:i:s', $val->postTime); ?></td>
                        <td>

                        </td>
                    </tr>
				<?php endforeach; ?>
			<?php endif; ?>
        </table>
        <!--分页-->
        <nav aria-label="Page navigation" class="text-right">
            <ul class="pagination"><?= $navbar; ?></ul>
        </nav>
        <!--分页-->
    </div>

</div>