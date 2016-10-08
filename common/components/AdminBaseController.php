<?php
namespace common\components;


use Yii;

class AdminBaseController extends XController  {
	public function init(){
		parent::init();
		// 检测用户是否登入
		if (Yii::$app->user->isGuest ) {
			$this->redirect ( [ '/auth/sign-in' ] );
		}
	}

}