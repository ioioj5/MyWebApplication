<?php
/**
 *
 * author: dupeng
 * createTime: 2016/10/8 18:48
 */

namespace frontend\controllers;


use common\components\FrontController;
use frontend\models\UserCart;
use Yii;
use yii\helpers\Url;

class CartController extends FrontController {
	public function actionIndex(){
		$page = intval ( Yii::$app->request->get ( 'page' ) );

		$limit  = 20;
		$offset = ( $page - 1 ) * $limit;
		$params = array ( 'cart/index', 'page' => '{page}' ); // 生成URL参数数组

		$list      = UserCart::getCartsByLimit ( Yii::$app->user->id, $limit, $offset );

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
}