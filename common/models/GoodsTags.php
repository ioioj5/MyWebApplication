<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%goods_tags}}".
 *
 * @property integer $id
 * @property integer $goodsId
 * @property integer $tagId
 * @property integer $postTime
 */
class GoodsTags extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods_tags}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goodsId', 'tagId'], 'required'],
            [['goodsId', 'tagId', 'postTime'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goodsId' => 'Goods ID',
            'tagId' => 'Tag ID',
            'postTime' => 'Post Time',
        ];
    }
}
