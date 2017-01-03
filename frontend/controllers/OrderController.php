<?php
namespace frontend\controllers;

use common\components\FrontController;
use frontend\models\UserAddress;
use frontend\models\UserCart;
use Yii;

class OrderController extends FrontController {
	public function actionIndex () {

		// 购物车
		$cartList = UserCart::getCartsByUserId ( Yii::$app->user->id );

		// 收货地址列表
		$addressList = UserAddress::getAddressListByUserId ( Yii::$app->user->id );

		return $this->render ( 'index', [
			'cartList'    => $cartList,
			'addressList' => $addressList
		] );
	}

	/**
	 * 提交订单
	 */
	public function actionSubmit () {
		if ( Yii::$app->request->isPost ) {
			$addressId = intval ( Yii::$app->request->post ( 'addressId' ) ); // 收货地址
			$payType   = intval ( Yii::$app->request->post ( 'payType' ) ); // 支付方式


			// 检测参数
		}
	}
}