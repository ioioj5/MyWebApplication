<?php
/**
 * Created by PhpStorm.
 * User: ioioj5
 * Date: 2017/5/22
 * Time: 22:33
 */

namespace common\models;


use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class UserAuthLocal extends Model {
	public $email;
	public $password;
	public $rememberMe = true;

	private $_user;


	public function rules () {
		return [
			// username and password are both required
			[ [ 'email', 'password' ], 'required' ],
			// rememberMe must be a boolean value
			[ 'rememberMe', 'boolean' ],
			// password is validated by validatePassword()
			[ 'password', 'validatePassword' ],
		];
	}

	/**
	 * 获取用户
	 * @return null|static
	 */
	protected function getUser () {
		if ( $this->_user === null ) {
			$this->_user = User::findByEmail ( $this->email );
		}

		return $this->_user;
	}

	public function validatePassword ( $attribute, $params ) {
		if ( ! $this->hasErrors () ) {
			$user = $this->getUser ();
			if ( ! $user || ! $user->validatePassword ( $this->password ) ) {
				$this->addError ( $attribute, 'Incorrect email or password.' );
			}
		}
	}
	public function login(){
		if($this->validate()){
			$user = $this->getUser ();
			// 记录用户登入信息
			Yii::trace (
				ArrayHelper::toArray (
					$user,
					[
						'common\models\User'=> [
							'id',
							'email',
							'loginTime'=>function($user){
								return date('Y-m-d H:i:s', $user->loginTime);
							},
							'status'=>function($user) {
								if($user->status == 1) {
									return '正常';
								}else {
									return '关闭';
								}
							}
						]
					]
				),
				__METHOD__
			);
			return Yii::$app->user->login ( $user, $this->rememberMe ? 3600 * 24 * 30 : 0 );
		}else {
			return false;
		}
	}
}