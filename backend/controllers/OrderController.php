<?php
/**
 * Created by PhpStorm.
 * User: ioioj5
 * Date: 2017/1/6
 * Time: 4:09
 */

namespace backend\controllers;


use backend\models\Order;
use common\components\AdminBaseController;
use Yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

class OrderController extends AdminBaseController {
	/**
	 * 订单列表
	 * @return string
	 */
	public function actionIndex () {
		$page = intval ( Yii::$app->request->get ( 'page', 1 ) );

		$limit  = 20;
		$offset = ( $page - 1 ) * $limit;
		$params = array ( 'goods/index', 'page' => '{page}' ); // 生成URL参数数组
		$condition = [];

		$list      = Order::getOrderList($condition, $limit, $offset);
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
	 * 订单详情
	 * @return string
	 * @throws NotFoundHttpException
	 */
	public function actionDetail(){
		$orderId = intval(Yii::$app->request->get('orderId'));

		if($orderId < 1) {
			throw new NotFoundHttpException('缺少订单id', 404);
		}

		$orderInfo = Order::getOneById($orderId);


		return $this->render('detail', ['orderInfo'=>$orderInfo]);
	}
}