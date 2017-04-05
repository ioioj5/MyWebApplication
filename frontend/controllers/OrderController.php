<?php
namespace frontend\controllers;

use common\components\FrontController;
use frontend\models\Goods;
use frontend\models\Order;
use frontend\models\UserAddress;
use frontend\models\UserCart;
use Yii;
use yii\db\Expression;
use yii\web\NotFoundHttpException;

class OrderController extends FrontController {

	public function actionHandle(){
		$goodsId = intval(Yii::$app->request->get('goodsId'));
		if($goodsId > 0) { // 直接购买
			// 检测商品是否存在
			$goodsInfo = Goods::getOne ( $goodsId );
			if ( empty( $goodsInfo ) ) {
				throw new NotFoundHttpException('数据库中不存在此商品记录', 404);
			}
			// 检测商品上架状态
			if($goodsInfo->status != 1) {
				throw new NotFoundHttpException('商品未上架', 404);
			}
			// 检测商品库存
			if($goodsInfo->stock < 1) {
				throw new NotFoundHttpException('商品库存不足', 404);
			}

			$transaction = Yii::$app->db->beginTransaction ();
			try {
				// 取消选择购物车中已选择的商品
				Yii::$app->db->createCommand()->update(
					"{{%user_cart}}",
					['isChecked'=>0],
					"`userId` = " . Yii::$app->user->id
				)->execute();
				// 检测购物车中是否存在
				$cartInfo = UserCart::getOne ( $goodsId, Yii::$app->user->id );
				if ( empty( $cartInfo ) ) {
					Yii::$app->db->createCommand()->insert(
						"{{%user_cart}}",
						[
							'userId'    => Yii::$app->user->id,
							'goodsId'   => $goodsId,
							'num'       => 1,
							'isChecked' => 1,
							'postTime'  => $this->time
						]
					)->execute();
				} else {
					Yii::$app->db->createCommand()->update(
						"{{%user_cart}}",
						[
							'num'=> new Expression( '`num` + 1' ),
							'isChecked' => 1
						],
						"`id` = '{$cartInfo->id}' AND `userId` = " . Yii::$app->user->id
					)->execute();
				}

				$transaction->commit();
			}catch (\Exception $e) {
				$transaction->rollBack();
				$this->redirect ( [ '/cart/index' ] );
			}

			$this->redirect ( [ '/order/index' ] );
		}else { // 购物车
			// 购物车
			$cartList = UserCart::getCartsByUserId ( Yii::$app->user->id );// 购物车中没有选中商品
			if( empty($cartList)) {
				$this->redirect ( [ '/cart/index' ] );
			}

			$transaction = Yii::$app->db->beginTransaction ();
			try {
				foreach ( $cartList as $key => $val ) {
					if ( $val->goods->stock < 1 ) {
						Yii::$app->db->createCommand ()->update (
							"{{%user_cart}}",
							[ 'isChecked' => 0 ],
							"`id` = '{$val->id}' AND `userId` = " . Yii::$app->user->id
						)->execute ();
					}
				}
				$transaction->commit();
			}catch (\Exception $e) {
				$transaction->rollBack();
				$this->redirect ( [ '/cart/index' ] );
			}
			$this->redirect ( [ '/order/index' ] );
		}
	}
	public function actionIndex () {

		// 购物车
		$cartList = UserCart::getCartsCheckedByUserId ( Yii::$app->user->id );
		// 购物车中没有选中商品
		if( empty($cartList)) {
			$this->redirect ( [ '/cart/index' ] );
		}

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

			// 初始化变量
			$totalMoney = 0; // 商品总金额
			$dataOrder = ['userId'=>Yii::$app->user->id, 'payStatus'=>0, 'orderStatus'=>1, 'payTime'=>0, 'postTime'=>$this->time]; // 订单表数据
			$dataOrderGoods = []; // 订单商品表数据

			// 检测参数
			if($addressId < 1) {
				throw new NotFoundHttpException( '缺少收货地址Id', 404 );
			}
			if(! in_array($payType, [1,2,3])) {
				throw new NotFoundHttpException( '支付方式超出系统设置', 404 );
			}
			// 获取收货地址信息
			$addressInfo = UserAddress::getAddressById($addressId, Yii::$app->user->id);
			if(empty($addressInfo)) {
				throw new NotFoundHttpException('数据库中不存在此条收货地址信息', 404);
			}
			// 获取购物车中已选中的商品
			$cartList = UserCart::getCartsCheckedByUserId ( Yii::$app->user->id );
			if(! empty($cartList)) {
				foreach($cartList as $key=>$val) {
					$totalMoney += $val->goods->price * $val->num;
					$dataOrderGoods[] = [
						'orderId'   => 0,
						'goodsId'   => $val->goods->id,
						'goodsName' => $val->goods->name,
						'price'     => $val->goods->price,
						'num'       => $val->num,
						'postTime'  => $this->time
					];
				}
			}else {
				throw new NotFoundHttpException('购物车中不存在选中的商品', 404);
			}

			$dataOrder['price'] = $totalMoney;

			// 生成订单号
			$orderCode = $this->makeOrderNo();
			if(! empty($orderCode)) {
				$dataOrder['orderCode'] = $orderCode;
			}else {
				throw new NotFoundHttpException('生成订单号失败', 404);
			}
			//print_r($addressInfo);exit;

			// 生成订单
			try {
				//$return = Order::makeOrder($dataOrder, $dataOrderGoods, $addressInfo, $cartList);
				$return = Order::makeOrderWithRedis($dataOrder, $dataOrderGoods, $addressInfo, $cartList);
			}catch (\Exception $e) {
				throw new NotFoundHttpException($e->getMessage(), 404);
			}

			if($return > 0) { // 订单生成成功
				$this->redirect ( [ '/order/waiting' ] );
			}else {
				throw new NotFoundHttpException('订单生成失败', 404);
			}
		}
	}

	/**
	 * 等待页面
	 */
	public function actionWaiting(){
		return $this->render('waiting');
	}

	/**
	 * 生成订单号
	 * 生成24位唯一订单号码，格式：YYYY-MMDD-HHII-SS-NNNN,NNNN-CC，其中：YYYY=年份，MM=月份，DD=日期，HH=24格式小时，II=分，SS=秒，NNNNNNNN=随机数，CC=检查码
	 * @return string
	 */
	public function makeOrderNo () {
		//订单号码主体（YYYYMMDDHHIISSNNNNNNNN）
		$order_id_main = date ( 'YmdHis' ) . rand ( 10000000, 99999999 );

		//订单号码主体长度
		$order_id_len = strlen ( $order_id_main );
		$order_id_sum = 0;
		for ( $i = 0; $i < $order_id_len; $i++ ) {
			$order_id_sum += (int) ( substr ( $order_id_main, $i, 1 ) );

		}

		//唯一订单号码（YYYYMMDDHHIISSNNNNNNNNCC）
		return $order_id_main . str_pad ( ( 100 - $order_id_sum % 100 ) % 100, 2, '0', STR_PAD_LEFT );


	}
}