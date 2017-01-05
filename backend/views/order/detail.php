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
            <li><a href="<?= Url::toRoute ( 'site/index' ); ?>">后台管理</a></li>
            <li><a href="<?= Url::toRoute('order/index'); ?>">订单管理</a></li>
            <li class="active">订单详情</li>
        </ol>
        <h1>订单详情</h1>
        <p>readme:</p>

        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-default">
                    <div class="panel-heading">订单详情</div>
                    <div class="panel-body">
                        Panel content
                    </div>
                    <table class="table">
                        <tr>
                            <td>ID</td>
                            <td>商品Id</td>
                            <td>商品名称</td>
                            <td>商品价格</td>
                            <td>商品数量</td>
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

            </div>
        </div>
    </div>
</div>