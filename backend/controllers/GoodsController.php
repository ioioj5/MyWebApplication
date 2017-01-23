<?php
namespace backend\controllers;

use app\models\GoodsTags;
use backend\models\Goods;
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
			$goodsTags = new GoodsTags();
		}

		return $this->render ( 'add', [ 'model' => $model, 'goodsTags'=>$goodsTags ] );
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

}