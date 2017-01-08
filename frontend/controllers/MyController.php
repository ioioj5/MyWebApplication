<?php
namespace frontend\controllers;

use common\components\FrontController;

class MyController extends FrontController {
	/**
	 * 我的首页
	 */
	public function actionIndex () {
		return $this->render ( 'index' );
	}
}