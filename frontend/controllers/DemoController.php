<?php
namespace frontend\controllers;

use Yii;
use common\components\FrontController;

class DemoController extends FrontController {
	public function actionIndex(){
		$result = Yii::$app->redis->executeCommand('hmset', ['test_collection', 'key1', 'val1', 'key2', 'val2']);
	}
}