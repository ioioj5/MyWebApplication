<?php
namespace backend\controllers;

use backend\models\GoodsTags;
use backend\models\Goods;
use backend\models\Tags;
use common\components\AdminBaseController;
use Yii;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

/**
 * 商品相关
 * Class GoodsController
 * @package backend\controllers
 */
class GoodsController extends AdminBaseController {
	public $enableCsrfValidation = false;
	/**
	 * 商品列表
	 * @return string
	 */
	public function actionIndex () {
		$page = intval ( Yii::$app->request->get ( 'page', 1 ) );

		$limit  = 20;
		$offset = ( $page - 1 ) * $limit;
		$params = array ( 'goods/index', 'page' => '{page}' ); // 生成URL参数数组

		$list      = Goods::getGoodsList ( $limit, $offset );
		$totalPage = ceil ( $list[ 'count' ] / $limit );
		$link      = Url::toRoute ( $params ); //$this->createUrl ( 'admin/index', $params ); // '/page/{page}';
		$navbar    = $this->pager ( $page, $limit, $list[ 'count' ], $link, 'active', '' );

		return $this->render ( 'index', [
			'list'      => $list,
			'navbar'    => $navbar,
			'totalPage' => $totalPage,
			'total'     => $list[ 'count' ],
			'page'      => $page,
			'limit'     => $limit,
			'params'    => $params
		] );
	}

	/**
	 * 添加商品
	 * @return string
	 */
	public function actionAdd () {
		if ( Yii::$app->request->isPost ) {
			$goodsId = intval ( Yii::$app->request->post ( 'goodsId' ) );
			if ( $goodsId > 0 ) {
				$model = Goods::findOne ( $goodsId );
			} else {
				$model = new Goods();
			}
			$model->postTime = time ();
			if ( $model->load ( Yii::$app->request->post () ) && $model->save () ) {
				$this->redirect ( [ 'goods/index' ] );
			}
		}
		$goodsId = intval ( Yii::$app->request->get ( 'goodsId' ) );
		if ( $goodsId > 0 ) {
			$model = Goods::findOne ( $goodsId );
		} else {
			$model = new Goods();
//			$goodsTags = new GoodsTags();
//			$tags = Tags::getTagsListByLimit(10);
		}

		return $this->render ( 'add', [ 'model' => $model] );
	}

	/**
	 * 上下架操作
	 */
	public function actionAjaxStatus(){
		if(Yii::$app->request->isAjax) {
			$goodsId = intval(Yii::$app->request->post('goodsId'));

			// 检测参数
			if($goodsId < 1) {
				$this->response['code'] = 1;
				$this->response['msg'] = '缺少商品参数';

				return json_encode($this->response);
			}

			// 检测商品是否存在
			$goods = Goods::findOne($goodsId);
			if( empty($goods)) {
				$this->response['code'] = 1;
				$this->response['msg'] = '商品不存在';

				return json_encode($this->response);
			}
			$dataGoods = [];

			if($goods->status != 1) {
				$dataGoods['status'] = 1;
			}else {
				$dataGoods['status'] = 2;
			}

			$return = Yii::$app->db->createCommand()->update(
				"{{%goods}}",
				$dataGoods,
				"`id` = '{$goodsId}'"
			)->execute();
			if($return){
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

	/**
	 * 删除商品
	 * @throws NotFoundHttpException
	 */
	public function actionDelete () {
		$goodsId = intval ( Yii::$app->request->get ( 'goodsId' ) );

		try {
			Goods::deleteGoods ( $goodsId );
		} catch ( \Exception $e ) {
			//throw new \Exception($e->getMessage());

			throw new NotFoundHttpException( $e->getMessage (), 404 );
		}

		$this->redirect ( [ 'goods/index' ] );
	}

	/**
	 * 同步商品库存到redis中
	 * @return string
	 */
	public function actionAjaxSyncToRedis(){
		if(Yii::$app->request->isAjax) {
			$sql = "SELECT `id`, `name`, `price`, `stock`, `status` FROM {{%goods}}";
			$goods = Yii::$app->db->createCommand($sql)->queryAll();
			$stock = 0;
			$len = 0;

			try{
				if(! empty($goods)) {
					foreach ($goods as $key=>$val) {
						$redisStock = Yii::$app->redis->executeCommand('LLEN', ['goodsId-' . $val['id']]);
						if($val['status'] == 1 and $val['stock'] > 0) {
							if($redisStock <= 0 or $redisStock != $val['stock']) {
								$stock += $val['stock'];
								for($i = 0; $i < $val['stock']; $i++) {
									$return = Yii::$app->redis->executeCommand('LPUSH', ['goodsId-' . $val['id'], 1]);
									if($return) {
										$len++;
									}
								}
							}
						}else {
							if($redisStock > 0) { // 去处已下架或者库存不足的商品
								for($i = 0; $i < $redisStock; $i++) {
									Yii::$app->redis->executeCommand("RPOP", ['goodsId-' . $val['id']]);
								}
							}
						}
						//$len = Yii::$app->redis->executeCommand('LLEN', ['goodsId-' . $val['id']]);
						//echo "> goods_{$val['id']}, stock:{$val['stock']}, len:{$len} \n";
					}
					if($len == $stock) {
						$this->response['code'] = 0;
						$this->response['msg'] = '操作成功';

						return json_encode($this->response);
					}else {
						$this->response['code'] = 1;
						$this->response['msg'] = '操作失败' . 'stock:' . $stock . ', len:' . $len;

						return json_encode($this->response);
					}
				}else {
					$this->response['code'] = 1;
					$this->response['msg']= '无商品';

					return json_encode($this->response);
				}
			}catch (\Exception $e) {
				$this->response['code'] = 1;
				$this->response['msg'] = '未知错误: ' . $e->getMessage();

				return json_encode($this->response);
			}

		}
	}

}