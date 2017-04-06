<?php
namespace api\controllers;
/**
 * Created by PhpStorm.
 * User: ioioj5
 * Date: 2017/4/6
 * Time: 22:51
 */
class SiteController extends \common\components\FrontController {
	public function actionIndex(){
		return $this->render('index');
	}
	public function actionAbout(){
		return $this->render('about');
	}
}