<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Sign in';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin([
	'id' => 'login-form',
	'options'=>['class'=>'form-horizontal templatemo-signin-form'],
	'fieldConfig' => [
		'template' => "{label}\n<div class=\"col-sm-10\">{input}</div>",
		'labelOptions' => ['class' => 'col-sm-2 control-label'],
	]
]); ?>
	<div class="form-group">
		<div class="col-md-12">
			<?= $form->field($model, 'username')->textInput(['autofocus' => true]); ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-12">
			<?= $form->field($model, 'password')->passwordInput() ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-12">
			<div class="col-sm-offset-2 col-sm-10">
				<?= $form->field($model, 'rememberMe')->checkbox() ?>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-12">
			<div class="col-sm-offset-2 col-sm-10">
				<?= Html::submitButton('Sign in', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
			</div>
		</div>
	</div>
<?php ActiveForm::end(); ?>
