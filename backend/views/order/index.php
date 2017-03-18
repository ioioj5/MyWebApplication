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
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>订单号</th>
                            <th>价格</th>
                            <th>下单时间</th>
                            <th>订单状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
						<?php if ( ! empty( $list[ 'fields' ] ) ): ?>
							<?php foreach ( $list[ 'fields' ] as $key => $val ): ?>
                                <tr>
                                    <td><?= $val->id; ?></td>
                                    <td><?= $val->orderCode; ?></td>
                                    <td><?= $val->price; ?></td>
                                    <td><?= date ( 'Y-m-d H:i:s', $val->postTime ); ?></td>
                                    <td>
                                        <?= \backend\models\Order::orderStatus($val->orderStatus); ?>
                                        <?php if($val->orderStatus == 7): ?>
                                            ( <?= $val->orderLog->remarks; ?> )
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= Url::toRoute ( [ 'order/detail', 'orderId' => $val->id ] ); ?>">订单详情</a>
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