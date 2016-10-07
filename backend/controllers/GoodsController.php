<?php
namespace backend\controllers;

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
		}

		return $this->render ( 'add', [ 'model' => $model ] );
	}

	/**
	 * 上下架操作
	 */
	public function actionStatus(){
		$goodsId = intval(Yii::$app->request->get('goodsId'));

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