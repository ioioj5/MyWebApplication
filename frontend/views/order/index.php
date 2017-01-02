<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
$this->title = 'Order';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile ( '@web/css/jquery.toast.min.css', ['depends'=>['frontend\assets\AppAsset']]);
?>
<div class="site-index">
    <div class="panel panel-default">
        <div class="panel-heading">收货人信息<p class="pull-right"><a href="javascript:void(0);" class="addNewAddress">新增收获地址</a></p></div>
        <div class="panel-body">
            Panel content
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">支付方式</div>
        <div class="panel-body">
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-default active">
                    <input type="radio" name="options" id="option1" autocomplete="off" checked>货到付款
                </label>
                <label class="btn btn-default">
                    <input type="radio" name="options" id="option2" autocomplete="off"> 支付宝支付
                </label>
                <label class="btn btn-default">
                    <input type="radio" name="options" id="option3" autocomplete="off"> 微信支付
                </label>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">商品</div>
        <div class="panel-body">
            <p>1 件商品，总商品金额: ￥2199.00</p>
        </div>
        <table class="table">
            <tr>
                <td>ID</td>
                <td>商品名称</td>
                <td>单价</td>
                <td>数量</td>
            </tr>
			<?php if(! empty($list['fields'])): ?>
				<?php foreach($list['fields'] as $key=>$val): ?>
                    <tr>
                        <td><?= $val['id']; ?></td>
                        <td><?= $val->goods->name; //['name']; ?></td>
                        <td><?= $val->goods->price; ?></td>
                        <td id="goodsNum<?= $val['id']; ?>"><?= $val['num']; ?></td>
                    </tr>
				<?php endforeach; ?>
			<?php endif; ?>
        </table>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">配送方式</div>
        <div class="panel-body">
            Panel content
        </div>
    </div>

    <div class="pull-right">
        <a href="<?= \yii\helpers\Url::toRoute(['order/index']); ?>" class="btn btn-default">提交订单</a>
    </div>
</div>

<!-- modal -->
<div class="modal fade addNewAddressModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">新增收货人信息</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">收货人</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control name" placeholder="收货人姓名">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">地址</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control address" placeholder="详细地址">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">联系方式</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control contact" placeholder="手机号码">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary saveNewAddress" data-loading-text="保存中..." autocomplete="off">保存收货人信息</button>
            </div>
        </div>
    </div>
</div>
<!-- modal -->
<?php
// 新增收货人信息
$addNewAddressUrl = \yii\helpers\Url::toRoute('ajax/add-new-address');

$js = <<<JS
// 新增收获地址
$(".addNewAddress").click(function(){
    $('.addNewAddressModal').modal();
});

// 保存收货人信息
$(".saveNewAddress").click(function(){
    var btn = $(this).button('loading');
    var name = $(".name").val();
    var address = $(".address").val();
    var contact = $(".contact").val();
    
    if(name.length < 1) {
        $.toast({
            text:"收货人不能为空",
            position: 'bottom-right',
        });
        btn.button('reset');
        return false;
    }
    if(address.length < 1) {
        $.toast({
            text:"详细地址不能为空",
            position: 'bottom-right',
        });
        btn.button('reset');
        return false;
    }
    if(contact.length < 1) {
        $.toast({
            text:"联系方式不能为空",
            position: 'bottom-right',
        });
        btn.button('reset');
        return false;
    }
    
	$.ajax({
	    url: '{$addNewAddressUrl}',
	    data: {name:name, address:address, contact:contact},
	    type: 'post',
	    cache: false,
	    dataType: 'json',
	    
	    success: function(response){
	        if(response.code == 0) {
	            $('.addNewAddressModal').modal('hide');
	        }
            $.toast({
                text:response.msg,
                position: 'bottom-right',
            });
	    },
	    error: function(){
	        console.log('异常...');
	    }
	});
    // btn.button('reset');
});
JS;
$this->registerJs ( $js );
?>