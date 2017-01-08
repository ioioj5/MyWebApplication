<?php
namespace frontend\models;
use Yii;
use yii\db\Expression;

/**
 * 前端: 订单相关操作
 * Class Order
 * @package frontend\models
 */
class Order extends \common\models\Order {

	public function init () {
		parent::init ();
	}

	/**
	 * 生成订单
	 *
	 * @param array $dataOrder
	 *
	 * @param array $dataOrderGoods
	 *
	 * @param null  $addressInfo
	 *
	 * @param array $cartList
	 *
	 * @return bool
	 * @throws \Exception
	 */
	public static function makeOrder ( $dataOrder = [], $dataOrderGoods = [], $addressInfo = null, $cartList = [] ) {
		if ( empty( $dataOrder ) or  empty($dataOrderGoods) or is_null($addressInfo)) return false;
		$time = time();

		$transaction = Yii::$app->db->beginTransaction ();
		try {
			// 1. 生成订单
			Yii::$app->db->createCommand ()->insert (
				"{{%order}}",
				$dataOrder
			)->execute ();
			$orderId = Yii::$app->db->getLastInsertID ();

			if ( ! empty( $dataOrderGoods ) ) {
				foreach ( $dataOrderGoods as $key => $val ) {
					$dataOrderGoods[ $key ][ 'orderId' ] = $orderId;
				}
			}
			// 批量插入订单商品信息
			Yii::$app->db->createCommand ()->batchInsert (
				"{{%order_goods}}",
				[ 'orderId', 'goodsId', 'goodsName', 'price', 'num', 'postTime' ],
				$dataOrderGoods
			)->execute ();
			// 处理库存
			foreach($dataOrderGoods as $key=>$val) {
				// 检查库存
				$sql = "SELECT `stock` FROM {{%goods}} WHERE `id` = '{$val['goodsId']}'";
				$stock = Yii::$app->db->createCommand($sql)->queryScalar();
				if($stock - $val['num'] <= 0) {
					throw new \Exception("存在库存不足的商品");
				}
				// 减去库存
				Yii::$app->db->createCommand()->update(
					"{{%goods}}",
					[
						'stock'   => new Expression( '`stock` - ' . $val['num'] ),
					],
					"`id` = '{$val['goodsId']}'"
				)->execute();
			}

			// 2. 收货地址
			Yii::$app->db->createCommand ()->insert (
				"{{%order_address}}",
				[
					'orderId'  => $orderId,
					'name'     => $addressInfo->name,
					'contact'  => $addressInfo->contact,
					'address'  => $addressInfo->address,
					'postTime' => $time
				]
			)->execute ();

			// 3. 订单日志
			Yii::$app->db->createCommand ()->insert (
				"{{%order_log}}",
				[
					'userId'      => Yii::$app->user->id,
					'orderId'     => $orderId,
					'orderStatus' => 0,
					'postTime'    => $time
				]
			)->execute ();

			// 4. 清空购物车
			if ( isset($cartList) and  ! empty( $cartList ) ) {
				foreach ( $cartList as $key => $val ) {
					Yii::$app->db->createCommand ()->delete (
						"{{%user_cart}}",
						"`id` = {$val->id}"
					)->execute ();
				}
			}

			$transaction->commit ();
		} catch ( \Exception $e ) {
			$transaction->rollBack ();

			throw new \Exception($e->getMessage());
		}
		return $orderId;
	}
}