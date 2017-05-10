<?php
namespace common\models;

use common\lib\Bcrypt;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Login form
 */
class LoginForm extends Model {
	public $email;
	public $password;
	public $rememberMe = true;

	private $_user;

	/**
	 * @inheritdoc
	 */
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
	 * Validates the password.
	 * This method serves as the inline validation for password.
	 *
	 * @param string $attribute the attribute currently being validated
	 * @param array  $params    the additional name-value pairs given in the rule
	 */
	public function validatePassword ( $attribute, $params ) {
		if ( ! $this->hasErrors () ) {
			$user = $this->getUser ();
			if ( ! $user || ! $user->validatePassword ( $this->password ) ) {
				$this->addError ( $attribute, 'Incorrect email or password.' );
			}
		}
	}

	/**
	 * Logs in a user using the provided username and password.
	 *
	 * @return boolean whether the user is logged in successfully
	 */
	public function login () {
		if ( $this->validate () ) {
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
		} else {
			return false;
		}
	}

	/**
	 * Finds user by [[username]]
	 *
	 * @return User|null
	 */
	protected function getUser () {
		if ( $this->_user === null ) {
			$this->_user = User::findByEmail ( $this->email );
		}

		return $this->_user;
	}
}
