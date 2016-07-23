<?php
namespace backend\controllers;
use common\models\AdminLoginForm;
use Yii;
use yii\web\Controller;

class AuthController extends Controller {
	/**
	 * 登入
	 */
	public function actionSignIn(){
		if (!\Yii::$app->admin->isGuest) {
			return $this->goHome();
		}

		$model = new AdminLoginForm();
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			return $this->goBack();
		} else {
			return $this->render('sign-in', [
				'model' => $model,
			]);
		}
	}

	public function actionSignUp(){

	}
}