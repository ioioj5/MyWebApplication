<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property integer $id
 * @property integer $userId
 * @property string $orderCode
 * @property string $price
 * @property integer $payStatus
 * @property integer $orderStatus
 * @property integer $payTime
 * @property integer $postTime
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId', 'orderCode', 'price', 'payStatus', 'orderStatus', 'payTime', 'postTime'], 'required'],
            [['userId', 'payStatus', 'orderStatus', 'payTime', 'postTime'], 'integer'],
            [['price'], 'number'],
            [['orderCode'], 'string', 'max' => 24]
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
            'orderCode' => '订单号',
            'price' => '订单价格',
            'payStatus' => '支付状态',
            'orderStatus' => '订单状态',
            'payTime' => '支付时间',
            'postTime' => '订单生成时间',
        ];
    }
}
