<?php
namespace console\controllers;


use backend\models\Order;
use common\components\ConsoleBaseController;
use Yii;

class OrderController extends ConsoleBaseController {
	/**
	 * 未支付订单过期时间/有效期
	 * @var int
	 */
	public $unPaidOrderExpireTime = 10;

	/**
	 * 自动确认订单有效期
	 * @var int
	 */
	public $automaticConfirmOrderExpireTime = 0;

	/**
	 * 1. 处理未支付订单
	 */
	public function actionUnPaidOrder () {
		// 1. 打开文件句柄
		$this->openFp ( 'unPaidOrder' );

		$list = Order::getOrderList ( [ 'orderStatus' => 1 ] );
		if ( isset( $list[ 'fields' ] ) and ! empty( $list[ 'fields' ] ) ) {
			foreach ( $list[ 'fields' ] as $key => $val ) {
				$postTime = date ( 'Y-m-d H:i:s', $val->postTime );
				$this->log ( "orderID: {$val->id}, orderCode: {$val->orderCode}, price: {$val->price}, postTime: {$postTime}" );

				if ( ( $val->postTime + $this->unPaidOrderExpireTime ) < $this->time ) {
					$transaction = Yii::$app->db->beginTransaction ();
					try {
						// 关闭订单
						Yii::$app->db->createCommand ()->update (
							"{{%order}}",
							[ 'orderStatus' => 7 ],
							"`id` = '{$val->id}'"
						)->execute ();
						// 记录订单日志
						Yii::$app->db->createCommand()->insert(
							"{{%order_log}}",
							[
								'userId'      => $val->userId,
								'orderId'     => $val->id,
								'orderStatus' => 7,
								'remarks'     => '支付超时关闭',
								'postTime'    => $this->time
							]
						)->execute();
						$transaction->commit();
					}catch (\Exception $e) {
						$transaction->rollBack();
						echo $e->getMessage();exit;
						$this->log ( " [F]\n" );
						continue;
					}
					$this->log ( " [T]\n" );
				}
			}
		}

		$this->log ( "\n" );
		// 3. 关闭文件句柄
		$this->closeFp ();
	}

	/**
	 * 2. 自动确认订单
	 */
	public function actionAutomaticConfirmOrder () {

	}
}