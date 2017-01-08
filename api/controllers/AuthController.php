<?php
namespace frontend\controllers;
use common\models\LoginForm;
use common\models\SignupForm;
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
	public function actionSignUp(){
		$model = new SignupForm ();
		if ( $model->load ( Yii::$app->request->post () ) ) {
			if ( $user = $model->signup () ) {
				if ( Yii::$app->getUser ()->login ( $user ) ) {
					return $this->goHome ();
				}
			}
		}

		return $this->render ( 'sign-up', [
			'model' => $model
		] );
	}

	/**
	 * 登出
	 */
	public function actionLogout(){

		Yii::$app->user->logout ();

		return $this->goHome ();
	}
}