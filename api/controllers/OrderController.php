<?php
namespace api\controllers;


use common\components\ApiBaseController;
use Yii;

class OrderController extends ApiBaseController {
	/**
	 * 异步通知
	 */
	public function actionNotify(){
		if(Yii::$app->request->isPost) {

		}
	}
}