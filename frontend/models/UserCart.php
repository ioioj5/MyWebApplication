<?php
namespace frontend\models;

/**
 * 购物车相关
 * Class UserCart
 * @package frontend\models
 */
class UserCart extends \common\models\UserCart {
	public function init(){
		parent::init();
	}

	/**
	 * 获取购物车列表
	 * @param $limit
	 * @param $offset
	 *
	 * @return array
	 */
	public static function getCarts($limit, $offset){
		$fields = parent::find()->limit($limit)->offset($offset)->orderBy('id DESC')->all();
		$count = parent::find()->count();

		return ['fields'=>$fields, 'count'=>$count];
	}

	/**
	 * 获取关联goods商品表数据(一对一关联)
	 * @return \yii\db\ActiveQuery
	 */
	public function getGoods() {
		return $this->hasOne(Goods::className(), ['id'=>'goodsId']);
	}

	/**
	 * 获取一条购物车记录
	 *
	 * @param int $goodsId
	 * @param int $userId
	 *
	 * @return array|\common\models\UserCart|null
	 */
	public static function getOne($goodsId = 0, $userId = 0) {
		return parent::find()->where(['goodsId'=>$goodsId, 'userId'=>$userId])->one();
	}
}