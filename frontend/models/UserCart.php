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
		$fields = parent::find()->where(['status'=>1])->limit($limit)->offset($offset)->orderBy('id DESC')->all();

		$count = parent::find()->count();

		return ['fields'=>$fields, 'count'=>$count];
	}
}