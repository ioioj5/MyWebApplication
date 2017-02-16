<?php
namespace console\controllers;


use Yii;
use yii\console\Controller;

class GoodsController extends Controller {
	/**
	 * 初始化商品数据
	 */
	public function actionInitialize() {
		Yii::$app->db->createCommand()->update(
			"{{%goods}}",
			['stock'=>10, 'ver'=>0],
			'`id` > 0'
		)->execute();
		return 0;
	}

}