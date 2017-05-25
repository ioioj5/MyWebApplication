<?php

/* @var $this yii\web\View */

use yii\helpers\Url;

$this->title = '订单管理_订单详情' . Yii::$app->params[ 'siteName' ];
// 设置 keywords
$this->registerMetaTag ( [ 'name' => 'keywords', 'content' => '' ] );
// 设置description
$this->registerMetaTag ( [ 'name' => 'description', 'content' => '' ] );
?>
<div class="templatemo-content-wrapper">
    <div class="templatemo-content">
        <ol class="breadcrumb">
            <li><a href="<?= Url::toRoute ( 'my/index' ); ?>">个人中心</a></li>
            <li><a href="<?= Url::toRoute('my-order/index'); ?>">订单管理</a></li>
            <li class="active">订单详情</li>
        </ol>
        <h1>订单详情</h1>

        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-default">
                    <div class="panel-heading">订单详情</div>
                    <div class="panel-body">
						<table class="table table-bordered">
							<tr>
								<td width="10%">订单号</td>
								<td width="30%"><?= $orderInfo->orderCode;?></td>
								<td width="10%">订单状态</td>
								<td width="20%">
								<b><?= \backend\models\Order::orderStatus($orderInfo->orderStatus); ?></b>
								<?php if($orderInfo->orderStatus == 7): ?>
									( <?= $orderInfo->orderCloseReasonLog->remarks; ?> )
								<?php endif; ?>
								</td>
								<td width="10%">下单时间</td>
								<td width="20%"><?= date("Y-m-d H:i:s", $orderInfo->postTime);?></td>
							</tr>
							<tr>
							    <td width="10%">购买者</td>
							    <td width="30%">
							        <?= $orderInfo->userId; ?>&nbsp;&nbsp;(<?= $orderInfo->userInfo->email; ?>)
                                    <?php if($orderInfo->userInfo->status == 0): ?>
                                        <span class="label label-danger">关闭</span>
                                    <?php else: ?>
                                        <span class="label label-success">正常</span>
                                    <?php endif; ?>
							    </td>
                                <td width="10%">支付时间</td>
                                <td width="20%">
                                    <?php if($orderInfo->payTime > 0 ): ?>
                                        <?= date('Y-m-d H:i:s', $orderInfo->payTime); ?>
                                    <?php else: ?>
                                        暂无
                                    <?php endif; ?>
                                </td>
                                <td width="10%">订单价格</td>
                                <td width="20%"><b><?= $orderInfo->price; ?></b></td>
							</tr>
							<tr>
								<td width="10%">操作</td>
								<td colspan="5">
                                    <a href="javascript:void(0);">支付</a>
                                    <a href="javascript:void(0);">取消</a>
                                    <a href="javascript:void(0);">关闭</a>
                                    <!--通用功能-->
                                    <a href="javascript:void(0);">备注</a>
                                </td>
							</tr>
						</table>
                    </div>

                    <div class="panel-heading">商品信息</div>
                    <div class="panel-body">
                    <table class="table table-bordered">
                        <tr>
                            <td width="10%">ID</td>
                            <td width="10%">商品Id</td>
                            <td width="60%">商品名称</td>
                            <td width="10%">商品价格</td>
                            <td width="10%">商品数量</td>
                        </tr>
                        <?php if(isset($orderInfo->orderGoods) and ! empty($orderInfo->orderGoods)): ?>
                            <?php foreach($orderInfo->orderGoods as $key=>$val): ?>
                                <tr>
                                    <td><?= $val->id; ?></td>
                                    <td><?= $val->goodsId; ?></td>
                                    <td><?= $val->goodsName; ?></td>
                                    <td><?= $val->price; ?></td>
                                    <td><?= $val->num; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </table>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">订单日志</div>
                    <div class="panel-body">
                        <table class="table">
                            <tr>
                                <td width="20%">时间</td>
                                <td>状态/原因</td>
                            </tr>
							<?php if(isset($orderInfo->orderLog) and ! empty($orderInfo->orderLog)):?>
								<?php foreach($orderInfo->orderLog as $val):?>
                                    <tr>
                                        <td><?= date('Y-m-d H:i:s', $val->postTime); ?></td>
                                        <td>
											<?= \backend\models\Order::orderStatus($val->orderStatus); ?>
											<?php if(isset($val->remarks) and ! empty($val->remarks)):?>
                                                ( <?= $val->remarks; ?> )
											<?php endif; ?>
                                        </td>
                                    </tr>
								<?php endforeach; ?>
							<?php endif; ?>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>