<?php
namespace frontend\models;

class UserAddress extends \common\models\UserAddress {
	public function init(){
		parent::init();
	}

	/**
	 * 根据userId获取收货地址
	 * @param int $userId
	 *
	 * @return array|bool|\yii\db\ActiveRecord[]
	 */
	public static function getAddressListByUserId($userId = 0) {
		if($userId < 1) return false;

		return parent::find()->where(['userId'=>$userId])->all();
	}

	/**
	 * 根据收货地址Id(id)和用户id(userId)获取一条收货地址信息
	 * @param int $id
	 * @param int $userId
	 *
	 * @return array|null|\yii\db\ActiveRecord
	 */
	public static function getAddressById($id = 0, $userId = 0) {
		if($id < 0 or $userId < 0) return false;

		return parent::find()->where(['id'=>$id, 'userId'=>$userId])->one();
	}
}