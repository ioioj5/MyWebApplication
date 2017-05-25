<?php
namespace common\models;

use common\lib\Bcrypt;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model {
	public $username;
	public $email;
	public $password;

	/**
	 * @inheritdoc
	 */
	public function rules () {
		return [
			[ 'email', 'filter', 'filter' => 'trim' ],
			[ 'email', 'required' ],
			[ 'email', 'email' ],
			[ 'email', 'string', 'max' => 255 ],
			[ 'email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.' ],

			[ 'password', 'required' ],
			[ 'password', 'string', 'min' => 6 ],
		];
	}

	/**
	 * Signs user up.
	 *
	 * @return User|null the saved model or null if saving fails
	 */
	public function signup () {
		if ( ! $this->validate () ) {
			return null;
		}

		$user        = new User();
		$user->email = $this->email;

		$bcrypt          = new Bcrypt ( 15 );
		$user->password  = $bcrypt->hash ( $this->password );
		$user->token     = Yii::$app->security->generateRandomString ();
		$user->regtime   = time ();
		$user->loginTime = time ();
		$user->status    = 1;

		return $user->save () ? $user : null;
	}
}
