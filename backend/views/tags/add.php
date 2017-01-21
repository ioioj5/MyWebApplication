<?php

/* @var $this yii\web\View */


use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = '添加标签_标签管理' . Yii::$app->params[ 'siteName' ];
// 设置 keywords
$this->registerMetaTag ( [ 'name' => 'keywords', 'content' => '' ] );
// 设置description
$this->registerMetaTag ( [ 'name' => 'description', 'content' => '' ] );
?>
<div class="templatemo-content-wrapper">
	<div class="templatemo-content">
		<ol class="breadcrumb">
			<li><a href="<?= Url::toRoute ( 'site/index' ); ?>">后台管理</a></li>
			<li><a href="<?= Url::toRoute('tags/index'); ?>">标签管理</a></li>
			<li class="active"><?php if(isset($model->id) and $model->id > 0):?>编辑<?php else: ?>添加<?php endif; ?>标签</li>
		</ol>
		<h1><?php if(isset($model->id) and $model->id > 0):?>编辑<?php else: ?>添加<?php endif; ?>标签</h1>
		<p class="margin-bottom-15">readme:</p>
		<div class="row">
			<div class="col-md-12">
				<ul class="nav nav-pills">
					<li role="presentation"><a href="<?= Url::toRoute('tags/index'); ?>">全部</a></li>
					<li role="presentation" class="active"><a href="<?= Url::toRoute('tags/add')?>">添加标签</a></li>
				</ul>

				<?php $form = ActiveForm::begin(['id' => 'login-form', 'class'=>'form-control']); ?>
                    <div class="form-group">
                        <?= $form->field($model, 'tagName')->textInput() ?>
                    </div>

					<div class="row templatemo-form-buttons">
						<div class="col-md-12">
							<button type="submit" class="btn btn-primary"><?php if(isset($model->id) and $model->id > 0):?>编辑<?php else: ?>添加<?php endif; ?></button>
							<button type="reset" class="btn btn-default">重置</button>
						</div>
					</div>
					<?php if(isset($model->id) and $model->id > 0): ?>
						<input type="hidden" name="tagId" value="<?= $model->id; ?>">
					<?php endif; ?>
				<?php ActiveForm::end(); ?>
			</div>
		</div>
	</div>
</div>