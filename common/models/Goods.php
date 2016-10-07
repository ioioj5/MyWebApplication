<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%goods}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $price
 * @property integer $postTime
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
            [['name', 'price', 'postTime'], 'required'],
            [['price'], 'number'],
            [['postTime'], 'integer'],
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
            'postTime' => '添加时间',
        ];
    }

    /**
     * @inheritdoc
     * @return GoodsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GoodsQuery(get_called_class());
    }
}
