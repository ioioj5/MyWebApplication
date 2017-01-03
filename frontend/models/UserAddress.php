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
}