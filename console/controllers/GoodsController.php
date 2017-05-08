<?php
namespace console\controllers;

use Yii;
use common\components\ConsoleBaseController;


class GoodsController extends ConsoleBaseController {
	/**
	 * 初始化商品数据
	 */
	public function actionInit() {

		$data = [];
		for ( $i = 0; $i < 10; $i++ ) {
			$data[] = [ '商品0' . $i, $this->randomFloat ( 10, 20 ), 100, $this->time, 1 ];
		}

		Yii::$app->db->createCommand ()->batchInsert ("{{%goods}}", ['name', 'price', 'stock', 'postTime', 'status'], $data)->execute ();

	}

	/**
	 * 生成随机浮点数字, 且保留小数点后两位
	 * @param int $min
	 * @param int $max
	 *
	 * @return int
	 */
	public function randomFloat($min = 0, $max = 1) {
		return sprintf ("%.2f", $min + mt_rand() / mt_getrandmax() * ($max - $min));
	}
}