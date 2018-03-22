<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "t_commodity".
 *
 * @property string $id
 * @property string $name 商品名称
 * @property string $price 销售价格
 * @property string $old_price 原价
 * @property string $commodity_type_id 商品类别id
 * @property int $state 状态 0上架 1下架
 */
class Commodity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_commodity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name', 'price', 'commodity_type_id'], 'required'],
            [['price', 'old_price'], 'number'],
            [['state'], 'integer'],
            [['id', 'commodity_type_id'], 'string', 'max' => 32],
            [['name'], 'string', 'max' => 20],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'price' => 'Price',
            'old_price' => 'Old Price',
            'commodity_type_id' => 'Commodity Type ID',
            'state' => 'State',
        ];
    }
}
