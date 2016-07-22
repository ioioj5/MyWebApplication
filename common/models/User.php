<?php

namespace common\models;

use common\lib\Bcrypt;
use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string  $email
 * @property string  $password
 * @property string  $token
 * @property integer $regtime
 * @property integer $logintime
 * @property integer $status
 */
class User extends ActiveRecord implements IdentityInterface {
	const STATUS_DELETED = 0;
	const STATUS_ACTIVE  = 1;

	/**
	 * @inheritdoc
	 */
	public static function tableName () {
		return '{{%user}}';
	}

	/**
	 * @inheritdoc
	 */
	public function rules () {
		return [
			[ [ 'email', 'password', 'token', 'regtime' ], 'required' ],
			[ [ 'regtime', 'logintime', 'status' ], 'integer' ],
			[ [ 'email' ], 'string', 'max' => 50 ],
			[ [ 'password', 'token' ], 'string', 'max' => 64 ]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels () {
		return [
			'id'        => 'ID',
			'email'     => '登入邮箱',
			'password'  => '密码',
			'token'     => 'Token',
			'regtime'   => '注册时间',
			'logintime' => '登入时间',
			'status'    => '用户状态(1-正常,0-关闭)',
		];
	}

	/**
	 * Finds an identity by the given ID.
	 *
	 * @param string|integer $id the ID to be looked for
	 *
	 * @return IdentityInterface the identity object that matches the given ID.
	 * Null should be returned if such an identity cannot be found
	 * or the identity is not in an active state (disabled, deleted, etc.)
	 */
	public static function findIdentity ( $id ) {
		// TODO: Implement findIdentity() method.
		return static::findOne ( [ 'id' => $id, 'status' => self::STATUS_ACTIVE ] );
	}

	/**
	 * Finds an identity by the given token.
	 *
	 * @param mixed $token the token to be looked for
	 * @param mixed $type  the type of the token. The value of this parameter depends on the implementation.
	 *                     For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be
	 *                     `yii\filters\auth\HttpBearerAuth`.
	 *
	 * @return IdentityInterface the identity object that matches the given token.
	 * Null should be returned if such an identity cannot be found
	 * or the identity is not in an active state (disabled, deleted, etc.)
	 */
	public static function findIdentityByAccessToken ( $token, $type = null ) {
		// TODO: Implement findIdentityByAccessToken() method.
		return static::findOne(['token' => $token]);
	}


	/**
	 * @param $email
	 *
	 * @return null|static
	 */
	public static function findByEmail ( $email ) {
		return static::findOne ( [ 'email' => $email, 'status' => self::STATUS_ACTIVE ] );
	}

	/**
	 * @inheritdoc
	 */
	public function getId () {
		return $this->getPrimaryKey ();
	}

	/**
	 * @inheritdoc
	 */
	public function getAuthKey () {
		return $this->token;
	}

	/**
	 * @inheritdoc
	 */
	public function validateAuthKey ( $authKey ) {
		return $this->getAuthKey () === $authKey;
	}

	/**
	 * Validates password
	 *
	 * @param string $password password to validate
	 *
	 * @return boolean if password provided is valid for current user
	 */
	public function validatePassword ( $password ) {
		$bcrypt = new Bcrypt ( 15 );

		return $bcrypt->verify ( $password, $this->password );
	}
}
