<?php

/* @var $this yii\web\View */

use yii\helpers\Url;

$this->title = '日志管理' . Yii::$app->params[ 'siteName' ];
// 设置 keywords
$this->registerMetaTag ( [ 'name' => 'keywords', 'content' => '' ] );
// 设置description
$this->registerMetaTag ( [ 'name' => 'description', 'content' => '' ] );

$css = <<<CSS
.info {background-color: #81D4FA;padding:5px;border-radius: 5px;color: black;}
CSS;
$this->registerCss ( $css );

?>
<div class="templatemo-content-wrapper">
	<div class="templatemo-content">
		<ol class="breadcrumb">
			<li><a href="<?= Url::toRoute ( 'site/index' ); ?>">后台管理</a></li>
			<li><a href="#">日志管理</a></li>
			<li class="active">日志列表</li>
		</ol>
		<h1>日志列表</h1>
		<p>
            <font class="normal">操作说明</font>：<br>
            1.只搜集前端(Frontend)信息.
        </p>
        <div class="row">
            <div class="col-md-12">
                <form action="<?= Url::toRoute(['log/index']); ?>" method="POST" class="form-inline">
                    <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->getCsrfToken();?>">
                    <a href="<?= Url::toRoute(['log/index']); ?>" class="btn btn-default col-xs-3 col-sm-2 col-md-2 col-lg-1">重置搜索</a>
                    <div class="form-group col-xs-4 col-sm-3 col-md-3 col-lg-2">
                        <select class="form-control" name="level">
                            <option value="0" <?php if(! isset($params['level']) or empty($params['level'])):?>selected<?php endif; ?>>错误级别</option>
                            <option value="8" <?php if(isset($params['level']) and $params['level'] == 8): ?>selected<?php endif; ?>>Trace</option>
                            <option value="4" <?php if(isset($params['level']) and $params['level'] == 4): ?>selected<?php endif; ?>>Info</option>
                            <option value="2" <?php if(isset($params['level']) and $params['level'] == 2): ?>selected<?php endif; ?>>Warning</option>
                            <option value="1" <?php if(isset($params['level']) and $params['level'] == 1): ?>selected<?php endif; ?>>Error</option>
                        </select>
                    </div>
                    <input class="btn btn-primary col-xs-2 col-sm-2 col-md-2 col-lg-1" type="submit" value="搜索">
                </form>
            </div>
        </div>
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<p>
						搜索共获得: <b><?php echo $total; ?></b> 条记录(共计 <b><?php echo $totalPage; ?></b> 页, 每页
						<b><?php echo $limit; ?></b> 条, 当前第 <b><?php echo $page; ?></b> 页)
					</p>
					<table class="table table-striped  table-bordered">
						<tbody>
                        <?php if(isset($list['fields']) and ! empty($list['fields'])): ?>
                        <?php foreach($list['fields'] as $key=>$val): ?>
                            <tr>
                                <td><?= $val->id; ?></td>
                                <td colspan="5">
                                    错误级别: <b><?php if($val->level==1):?><font class="danger"><?= \backend\models\Log::level($val->level); ?></font><?php else: ?><?= \backend\models\Log::level($val->level); ?><?php endif; ?></b>
                                    消息分类: <b><?= $val->category; ?></b>
                                    请求时间: <b><?= \common\components\Utils::udate ('Y-m-d H:i:s.u T', $val->log_time); ?></b> <br />
                                    <?php if(! empty($val->prefix)): ?>
                                        <?php //匹配ip,userId,sessionId ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6">
                                    <?= \yii\helpers\Html::encode ($val->message); ?>
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