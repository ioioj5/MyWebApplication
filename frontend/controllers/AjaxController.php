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

	/**
	 * 添加到购物车
	 * @return string
	 */
	public function actionAddCart(){
		if(Yii::$app->request->isAjax) {
			// 检测用户是否已登录
			if(Yii::$app->user->isGuest) {
				$this->response['code'] = 0;
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

	/**
	 * 从购物车删除
	 */
	public function actionRemoveCart(){

	}

	/**
	 * 更改购物车商品数量
	 */
	public function actionChangeGoodsNumInCart(){

	}
}