<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%admin}}".
 *
 * @property integer $id
 * @property string  $username
 * @property string  $password
 * @property string  $email
 * @property string  $token
 * @property integer $addtime
 * @property integer $status
 */
class Admin extends ActiveRecord implements IdentityInterface {
	const STATUS_DELETED = 0;
	const STATUS_ACTIVE  = 1;
	/**
	 * @inheritdoc
	 */
	public static function tableName () {
		return '{{%admin}}';
	}

	/**
	 * @inheritdoc
	 */
	public function rules () {
		return [
			[ [ 'username', 'password', 'email', 'token' ], 'required' ],
			[ [ 'addtime', 'status' ], 'integer' ],
			[ [ 'username' ], 'string', 'max' => 20 ],
			[ [ 'password', 'token' ], 'string', 'max' => 64 ],
			[ [ 'email' ], 'string', 'max' => 50 ]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels () {
		return [
			'id'       => 'ID',
			'username' => '用户名',
			'password' => '密码',
			'email'    => '邮箱',
			'token'    => 'token',
			'addtime'  => '添加时间',
			'status'   => 'Status',
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
	 * Returns an ID that can uniquely identify a user identity.
	 * @return string|integer an ID that uniquely identifies a user identity.
	 */
	public function getId () {
		// TODO: Implement getId() method.
		return $this->getPrimaryKey ();
	}

	/**
	 * Returns a key that can be used to check the validity of a given identity ID.
	 *
	 * The key should be unique for each individual user, and should be persistent
	 * so that it can be used to check the validity of the user identity.
	 *
	 * The space of such keys should be big enough to defeat potential identity attacks.
	 *
	 * This is required if [[User::enableAutoLogin]] is enabled.
	 * @return string a key that is used to check the validity of a given identity ID.
	 * @see validateAuthKey()
	 */
	public function getAuthKey () {
		// TODO: Implement getAuthKey() method.
		return $this->token;
	}

	/**
	 * Validates the given auth key.
	 *
	 * This is required if [[User::enableAutoLogin]] is enabled.
	 *
	 * @param string $authKey the given auth key
	 *
	 * @return boolean whether the given auth key is valid.
	 * @see getAuthKey()
	 */
	public function validateAuthKey ( $authKey ) {
		// TODO: Implement validateAuthKey() method.
		return $this->getAuthKey () === $authKey;
	}
}
