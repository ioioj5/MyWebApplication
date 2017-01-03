<?php
/**
 *
 * author: dupeng
 * createTime: 2016/10/8 18:06
 */

namespace frontend\controllers;


use common\components\FrontController;
use common\models\User;
use frontend\models\Goods;
use frontend\models\UserAddress;
use frontend\models\UserCart;
use Yii;

class AjaxController extends FrontController {
	public $enableCsrfValidation = false;

	/**
	 * 添加到购物车
	 * @return string
	 */
	public function actionAddCart () {
		if ( Yii::$app->request->isAjax ) {
			// 检测用户是否已登录
			if ( Yii::$app->user->isGuest ) {
				$this->response[ 'code' ] = 1;
				$this->response[ 'msg' ]  = '请登录后进行此操作';

				return json_encode ( $this->response );
			}

			// 接受参数
			$goodsId = intval ( Yii::$app->request->post ( 'goodsId' ) );
			if ( $goodsId < 1 ) {
				$this->response[ 'code' ] = 1;
				$this->response[ 'msg' ]  = '参数错误';

				return json_encode ( $this->response );
			}

			// 检测商品是否存在
			$goodsInfo = Goods::getOne ( $goodsId );
			if ( empty( $goodsInfo ) ) {
				$this->response[ 'code' ] = 1;
				$this->response[ 'msg' ]  = '数据库中不存在此商品记录';

				return json_encode ( $this->response );
			}

			// 检测购物车中是否已存在此商品的记录
			$cartInfo = UserCart::getOne ( $goodsId, Yii::$app->user->id );
			if ( empty( $cartInfo ) ) { // 不存在
				$cartInfo           = new UserCart();
				$cartInfo->userId   = Yii::$app->user->id;
				$cartInfo->goodsId  = $goodsId;
				$cartInfo->num      = 1;
				$cartInfo->postTime = $this->time;
				$cartInfo->save ();
			} else { // 已存在
				$cartInfo->num += 1;
				$cartInfo->save ();
			}

			$this->response[ 'code' ] = 0;
			$this->response[ 'msg' ]  = '添加成功';

			return json_encode ( $this->response );

		}
	}

	// 更改购物车商品数量 (增加或减少)
	public function actionChangeGoodsNum () {
		if ( Yii::$app->request->isAjax ) {
			// 检测用户是否已登录
			if ( Yii::$app->user->isGuest ) {
				$this->response[ 'code' ] = 1;
				$this->response[ 'msg' ]  = '请登录后进行此操作';

				return json_encode ( $this->response );
			}
			// 接受参数
			$act    = trim ( Yii::$app->request->post ( 'act' ) ); // 动作
			$cartId = intval ( Yii::$app->request->post ( 'cartId' ) ); // 购物车Id

			// 检测参数
			if ( ! in_array ( $act, [ 'plus', 'minus' ] ) ) {
				$this->response[ 'code' ] = 1;
				$this->response[ 'msg' ]  = '操作超出系统设置';

				return json_encode ( $this->response );
			}

			// 检测购物车中是否存在此条记录
			$cart = UserCart::find ()->where ( [ 'id' => $cartId ] )->one ();
			if ( empty( $cart ) ) {
				$this->response[ 'code' ] = 1;
				$this->response[ 'msg' ]  = '数据库中不存在此条购物车记录';

				return json_encode ( $this->response );
			}


			if ( $act == 'plus' ) {
				$cart->num += 1;
				$cart->save ();
				$this->response[ 'data' ] = [ 'num' => $cart->num ];
			} else {
				if ( $cart->num > 1 ) {
					$cart->num -= 1;
					$cart->save ();
					$this->response[ 'data' ] = [ 'num' => $cart->num ];
				} else {
					UserCart::deleteAll ( [ 'id' => $cartId ] );
					$this->response[ 'data' ] = [ 'num' => 0 ];
				}
			}


			$this->response[ 'code' ] = 0;
			$this->response[ 'msg' ]  = '操作成功';

			return json_encode ( $this->response );

		}
	}

	// 从购物车删除商品
	public function actionRemoveFromCart () {
		if ( Yii::$app->request->isAjax ) {
			// 检测用户是否已登录
			if ( Yii::$app->user->isGuest ) {
				$this->response[ 'code' ] = 1;
				$this->response[ 'msg' ]  = '请登录后进行此操作';

				return json_encode ( $this->response );
			}

			$cartId = intval ( Yii::$app->request->post ( 'cartId' ) ); // 购物车Id
			// 检测参数
			if ( $cartId < 1 ) {
				$this->response[ 'code' ] = 1;
				$this->response[ 'msg' ]  = '参数错误';

				return json_encode ( $this->response );
			}

			$cart = UserCart::find ()->where ( [ 'id' => $cartId ] )->one ();
			if ( empty( $cart ) ) {
				$this->response[ 'code' ] = 1;
				$this->response[ 'msg' ]  = '数据库中不存在此条购物车记录';

				return json_encode ( $this->response );
			}

			if ( UserCart::deleteAll ( [ 'id' => $cartId ] ) ) {
				$this->response[ 'code' ] = 0;
				$this->response[ 'msg' ]  = '操作成功';

				return json_encode ( $this->response );
			} else {
				$this->response[ 'code' ] = 1;
				$this->response[ 'msg' ]  = '操作失败';

				return json_encode ( $this->response );
			}
		}
	}

	/**
	 * AJAX: 清空购物车
	 * @return string
	 */
	public function actionCleanCart () {
		if ( Yii::$app->request->isAjax ) {
			// 检测用户是否已登录
			if ( Yii::$app->user->isGuest ) {
				$this->response[ 'code' ] = 1;
				$this->response[ 'msg' ]  = '请登录后进行此操作';

				return json_encode ( $this->response );
			}

			$carts = UserCart::find ()->count ();
			if ( $carts > 0 ) {
				if ( UserCart::deleteAll ( [ 'userId = :userId', ':userId' => Yii::$app->user->id ] ) ) {
					$this->response[ 'code' ] = 0;
					$this->response[ 'msg' ]  = '操作成功';

					return json_encode ( $this->response );
				} else {
					$this->response[ 'code' ] = 1;
					$this->response[ 'msg' ]  = '操作失败';

					return json_encode ( $this->response );
				}
			}
		}
	}

	/**
	 * 从购物车删除
	 */
	public function actionRemoveCart () {

	}

	/**
	 * 更改购物车商品数量
	 */
	public function actionChangeGoodsNumInCart () {

	}

	/**
	 * 选中购物车中商品
	 */
	public function actionSelectGoodsInCart () {
		if ( Yii::$app->request->isAjax ) {
			$cartId = intval ( Yii::$app->request->post ( 'cartId' ) ); // 购物车Id
			$act    = trim ( Yii::$app->request->post ( 'act' ) ); // 动作: checked - 选中, unchecked-取消选中

			// 检测用户是否已登录
			if ( Yii::$app->user->isGuest ) {
				$this->response[ 'code' ] = 1;
				$this->response[ 'msg' ]  = '请登录后进行此操作';

				return json_encode ( $this->response );
			}

			// 检测参数
			if ( $cartId < 1 ) {
				$this->response[ 'code' ] = 1;
				$this->response[ 'msg' ]  = '购物车参数错误';

				return json_encode ( $this->response );
			}
			if ( ! in_array ( $act, [ 'checked', 'unchecked' ] ) ) {
				$this->response[ 'code' ] = 1;
				$this->response[ 'msg' ]  = '操作超出系统设置';

				return json_encode ( $this->response );
			}

			$userCart = UserCart::find ()->where ( [ 'id' => $cartId, 'userId' => Yii::$app->user->id ] )->one ();

			if ( empty( $userCart ) ) {
				$this->response[ 'code' ] = 1;
				$this->response[ 'msg' ]  = '购物车中不存在此条记录.';

				return json_encode ( $this->response );
			}
			// 组织数据
			$data = [ 'updateTime' => $this->time ];
			if ( isset( $userCart->isChecked ) and $userCart->isChecked == 0 ) {
				$data += [ 'isChecked' => 1 ];
			} else {
				$data += [ 'isChecked' => 0 ];
			}
			// 入库
			$return = UserCart::updateAll ( $data, '`id` = ' . $userCart->id );
			if ( $return ) {
				$this->response[ 'code' ] = 0;
				$this->response[ 'msg' ]  = '添加成功';

				return json_encode ( $this->response );
			} else {
				$this->response[ 'code' ] = 1;
				$this->response[ 'msg' ]  = '添加失败';

				return json_encode ( $this->response );
			}
		}
	}

	/**
	 * 添加新的收货人信息
	 */
	public function actionAddNewAddress () {
		if ( Yii::$app->request->isAjax ) {
			$name    = trim ( Yii::$app->request->post ( 'name' ) ); // 收货人
			$address = trim ( Yii::$app->request->post ( 'address' ) ); // 详细地址
			$contact = trim ( Yii::$app->request->post ( 'contact' ) ); // 联系方式

			// 检测用户是否已登录
			if ( Yii::$app->user->isGuest ) {
				$this->response[ 'code' ] = 1;
				$this->response[ 'msg' ]  = '请登录后进行此操作';

				return json_encode ( $this->response );
			}

			$data = [ 'userId' => Yii::$app->user->id, 'postTime' => $this->time ];

			// 检测变量
			if ( empty( $name ) ) {
				$this->response[ 'code' ] = 1;
				$this->response[ 'msg' ]  = '收货人不能为空';

				return json_encode ( $this->response );
			} else {
				$data[ 'name' ] = $name;
			}
			if ( empty( $address ) ) {
				$this->response[ 'code' ] = 1;
				$this->response[ 'msg' ]  = '详细地址不能为空';

				return json_encode ( $this->response );
			} else {
				$data[ 'address' ] = $address;
			}
			if ( empty( $contact ) ) {
				$this->response[ 'code' ] = 1;
				$this->response[ 'msg' ]  = '联系方式不能为空';

				return json_encode ( $this->response );
			} else {
				$data[ 'contact' ] = $contact;
			}
			// 检测当前是否已经存在收货地址
			$addressList = UserAddress::getAddressListByUserId ( Yii::$app->user->id );
			if ( empty( $addressList ) ) {
				$data[ 'isDefault' ] = 1; // 第一次添加收货地址, 设为默认收货地址
			} else {
				$data[ 'isDefault' ] = 0;
			}

			// 入库
			$return = Yii::$app->db->createCommand ()->insert ( '{{%user_address}}', $data )->execute ();

			if ( $return ) {
				$this->response[ 'code' ] = 0;
				$this->response[ 'msg' ]  = '添加成功';

				return json_encode ( $this->response );
			} else {
				$this->response[ 'code' ] = 1;
				$this->response[ 'msg' ]  = '添加失败';

				return json_encode ( $this->response );
			}

		}
	}
}