<?php
namespace console\controllers;

use Yii;
use common\components\ConsoleBaseController;
use yii\db\Expression;

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

	/**
	 * [redis队列] 生成订单
	 */
	public function actionMakeOrder(){
		while (true) {
			// 1. 打开文件句柄
			$this->openFp ( 'makeOrder' );

			$time = time();
			
			$humanTime = date ( 'Y-m-d H:i:s', $time );
			$len = Yii::$app->redis->executeCommand('LLEN', ['orders']); // 计算key:goodsId-1的元素个数
			if($len > 0) {
				for ($i = 0; $i < $len; $i++) {
					$data = Yii::$app->redis->executeCommand("RPOP", ['orders']);
					if(! empty($data)) {
						$data = json_decode($data, true);
						if(! empty($data)) {
							$orderId = 0;
							$transaction = Yii::$app->db->beginTransaction ();
							try {
								if ( isset( $data[ 'dataOrder' ] ) and ! empty( $data[ 'dataOrder' ] ) ) { // 处理订单
									// 1. 生成订单
									Yii::$app->db->createCommand ()->insert (
										"{{%order}}",
										$data['dataOrder']
									)->execute ();
									$orderId = Yii::$app->db->getLastInsertID ();
								}
								if ( isset( $data[ 'dataOrderGoods' ] ) and ! empty( $data[ 'dataOrderGoods' ] ) ) { // 订单商品
									foreach ( $data[ 'dataOrderGoods' ] as $key => $val ) {
										$data[ 'dataOrderGoods' ][ $key ][ 'orderId' ] = $orderId;
									}
									// 批量插入订单商品信息
									Yii::$app->db->createCommand ()->batchInsert (
										"{{%order_goods}}",
										[ 'orderId', 'goodsId', 'goodsName', 'price', 'num', 'postTime' ],
										$data[ 'dataOrderGoods' ]
									)->execute ();
									// 处理库存
									foreach($data[ 'dataOrderGoods' ] as $k=>$v) {
										if($v['num'] > 0) {
											for($i = 0; $i < $v['num']; $i++) {
												$stockStatus = Yii::$app->redis->executeCommand("RPOP", ['goodsId-' . $v['goodsId']]);
												if(! $stockStatus) {
													throw new \Exception("存在库存不足的商品", 100);
												}
												if(isset($popStock[$v['goodsId']])) {
													$popStock[$v['goodsId']] += 1;
												}else {
													$popStock[$v['goodsId']] = 1;
												}
											}
											// 减去库存, 操作数据库 @TODO: 是否还需要同步数据库的商品库存?
											$res = Yii::$app->db->createCommand()->update(
												"{{%goods}}",
												[
													'stock'   => new Expression( '`stock` - ' . $v['num'] ),
													'ver'	  => new Expression('`ver` + 1')
												],
												"`id` = '{$v['goodsId']}'"
											)->execute();

										}
									}
								}

								if(isset($data['addressInfo']) and ! empty($data['addressInfo'])) {
									// 2. 收货地址
									Yii::$app->db->createCommand ()->insert (
										"{{%order_address}}",
										[
											'orderId'  => $orderId,
											'name'     => $data['addressInfo']['name'],
											'contact'  => $data['addressInfo']['contact'],
											'address'  => $data['addressInfo']['address'],
											'postTime' => $time
										]
									)->execute ();
								}

								// 3. 订单日志
								Yii::$app->db->createCommand ()->insert (
									"{{%order_log}}",
									[
										'userId'      => $data['dataOrder']['userId'],
										'orderId'     => $orderId,
										'orderStatus' => 1,
										'postTime'    => $time
									]
								)->execute ();

								// 4. 清空购物车
								if ( isset($data['cartList']) and  ! empty( $data['cartList'] ) ) {
									foreach ( $data['cartList'] as $k => $v ) {
										Yii::$app->db->createCommand ()->delete (
											"{{%user_cart}}",
											"`id` = {$v['id']}"
										)->execute ();
									}
								}
								$transaction->commit();
								// 2. 写入日志 [成功]
								$this->log("[{$humanTime}] orderId:{$orderId}, orderCode:{$data[ 'dataOrder' ]['orderCode']}, price:{$data['dataOrder']['price']}, postTime:{$data['dataOrder']['postTime']}, [T] \n");
							} catch ( \Exception $e ) {
								$transaction->rollBack();
								// 2. 写入日志 [失败]
								$this->log("[{$humanTime}] orderId:{$orderId}, orderCode:{$data[ 'dataOrder' ]['orderCode']}, price:{$data['dataOrder']['price']}, postTime:{$data['dataOrder']['postTime']}, [F]: " . $e->getMessage() . "\n");
								if(! empty($popStock) and $e->getCode() == 100) { // 库存不足导致异常后需补回已扣除的库存
									//print_r($popStock);exit;
									foreach($popStock as $key=>$val) {
										for($i = 0; $i < $val; $i++) {
											Yii::$app->redis->executeCommand('LPUSH', ['orders', $data]);
										}
									}
								}
							}
						}
					}
				}
			}else {
				$this->log("[{$humanTime}] 当前队列中无订单数据  \n");
			}
			sleep(1);
		}
	}
}