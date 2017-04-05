<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
$this->title = 'Order';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile ( '@web/css/jquery.toast.min.css', ['depends'=>['frontend\assets\AppAsset']]);

?>
<div class="site-index">
正在排队, 请耐心等待.
</div>
<?php
$this->registerJsFile ( '@web/js/socket.js' );

$js = <<<JS
var socket = io('http://localhost');
  socket.on('news', function (data) {
    console.log(data);
    socket.emit('my other event', { my: 'data' });
  });
JS;
$this->registerJs ( $js );
?>
