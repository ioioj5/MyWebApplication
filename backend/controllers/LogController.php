<?php
namespace backend\controllers;


use backend\models\Log;
use common\components\AdminBaseController;
use Yii;
use yii\helpers\Url;

class LogController extends AdminBaseController {
	public function actionIndex(){
		if(Yii::$app->request->isPost) {
			$page = intval ( Yii::$app->request->post ( 'page', 1 ) );
			$level = intval(Yii::$app->request->post('level', 0)); // 错误级别
		}else {
			$page = intval ( Yii::$app->request->get ( 'page', 1 ) );
			$level = intval(Yii::$app->request->get('level', 0)); // 错误级别
		}
		$limit  = 20;
		$offset = ( $page - 1 ) * $limit;
		$params = ['log/index', 'page' => '{page}']; // 生成URL参数数组
		$condition = [];
		if(isset($level) and ! empty($level)) {
			$condition['level'] = $level;
			$params['level']= $level;
		}
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