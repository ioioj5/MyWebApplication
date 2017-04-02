<?php
namespace console\controllers;

use Yii;
use common\components\ConsoleBaseController;

/**
 * redis 操作demo
 * Class RedisController
 * @package console\controllers
 */
class RedisController extends ConsoleBaseController{
	/**
	 * 商品入队列, 从左侧入栈
	 */
	public function actionPush(){
		$sql = "SELECT `id`, `name`, `price`, `stock` FROM {{%goods}} WHERE `status` = 1 AND `stock` > 0";
		$goods = Yii::$app->db->createCommand($sql)->queryAll();
		if(! empty($goods)) {
			foreach ($goods as $key=>$val) {
				for($i = 0; $i < $val['stock']; $i++) {
					$return = Yii::$app->redis->executeCommand('LPUSH', ['goodsId-' . $val['id'], 1]); // 插入: 在key为goodsId-1的左侧(前面)插入一个元素
				}

				$len = Yii::$app->redis->executeCommand('LLEN', ['goodsId-' . $val['id']]);
				echo "> goods_{$val['id']}, stock:{$val['stock']}, len:{$len} \n";
			}
		}
	}

	/**
	 * 商品出队列, 从右侧出栈
	 */
	public function actionPop(){
		$sql = "SELECT `id`, `name`, `price`, `stock` FROM {{%goods}} WHERE `status` = 1 AND `stock` > 0";
		$goods = Yii::$app->db->createCommand($sql)->queryAll();
		if(! empty($goods)) {
			foreach($goods as $key=>$val) {
				$len = Yii::$app->redis->executeCommand('LLEN', ['goodsId-' . $val['id']]); // 计算key:goodsId-1的元素个数
				if($len > 0) {
					$return = Yii::$app->redis->executeCommand("RPOP", ['goodsId-' . $val['id']]); // 移除: 从key为goodsId-1中从右侧(后面)移除一个元素

					echo "> goods_{$val['id']}, stock:{$val['stock']}, len:{$len}";
					$len = Yii::$app->redis->executeCommand('LLEN', ['goodsId-' . $val['id']]);
					if($return) {
						echo ", [T], len:{$len}\n";
					}else {
						echo ", [F], len:{$len}\n";
					}
				}
			}
		}
	}

	public function actionGet(){
		$return = Yii::$app->redis->executeCommand("LLEN", ['goodsId-4']);
		print_r($return);
	}
}