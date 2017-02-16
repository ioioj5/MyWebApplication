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
	 *
	 * @param $userId
	 * @param $limit
	 * @param $offset
	 *
	 * @return array
	 */
	public static function getCartsByLimit($userId = 0, $limit, $offset){
		if($userId < 1) return false;

		$fields = parent::find()->where(['userId'=>$userId])->limit($limit)->offset($offset)->orderBy('id DESC')->all();
		$count = parent::find()->where(['userId'=>$userId])->count();
		return ['fields'=>$fields, 'count'=>$count];
	}

	/**
	 * 根据userId获取购物车中的商品列表
	 * @param int $userId
	 *
	 * @return array|\common\models\UserCart[]
	 */
	public static function getCartsByUserId($userId = 0){
		if($userId < 1) return false;

		return parent::find()->where(['userId'=>$userId])->all();
	}

	/**
	 * 根据userId获取购物车中选中的商品
	 * @param int $userId
	 *
	 * @return array|\common\models\UserCart[]
	 */
	public static function getCartsCheckedByUserId($userId = 0) {
		if($userId < 1) return false;

		return parent::find()->where(['userId'=>$userId, 'isChecked'=>1])->all();
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
		if($goodsId < 1 or $userId < 1) return false;

		return parent::find()->where(['goodsId'=>$goodsId, 'userId'=>$userId])->one();
	}

	public static function getOneById($id, $userId = 0) {

		return parent::find()->where(['id'=>$id, 'userId'=>$userId])->one();
	}
}