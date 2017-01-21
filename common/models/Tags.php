<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tags}}".
 *
 * @property integer $id
 * @property string $tagName
 * @property integer $postTime
 * @property integer $status
 */
class Tags extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tags}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tagName'], 'required'],
            [['postTime', 'status'], 'integer'],
            [['tagName'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tagName' => '标签名称',
            'postTime' => '添加时间',
            'status' => '0-不可用, 1-可用',
        ];
    }
}
