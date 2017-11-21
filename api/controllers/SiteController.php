<?php

namespace api\controllers;

use Yii;
use yii\web\Response;

/**
 * Created by PhpStorm.
 * User: ioioj5
 * Date: 2017/4/6
 * Time: 22:51
 */
class SiteController extends \common\components\FrontController {
	public function actionIndex () {
		return $this->render ( 'index' );
	}

	public function actionAbout () {
		return $this->render ( 'about' );
	}

	public function actionError () {
		$exception = Yii::$app->errorHandler->exception;

		if($exception != null) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			Yii::$app->response->data   = [
				'code'   => $exception->getCode (),
				'msg'    => $exception->getMessage (),
				'status' => $exception->statusCode,
			];
			return Yii::$app->response;
		}
	}
}