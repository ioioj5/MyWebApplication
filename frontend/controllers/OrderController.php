<?php
namespace frontend\controllers;

use common\components\FrontController;
use frontend\models\UserAddress;
use frontend\models\UserCart;
use Yii;
use yii\web\NotFoundHttpException;

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
			if($addressId < 1) {
				throw new NotFoundHttpException( '缺少收货地址Id', 404 );
			}
			if(! in_array($payType, [1,2,3])) {
				throw new NotFoundHttpException( '支付方式超出系统设置', 404 );
			}

			

		}
	}
}