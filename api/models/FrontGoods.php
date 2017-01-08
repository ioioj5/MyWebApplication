<?php
namespace frontend\models;

use common\models\Goods;

class FrontGoods extends Goods {
	public function __construct ( array $config ) { parent::__construct ( $config ); }

}