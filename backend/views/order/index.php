<?php

/* @var $this yii\web\View */

use yii\helpers\Url;

$this->title = '订单管理' . Yii::$app->params[ 'siteName' ];
// 设置 keywords
$this->registerMetaTag ( [ 'name' => 'keywords', 'content' => '' ] );
// 设置description
$this->registerMetaTag ( [ 'name' => 'description', 'content' => '' ] );
?>
<div class="templatemo-content-wrapper">
    <div class="templatemo-content">
        <ol class="breadcrumb">
            <li><a href="<?= Url::toRoute ( 'site/index' ); ?>">后台管理</a></li>
            <li><a href="#">订单管理</a></li>
            <li class="active">订单列表</li>
        </ol>
        <h1>订单列表</h1>
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
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>商品</th>
                            <th>单价</th>
                            <th>数量</th>
                            <th>实付款</th>
                            <th>交易状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
						<?php if ( ! empty( $list[ 'fields' ] ) ): ?>
							<?php foreach ( $list[ 'fields' ] as $key => $val ): ?>
                                <tr class="active">
                                    <td colspan="5">
                                        订单号:<?= $val->orderCode;?>,
                                        下单时间: <?= date('Y-m-d H:i:s', $val->postTime);?>
                                        <?php if($val->orderStatus > 1 and $val->payStatus  == 1): ?>
                                            支付时间: <?= date('Y-m-d H:i:s', $val->payTime); ?>
                                        <?php endif; ?>
                                    </td>
                                    <td colspan="2">
                                        <a href="javascript:void(0);">支付</a>
                                        <a href="javascript:void(0);">取消</a>
                                        <a href="javascript:void(0);">关闭</a>
                                        <!--通用功能-->
                                        <a href="javascript:void(0);">备注</a>
                                    </td>
                                </tr>
                                <?php if(isset($val->orderGoods) and ! empty($val->orderGoods)): ?>
                                    <?php $count = count($val->orderGoods); ?>
                                    <?php foreach($val->orderGoods as $k=>$v): ?>
                                    <tr>
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
                                                <a href="<?= Url::toRoute ( [ 'order/detail', 'orderId' => $val->id ] ); ?>">订单详情</a>
                                            </p>
                                        </td>
                                        <td rowspan="<?= $count; ?>"></td>
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