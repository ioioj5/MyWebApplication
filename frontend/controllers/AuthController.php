<?php
namespace frontend\controllers;
use common\models\LoginForm;
use Yii;
use yii\web\Controller;

class AuthController extends Controller {
	/**
	 * 登入
	 */
	public function actionSignIn(){
		if ( ! \Yii::$app->user->isGuest ) {
			return $this->goHome ();
		}

		$model = new LoginForm ();
		if ( $model->load ( Yii::$app->request->post () ) && $model->login () ) {
			return $this->goBack ();
		} else {
			return $this->render ( 'sign-in', [
				'model' => $model
			] );
		}
	}
	/**
	 * 注册
	 **/
	public function actionSignUp(){}

	/**
	 * 登出
	 */
	public function actionLogout(){

		Yii::$app->user->logout ();

		return $this->goHome ();
	}
}