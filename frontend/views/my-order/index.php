<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;


$this->title = '我的订单_订单管理';
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

<div class="templatemo-content-wrapper">
    <div class="templatemo-content">
        <ol class="breadcrumb">
            <li><a href="<?= Url::toRoute ( 'my/index' ); ?>">个人中心</a></li>
            <li><a href="#">订单管理</a></li>
            <li class="active">订单列表</li>
        </ol>
        <h1>订单列表</h1>

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <p>
                        搜索共获得: <b><?php echo $total; ?></b> 条记录(共计 <b><?php echo $totalPage; ?></b> 页, 每页 <b><?php echo $limit; ?></b> 条, 当前第 <b><?php echo $page; ?></b> 页)
                    </p>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>商品</th>
                            <th>单价</th>
                            <th>数量</th>
                            <th>实付款</th>
                            <th>交易状态</th>
                        </tr>
                        </thead>
                        <tbody class="list">
						<?php if ( ! empty( $list[ 'fields' ] ) ): ?>
							<?php foreach ( $list[ 'fields' ] as $key => $val ): ?>
                                <tr class="active tableRow">
                                    <td colspan="5">
                                        订单号:<?= $val->orderCode;?>,
                                        下单时间: <?= date('Y-m-d H:i:s', $val->postTime);?>
										<?php if($val->orderStatus > 1 and $val->payStatus  == 1): ?>
                                            支付时间: <?= date('Y-m-d H:i:s', $val->payTime); ?>
										<?php endif; ?>
                                    </td>
                                    <td colspan="2">
                                        <a href="javascript:void(0);"  data-id="<?= $val->id; ?>">支付</a>
                                        <a href="javascript:void(0);" class="cancelOrder" data-id="<?= $val->id; ?>">取消</a>
                                        <!--通用功能-->
                                        <a href="javascript:void(0);">备注</a>
                                    </td>
                                </tr>
								<?php if(isset($val->orderGoods) and ! empty($val->orderGoods)): ?>
									<?php $count = count($val->orderGoods); ?>
									<?php foreach($val->orderGoods as $k=>$v): ?>
                                        <tr class="tableRow"">
                                            <td><?= $v->id; ?></td>
                                            <td><?= $v->goodsName; ?></td>
                                            <td><?= $v->price; ?></td>
                                            <td><?= $v->num; ?></td>
											<?php if($k == 0): ?>
                                                <td rowspan="<?= $count; ?>"><?= $val->price; ?></td>
                                                <td rowspan="<?= $count; ?>">
                                                    <p>
														<?= \backend\models\Order::orderStatus($val->orderStatus); ?>
														<?php if($val->orderStatus == 7): ?>
                                                            ( <?= $val->orderCloseReasonLog->remarks; ?> )
														<?php endif; ?>
                                                    </p>
                                                    <p>
                                                        <a href="<?= Url::toRoute ( [ 'my-order/detail', 'orderId' => $val->id ] ); ?>">订单详情</a>
                                                    </p>
                                                </td>
											<?php endif; ?>
                                        </tr>
									<?php endforeach; ?>
								<?php endif; ?>
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
$js = <<<JS
    // 取消订单
    $(".cancelOrder").click(function(){
        var orderId = $(this).data('id');
        console.log('orderId:' + orderId);
    });
JS;
$this->registerJs ($js);
?>
