<?php
namespace backend\controllers;


use backend\models\Log;
use common\components\AdminBaseController;
use Yii;
use yii\helpers\Url;

class LogController extends AdminBaseController {
	public function actionIndex(){

		$page = intval ( Yii::$app->request->get ( 'page', 1 ) );

		$limit  = 20;
		$offset = ( $page - 1 ) * $limit;
		$params = array ( 'log/index', 'page' => '{page}' ); // 生成URL参数数组
		$condition = [];
		$list      = Log::getLogList ($condition, $limit, $offset);

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