<?php

namespace admin\models;

use Yii;
use common\mypublic\Myfunction;

/**
 * This is the model class for table "t_dictionary_type".
 *
 * @property string $id
 * @property string $parent_type_id 父级id
 * @property string $type_name 字典类名称
 * @property string $type_code 编码
 * @property int $type_sort 排序
 * @property string $description 简介
 * @property string $create_date 创建时间
 * @property string $update_date 更新时间
 * @property string $creatoe_id 创建人id
 * @property string $updator_id 更新人id
 */
class DictionaryType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_dictionary_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type_name', 'type_code'], 'required'],
            [['type_sort'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['id', 'parent_type_id', 'creator_id', 'updator_id'], 'string', 'max' => 32],
            [['type_name'], 'string', 'max' => 25],
            [['type_code'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 100],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    /*public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_type_id' => 'Parent Type ID',
            'type_name' => 'Type Name',
            'type_code' => 'Type Code',
            'type_sort' => 'Type Sort',
            'description' => 'Description',
            'create_date' => 'Create Date',
            'update_date' => 'Update Date',
            'creatoe_id' => 'Creatoe ID',
            'updator_id' => 'Updator ID',
        ];
    }*/
    /**
     * 设置创建人/修改人的id
     */
    public function beforeSave($insert){
        if(parent::beforeSave($insert)){
            if($insert){
                $this->id=Myfunction::getUUID();
                $this->creator_id=Yii::$app->user->id;
                $this->updator_id=Yii::$app->user->id;
            }else{
                $this->update_date=date('Y-m-d H:i:s');
                $this->updator_id=Yii::$app->user->id;
            }
            return true;
        }else{
            return false;

        }
    }
    /**
     * 修改过添加后添加日志
     */
    public function afterSave($insert,$array){
        if($insert){
            Log::createLog('2','增加了字典类');
        }else{
            Log::createLog('3','修改了字典类');
        }
        return parent::afterSave($insert,$array);
    }

    /**
     * 删除后添加日志
     */
    public function afterDelete(){
        Log::createLog('4','删除了字典类');
        return parent::afterDelete();
    }
}
