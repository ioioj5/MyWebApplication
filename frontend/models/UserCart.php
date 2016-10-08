<?php
namespace frontend\models;


class UserCart extends \common\models\UserCart {
	public function init(){
		parent::init();
	}

	/**
	 * 获取购物车列表
	 *
	 * @param $limit
	 * @param $offset
	 *
	 * @return array
	 */
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

		return ['fields'=>$fields, 'count'=>$count];
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