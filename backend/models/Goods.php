<?php
namespace backend\models;

/**
 * 商品相关操作类
 * Class Goods
 * @package backend\models
 */
class Goods extends \common\models\Goods {
	public function init(){
		parent::init();
	}

	/**
	 * 获取商品列表
	 * @param $limit
	 * @param $offset
	 *
	 * @return array
	 */
	public static function getGoodsList($limit, $offset){
		$fields = parent::find()->limit($limit)->offset($offset)->orderBy('id DESC')->all();

		$count = parent::find()->count();

		return ['fields'=>$fields, 'count'=>$count];
	}

	/**
	 * 删除商品
	 *
	 * @param int $id
	 *
	 * @return false|int
	 * @throws \Exception
	 */
	public static function deleteGoods($id = 0){
		if($id < 1) throw new \Exception('参数错误');
		$goods = parent::findOne($id);
		return $goods->delete();
	}
}