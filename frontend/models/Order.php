<?php
namespace frontend\models;
use common\models\OrderGoods;
use common\models\OrderLog;
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
	 * 获取订单列表
	 *
	 * @param array $condition
	 * @param       $limit
	 * @param       $offset
	 *
	 * @return array
	 * @internal param int $userId
	 */
	public static function getOrderList($condition = [], $limit, $offset){
		$query = parent::find();
		if(! empty($condition)) {
			$query->where($condition);
		}
		if($limit > 0) {
			$query->limit($limit);
		}
		if($limit > 0 and $offset >= 0) {
			$query->off($offset);
		}
		$fields = $query->orderBy('id DESC')->all();

		$query = parent::find();
		if(! empty($condition)) {
			$query->where($condition);
		}
		$count = $query->count();

		return ['fields'=>$fields, 'count'=>$count];
	}

	/**
	 * 获取一条订单信息
	 *
	 * @param int $orderId
	 *
	 * @return null|static
	 *
	 */
	public static function getOne($orderId = 0) {
		return parent::find()->where(['id'=>$orderId])->one();
	}

	/**
	 * 获取关联orderGoods数据(一对多)
	 * @return \yii\db\ActiveQuery
	 */
	public function getOrderGoods(){
		return $this->hasMany(OrderGoods::className(), ['orderId'=>'id']);
	}

	/**
	 * 获取关联orderLog数据
	 * @return \yii\db\ActiveQuery
	 */
	public function getOrderLog(){
		return $this->hasOne(OrderLog::className(), ['orderId'=>'id'])->where('orderStatus = :orderStatus', ['orderStatus'=>7]);
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
				$sql = "SELECT `stock`, `ver` FROM {{%goods}} WHERE `id` = '{$val['goodsId']}'";
				$result = Yii::$app->db->createCommand($sql)->queryOne();
				if($result['stock'] - $val['num'] < 0) {
					throw new \Exception("存在库存不足的商品");
				}
				// 减去库存
				$res = Yii::$app->db->createCommand()->update(
					"{{%goods}}",
					[
						'stock'   => new Expression( '`stock` - ' . $val['num'] ),
						'ver'	  => new Expression('`ver` + 1')
					],
					"`id` = '{$val['goodsId']}' AND `ver` = '{$result['ver']}'"
				)->execute();
				if($res != 1) {
					throw new \Exception("事务提交失败, 订单未生成.");
				}
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
					'orderStatus' => 1,
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