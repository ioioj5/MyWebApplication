<?php
namespace frontend\models;

class Goods extends \common\models\Goods {
	public function init(){
		parent::init();
	}

	/**
	 * 获取商品列表
	 *
	 * @param $limit
	 * @param $offset
	 *
	 * @return array
	 */
	public static function getGoodsList($limit, $offset){
		$fields = parent::find()->where(['status'=>1])->limit($limit)->offset($offset)->orderBy('id DESC')->all();

		$count = parent::find()->count();

		return ['fields'=>$fields, 'count'=>$count];
	}
}