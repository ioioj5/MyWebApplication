<?php
/**
 * Created by PhpStorm.
 * User: ioioj5
 * Date: 2017/5/20
 * Time: 13:22
 */

namespace common\models;

/**
 * GoodsRedis ActiveRecord
 * Class GoodsRedis
 * @package common\models
 */
class GoodsRedis extends \yii\redis\ActiveRecord {
	public function attributes () {
		return [ 'id', 'name', 'price', 'stock', 'postTime', 'status' ];
	}
}