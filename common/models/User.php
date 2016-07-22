<?php

namespace common\models;

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
	}


	/**
	 * Finds user by username
	 *
	 * @param string $username
	 *
	 * @return static|null
	 */
	public static function findByEmail ( $email ) {
		return static::findOne ( [ 'email' => $email, 'status' => self::STATUS_ACTIVE ] );
	}

	/**
	 * Finds user by password reset token
	 *
	 * @param string $token password reset token
	 *
	 * @return static|null
	 */
	public static function findByPasswordResetToken ( $token ) {
		if ( ! static::isPasswordResetTokenValid ( $token ) ) {
			return null;
		}

		return static::findOne ( [
			'password_reset_token' => $token,
			'status'               => self::STATUS_ACTIVE,
		] );
	}

	/**
	 * Finds out if password reset token is valid
	 *
	 * @param string $token password reset token
	 *
	 * @return boolean
	 */
	public static function isPasswordResetTokenValid ( $token ) {
		if ( empty( $token ) ) {
			return false;
		}

		$timestamp = (int) substr ( $token, strrpos ( $token, '_' ) + 1 );
		$expire    = Yii::$app->params[ 'user.passwordResetTokenExpire' ];

		return $timestamp + $expire >= time ();
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
		return $this->password === md5($password);
	}

	/**
	 * Generates password hash from password and sets it to the model
	 *
	 * @param string $password
	 */
	public function setPassword ( $password ) {
		$this->password_hash = Yii::$app->security->generatePasswordHash ( $password );
	}

	/**
	 * Generates "remember me" authentication key
	 */
	public function generateAuthKey () {
		$this->auth_key = Yii::$app->security->generateRandomString ();
	}

	/**
	 * Generates new password reset token
	 */
	public function generatePasswordResetToken () {
		$this->password_reset_token = Yii::$app->security->generateRandomString () . '_' . time ();
	}

	/**
	 * Removes password reset token
	 */
	public function removePasswordResetToken () {
		$this->password_reset_token = null;
	}
}
