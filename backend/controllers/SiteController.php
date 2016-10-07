<?php
namespace backend\controllers;

use common\components\AdminBaseController;
use Yii;

/**
 * Site controller
 */
class SiteController extends AdminBaseController  {

	public function actionIndex () {
		return $this->render ( 'index' );
	}
}
