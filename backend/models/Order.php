<?php
namespace backend\models;

/**
 * 订单相关操作类
 * Class Order
 * @package backend\models
 */
class Order extends \common\models\Order {
	public function init(){
		parent::init();
	}


	/**
	 * 返回订单状态
	 * @param int $orderStatus
	 *
	 * @return string
	 */
	public static function orderStatus($orderStatus = 0) {
		if($orderStatus < 1) return '';

		if($orderStatus == 1) {
			return '等待付款';
		}elseif($orderStatus == 2) {
			return '付款成功';
		}elseif($orderStatus == 3) {
			return '等待审核';
		}elseif($orderStatus == 4) {
			return '等待发货';
		}elseif($orderStatus == 5) {
			return '已发货';
		}elseif($orderStatus == 6) {
			return '交易成功';
		}elseif($orderStatus == 7) {
			return '交易关闭';
		}
	}
	/**
	 * 获取订单列表
	 * @param $limit
	 * @param $offset
	 *
	 * @return array
	 */
	public static function getOrderList($limit, $offset){
		$fields = parent::find()->limit($limit)->offset($offset)->orderBy('id DESC')->all();

		$count = parent::find()->count();

		return ['fields'=>$fields, 'count'=>$count];
	}

	/**
	 * 获取一条订单记录
	 * @param int $id
	 *
	 * @return array|bool|null|\yii\db\ActiveRecord
	 */
	public static function getOneById($id = 0){
		if($id < 1) return false;

		return parent::findOne($id);
	}

	/**
	 * 获取关联orderGoods数据(一对多)
	 * @return \yii\db\ActiveQuery
	 */
	public function getOrderGoods(){
		return $this->hasMany(OrderGoods::className(), ['orderId'=>'id']);
	}
}