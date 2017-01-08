<?php

/* @var $this yii\web\View */


use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = '添加商品_商品管理' . Yii::$app->params[ 'siteName' ];
// 设置 keywords
$this->registerMetaTag ( [ 'name' => 'keywords', 'content' => '' ] );
// 设置description
$this->registerMetaTag ( [ 'name' => 'description', 'content' => '' ] );
?>
<div class="templatemo-content-wrapper">
	<div class="templatemo-content">
		<ol class="breadcrumb">
			<li><a href="<?= Url::toRoute ( 'site/index' ); ?>">后台管理</a></li>
			<li><a href="<?= Url::toRoute('goods/index'); ?>">商品管理</a></li>
			<li class="active"><?php if(isset($model->id) and $model->id > 0):?>编辑<?php else: ?>添加<?php endif; ?>商品</li>
		</ol>
		<h1><?php if(isset($model->id) and $model->id > 0):?>编辑<?php else: ?>添加<?php endif; ?>商品</h1>
		<p class="margin-bottom-15">readme:</p>
		<div class="row">
			<div class="col-md-12">
				<ul class="nav nav-pills">
					<li role="presentation"><a href="<?= Url::toRoute('goods/index'); ?>">全部</a></li>
					<li role="presentation" class="active"><a href="<?= Url::toRoute('goods/add')?>">添加商品</a></li>
				</ul>

				<?php $form = ActiveForm::begin(['id' => 'login-form', 'class'=>'form-control']); ?>
                    <div class="form-group">
                        <?= $form->field($model, 'name')->textInput() ?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model, 'price')->textInput() ?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model, 'stock')->textInput() ?>
                    </div>

					<div class="row templatemo-form-buttons">
						<div class="col-md-12">
							<button type="submit" class="btn btn-primary"><?php if(isset($model->id) and $model->id > 0):?>编辑<?php else: ?>添加<?php endif; ?></button>
							<button type="reset" class="btn btn-default">重置</button>
						</div>
					</div>
					<?php if(isset($model->id) and $model->id > 0): ?>
						<input type="hidden" name="goodsId" value="<?= $model->id; ?>">
					<?php endif; ?>
				<?php ActiveForm::end(); ?>
			</div>
		</div>
	</div>
</div>