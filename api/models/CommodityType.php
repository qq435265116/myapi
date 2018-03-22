<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "t_commodity_type".
 *
 * @property string $id
 * @property string $type_name 类别名称
 * @property string $pid 父级id 默认0最上级
 */
class CommodityType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_commodity_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'type_name'], 'required'],
            [['id', 'pid'], 'string', 'max' => 32],
            [['type_name'], 'string', 'max' => 20],
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
            'type_name' => 'Type Name',
            'pid' => 'Pid',
        ];
    }
}
