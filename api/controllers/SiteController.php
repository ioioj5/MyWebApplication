<?php
namespace api\controllers;
use Yii;

/**
 * Created by PhpStorm.
 * User: ioioj5
 * Date: 2017/4/6
 * Time: 22:51
 */
class SiteController extends \common\components\FrontController {
	public function actions()
	{
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
			'captcha' => [
				'class' => 'yii\captcha\CaptchaAction',
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
		];
	}
	public function actionIndex(){
		return $this->render('index');
	}
	public function actionAbout(){
		return $this->render('about');
	}

	public function actionError(){
		$exception = Yii::$app->errorHandler->exception;
		if ($exception !== null) {
			return $this->render('error', ['exception' => $exception]);
		}
	}
}