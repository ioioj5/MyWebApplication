<?php
namespace console\controllers;


use common\components\ConsoleBaseController;
use Yii;

class UserController extends ConsoleBaseController {
	/**
	 * 清除用户
	 */
	public function actionCleanUsers(){
		Yii::$app->db->createCommand("TRUNCATE `tbl_user`")->execute();
		Yii::$app->db->createCommand("TRUNCATE `tbl_user_address`")->execute();
		Yii::$app->db->createCommand("TRUNCATE `tbl_user_cart`")->execute();
		Yii::$app->db->createCommand("TRUNCATE `tbl_order`")->execute();
		Yii::$app->db->createCommand("TRUNCATE `tbl_order_address`")->execute();
		Yii::$app->db->createCommand("TRUNCATE `tbl_order_goods`")->execute();
		Yii::$app->db->createCommand("TRUNCATE `tbl_order_log`")->execute();
	}
}