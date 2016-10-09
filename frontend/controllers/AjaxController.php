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
use frontend\models\UserCart;
use Yii;

class AjaxController extends FrontController {
	public $enableCsrfValidation = false;
	// 添加到购物车
	public function actionAddCart(){
		if(Yii::$app->request->isAjax) {
			// 检测用户是否已登录
			if(Yii::$app->user->isGuest) {
				$this->response['code'] = 1;
				$this->response['msg'] = '请登录后进行此操作';

				return json_encode($this->response);
			}

			// 接受参数
			$goodsId = intval(Yii::$app->request->post('goodsId'));
			if($goodsId < 1) {
				$this->response['code'] = 1;
				$this->response['msg'] = '参数错误';

				return json_encode($this->response);
			}

			// 检测商品是否存在
			$goodsInfo = Goods::getOne($goodsId);
			if(empty($goodsInfo)) {
				$this->response['code'] = 1;
				$this->response['msg'] = '数据库中不存在此商品记录';

				return json_encode($this->response);
			}

			// 检测购物车中是否已存在此商品的记录
			$cartInfo = UserCart::getOne($goodsId, Yii::$app->user->id);
			if(empty($cartInfo)) { // 不存在
				$cartInfo = new UserCart();
				$cartInfo->userId = Yii::$app->user->id;
				$cartInfo->goodsId = $goodsId;
				$cartInfo->num = 1;
				$cartInfo->postTime = $this->time;
				$cartInfo->save();
			}else { // 已存在
				$cartInfo->num += 1;
				$cartInfo->save();
			}

			$this->response['code'] = 0;
			$this->response['msg'] = '添加成功';

			return json_encode($this->response);

		}
	}

	// 更改购物车商品数量 (增加或减少)
	public function actionChangeGoodsNum(){
		if(Yii::$app->request->isAjax) {
			// 检测用户是否已登录
			if(Yii::$app->user->isGuest) {
				$this->response['code'] = 1;
				$this->response['msg'] = '请登录后进行此操作';

				return json_encode($this->response);
			}
			// 接受参数
			$act = trim(Yii::$app->request->post('act')); // 动作
			$cartId = intval(Yii::$app->request->post('cartId')); // 购物车Id

			// 检测参数
			if(! in_array($act, ['plus', 'minus'])) {
				$this->response['code'] = 1;
				$this->response['msg'] = '操作超出系统设置';

				return json_encode($this->response);
			}

			// 检测购物车中是否存在此条记录
			$cart = UserCart::find()->where(['id'=>$cartId])->one();
			if( empty($cart)) {
				$this->response['code'] = 1;
				$this->response['msg'] = '数据库中不存在此条购物车记录';

				return json_encode($this->response);
			}

			if($act == 'plus') {
				$cart->num += 1;
				$cart->save();
			}else {
				if($cart->num - 1 >= 0) {
					$cart->num -= 1;
					$cart->save();
				}
			}


			$this->response['code'] = 0;
			$this->response['msg'] = '操作成功';
			$this->response['data'] = ['num'=>$cart->num];

			return json_encode($this->response);

		}
	}

	// 从购物车删除商品
	public function actionRemoveFromCart(){
		if(Yii::$app->request->isAjax) {
			// 检测用户是否已登录
			if(Yii::$app->user->isGuest) {
				$this->response['code'] = 1;
				$this->response['msg'] = '请登录后进行此操作';

				return json_encode($this->response);
			}

			$cartId = intval(Yii::$app->request->post('cartId')); // 购物车Id
			// 检测参数
			if($cartId < 1) {
				$this->response['code'] = 1;
				$this->response['msg'] = '参数错误';

				return json_encode($this->response);
			}

			$cart = UserCart::find()->where(['id'=>$cartId])->one();
			if(empty($cart)) {
				$this->response['code'] = 1;
				$this->response['msg'] = '数据库中不存在此条购物车记录';

				return json_encode($this->response);
			}

			if(UserCart::deleteAll(['id'=>$cartId])) {
				$this->response['code'] = 0;
				$this->response['msg'] = '操作成功';

				return json_encode($this->response);
			}else {
				$this->response['code'] = 1;
				$this->response['msg'] = '操作失败';

				return json_encode($this->response);
			}
		}
	}

	// 清空购物画册
	public function actionCleanCart(){
		if(Yii::$app->request->isAjax) {
			// 检测用户是否已登录
			if(Yii::$app->user->isGuest) {
				$this->response['code'] = 1;
				$this->response['msg'] = '请登录后进行此操作';

				return json_encode($this->response);
			}

			$carts = UserCart::find()->count();
			if($carts > 0) {
				if(UserCart::deleteAll(['userId = :userId', ':userId'=>Yii::$app->user->id])) {
					$this->response['code'] = 0;
					$this->response['msg'] = '操作成功';

					return json_encode($this->response);
				}else {
					$this->response['code'] = 1;
					$this->response['msg'] = '操作失败';

					return json_encode($this->response);
				}
			}
		}
	}
}