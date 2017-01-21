<?php
namespace backend\controllers;

use backend\models\Tags;
use common\components\AdminBaseController;
use Yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

/**
 * 标签管理
 * Class TagsController
 * @package backend\controllers
 */
class TagsController extends AdminBaseController {
	public $enableCsrfValidation = false;
	/**
	 * 标签列表
	 */
	public function actionIndex(){
		$page = intval ( Yii::$app->request->get ( 'page', 1 ) );

		$limit  = 20;
		$offset = ( $page - 1 ) * $limit;
		$params = array ( 'tags/index', 'page' => '{page}' ); // 生成URL参数数组

		$list      = Tags::getTagsList($limit, $offset);
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
	 * 添加标签
	 */
	public function actionAdd(){
		if ( Yii::$app->request->isPost ) {
			$tagId = intval ( Yii::$app->request->post ( 'tagId' ) );
			if ( $tagId > 0 ) {
				$model = Tags::findOne ( $tagId );
			} else {
				$model = new Tags();
			}
			$model->postTime = time ();
			if ( $model->load ( Yii::$app->request->post () ) && $model->save () ) {
				$this->redirect ( [ 'tags/index' ] );
			}
		}
		$tagId = intval ( Yii::$app->request->get ( 'tagId' ) );
		if ( $tagId > 0 ) {
			$model = Tags::findOne ( $tagId );
		} else {
			$model = new Tags();
		}

		return $this->render ( 'add', [ 'model' => $model ] );
	}

	/**
	 * 上下架操作
	 */
	public function actionAjaxStatus(){
		if(Yii::$app->request->isAjax) {
			$tagId = intval(Yii::$app->request->post('tagId'));

			// 检测参数
			if($tagId < 1) {
				$this->response['code'] = 1;
				$this->response['msg'] = '缺少商品参数';

				return json_encode($this->response);
			}

			// 检测商品是否存在
			$tags = Tags::findOne($tagId);
			if( empty($tags)) {
				$this->response['code'] = 1;
				$this->response['msg'] = '商品不存在';

				return json_encode($this->response);
			}
			$dataTags = [];

			if($tags->status != 1) {
				$dataTags['status'] = 1;
			}else {
				$dataTags['status'] = 0;
			}

			$return = Yii::$app->db->createCommand()->update(
				"{{%tags}}",
				$dataTags,
				"`id` = '{$tagId}'"
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
		$tagId = intval ( Yii::$app->request->get ( 'tagId' ) );

		try {
			Tags::deleteTags ( $tagId );
		} catch ( \Exception $e ) {
			//throw new \Exception($e->getMessage());

			throw new NotFoundHttpException( $e->getMessage (), 404 );
		}

		$this->redirect ( [ 'tags/index' ] );
	}
}