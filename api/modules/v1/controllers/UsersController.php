<?php

namespace api\modules\v1\controllers;

use common\components\ApiBaseController;
use Yii;
use yii\web\NotFoundHttpException;

class UsersController extends ApiBaseController {
	/**
	 * 登入
	 */
	public function actionSignIn () {
		if ( Yii::$app->request->isPost ) {
			$email    = trim ( Yii::$app->request->post ( 'email' ) );
			$password = trim ( Yii::$app->request->post ( 'password' ) );

			if ( ! empty( $email ) ) {

			} else {
				throw new NotFoundHttpException( "请填写邮箱.", 1 );
			}
			if ( ! empty( $password ) ) {

			} else {
				throw new NotFoundHttpException( "请填写密码.", 1 );
			}
		}
	}

	/**
	 * 注册
	 */
	public function actionSignUp () {

	}
}