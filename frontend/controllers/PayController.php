<?php
/**
 * Created by PhpStorm.
 * User: ioioj5
 * Date: 2017/4/7
 * Time: 22:51
 */

namespace frontend\controllers;


use common\components\FrontController;

class PayController extends FrontController {
	/**
	 * 选择支付方式
	 * @return string
	 */
	public function actionIndex(){
		return $this->render('index');
	}
}