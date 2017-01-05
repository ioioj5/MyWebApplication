<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%order_goods}}".
 *
 * @property integer $id
 * @property integer $orderId
 * @property integer $goodsId
 * @property string $goodsName
 * @property string $price
 * @property integer $num
 * @property integer $postTime
 */
class OrderGoods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_goods}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['orderId', 'goodsId', 'goodsName'], 'required'],
            [['orderId', 'goodsId', 'num', 'postTime'], 'integer'],
            [['price'], 'number'],
            [['goodsName'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'orderId' => '订单Id',
            'goodsId' => '商品id',
            'goodsName' => '商品名称',
            'price' => '商品价格',
            'num' => '商品数量',
            'postTime' => '添加时间',
        ];
    }
}
