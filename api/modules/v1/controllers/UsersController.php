<?php
namespace api\modules\v1\controllers;

use yii\rest\ActiveController;

class UsersController extends ActiveController {
	public $modelClass = 'common\models\User';
}