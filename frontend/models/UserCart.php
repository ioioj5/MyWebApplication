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
<<<<<<< HEAD
	public static function getCarts($limit, $offset){
		$fields = parent::find()->limit($limit)->offset($offset)->orderBy('id DESC')->all();
		$count = parent::find()->count();
=======
	public static function getCartList($limit, $offset){
		//$fields = parent::find()->joinWith('%goods', false)->limit($limit)->offset($offset)->orderBy('id DESC')->all();
		//$fields = parent::find(['uc.id', 'g.name'])->alias('uc')->leftJoin('{{%goods}} as `g`', 'g.id = uc.goodsId')->asArray()->all();
		$fields = parent::findBySql("
			SELECT 
				`uc` . `id`, `uc` . `goodsId`, `uc` . `num`, `uc` . `postTime`,
				 `g` . `name`, `g` . `price`
			FROM {{%user_cart}} as `uc` 
			LEFT JOIN {{%goods}} as `g` 
			ON `g` . `id` = `uc` . `goodsId`
		")->asArray()->all();
		$count = parent::findBySql("
			SELECT 
				`uc` . `id`, `uc` . `goodsId`, `uc` . `num`, `uc` . `postTime`,
				 `g` . `name`, `g` . `price`
			FROM {{%user_cart}} as `uc` 
			LEFT JOIN {{%goods}} as `g` 
			ON `g` . `id` = `uc` . `goodsId`
		")->asArray()->count();
>>>>>>> fc8fd7a73fdb18ed78a3ec5ad383b32c8e74eed3

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