<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
$this->title = 'Order';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile ( '@web/css/jquery.toast.min.css', ['depends'=>['frontend\assets\AppAsset']]);

?>
<div class="site-index">

    <div class="text-left">
        <h1 class="txt">正在排队, 请耐心等待.</h1>
    </div>
</div>
<?php
$waitingUrl = \yii\helpers\Url::toRoute(['order/waiting']);
$js = <<<JS
var i = 0;
$(document).ready(function(){
    setInterval("$.waiting()", 1000);
});
$.waiting = function(){
    $.ajax({
        url: '{$waitingUrl}',
        data: {},
        type: 'get',
        cache: false,
        dataType: 'json',
        
        success: function(response){
            if(response.code == 0) {
                $(".txt").html(response.msg);
                
            }else {
                $(".txt").text(response.msg);
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log('异常: ' + jqXHR.responseText + jqXHR.status + jqXHR.readyState + jqXHR.statusText);
            console.log('textStatus: ' + textStatus);
            console.log('errorThrown: ' + errorThrown);
        }
    });
    ///console.log(i);
    if(i % 5 == 0) {
        $(".txt").text("正在排队, 请耐心等待.");
    }else {
        $(".txt").append(".");
    }
    i++;
}
JS;
$this->registerJs ( $js );
?>
