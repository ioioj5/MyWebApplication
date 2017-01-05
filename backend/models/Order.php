<?php
/**
 * Created by PhpStorm.
 * User: ioioj5
 * Date: 2017/1/6
 * Time: 4:07
 */

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

	public static function getOrderList($limit, $offset){
		$fields = parent::find()->limit($limit)->offset($offset)->orderBy('id DESC')->all();

		$count = parent::find()->count();

		return ['fields'=>$fields, 'count'=>$count];
	}

	/**
	 * @param int $id
	 *
	 * @return array|bool|null|\yii\db\ActiveRecord
	 */
	public static function getOneById($id = 0){
		if($id < 1) return false;

		return parent::findOne($id);
	}

	public function getOrderGoods(){
		return $this->hasMany(OrderGoods::className(), ['orderId'=>'id']);
	}
}