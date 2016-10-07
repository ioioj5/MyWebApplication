<?php
/**
 * Created by PhpStorm.
 * User: ioioj5
 * Date: 2016/10/6
 * Time: 23:05
 */

namespace backend\controllers;


use common\components\AdminBaseController;
use Yii;

class ErrorController extends AdminBaseController {
	public $layout = 'login';
	public function actions () {
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
		];
	}

	public function actionIndex () {
		$exception = Yii::$app->errorHandler->exception;
		if ( $exception !== null ) {
			return $this->render ( 'index', [ 'exception' => $exception ] );
		}
	}
}