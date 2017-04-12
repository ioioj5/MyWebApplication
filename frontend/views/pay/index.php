<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
$this->title = 'Pay';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile ( '@web/css/jquery.toast.min.css', ['depends'=>['frontend\assets\AppAsset']]);

?>
<div class="site-index">
    <div class="panel panel-default">
        <div class="panel-heading">请选择支付方式</div>
        <div class="panel-body">
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-default active">
                    <input type="radio" name="payType" value="1" autocomplete="off" checked>货到付款
                </label>
                <label class="btn btn-default">
                    <input type="radio" name="payType" value="2" autocomplete="off"> 支付宝支付
                </label>
                <label class="btn btn-default">
                    <input type="radio" name="payType" value="3" autocomplete="off"> 微信支付
                </label>
            </div>
        </div>
        <div class="panel-footer">
            <button class="btn btn-primary">付款</button>
            <a class="btn btn-default" href="<?= \yii\helpers\Url::toRoute(['site/index'])?>">返回首页</a>
        </div>
    </div>
</div>

