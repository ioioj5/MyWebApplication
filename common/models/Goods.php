<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%goods}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $price
 * @property integer $stock
 * @property integer $postTime
 * @property integer $status
 */
class Goods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'postTime'], 'required'],
            [['price'], 'number'],
            [['stock', 'postTime', 'status'], 'integer'],
            [['name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '商品名称',
            'price' => '商品价格',
            'stock' => '库存',
            'postTime' => '添加时间',
            'status' => '0-不可用, 1- 上架， 2-下架',
        ];
    }
}
