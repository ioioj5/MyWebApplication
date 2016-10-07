<?php
namespace backend\controllers;
use common\models\AdminLoginForm;
use Yii;
use yii\web\Controller;

class AuthController extends Controller {
	public $layout = 'login';
	/**
	 * 登入
	 */
	public function actionSignIn(){
		$model = new AdminLoginForm();
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			$this->redirect(['site/index']);
		} else {
			return $this->render('sign-in', [
				'model' => $model,
			]);
		}
	}

	/**
	 * 登出
	 */
	public function actionSignOut(){
		Yii::$app->user->logout ();

		$this->redirect(['auth/sign-in']);
	}
}