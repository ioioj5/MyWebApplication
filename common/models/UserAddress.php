<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_address}}".
 *
 * @property integer $id
 * @property integer $userId
 * @property string $name
 * @property string $contact
 * @property string $address
 * @property integer $isDefault
 * @property integer $postTime
 * @property integer $updateTime
 */
class UserAddress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_address}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId', 'name', 'contact', 'address'], 'required'],
            [['userId', 'isDefault', 'postTime', 'updateTime'], 'integer'],
            [['name', 'contact'], 'string', 'max' => 50],
            [['address'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userId' => '用户id',
            'name' => '联系人',
            'contact' => '联系方式(电话,qq,email)',
            'address' => '收货地址',
            'isDefault' => '是否默认地址',
            'postTime' => '添加时间',
            'updateTime' => '更新时间',
        ];
    }
}
