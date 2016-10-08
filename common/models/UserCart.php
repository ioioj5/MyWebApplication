<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_cart}}".
 *
 * @property integer $id
 * @property integer $userId
 * @property integer $goodsId
 * @property integer $num
 * @property integer $postTime
 */
class UserCart extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_cart}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId', 'goodsId', 'num', 'postTime'], 'required'],
            [['userId', 'goodsId', 'num', 'postTime'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '购物车id',
            'userId' => '用户id',
            'goodsId' => '商品id',
            'num' => '数量',
            'postTime' => '添加时间',
        ];
    }

    /**
     * @inheritdoc
     * @return UserCartQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserCartQuery(get_called_class());
    }
}
