<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%order_log}}".
 *
 * @property integer $id
 * @property integer $userId
 * @property integer $orderId
 * @property integer $orderStatus
 * @property string $remarks
 * @property integer $postTime
 */
class OrderLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId', 'orderId', 'orderStatus', 'remarks', 'postTime'], 'required'],
            [['userId', 'orderId', 'orderStatus', 'postTime'], 'integer'],
            [['remarks'], 'string', 'max' => 255]
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
            'orderId' => '订单id',
            'orderStatus' => '订单状态',
            'remarks' => '备注',
            'postTime' => '添加时间',
        ];
    }
}
