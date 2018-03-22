<?php

namespace admin\models;

use Yii;
use common\mypublic\Myfunction;
/**
 * This is the model class for table "t_dictionary_item".
 *
 * @property string $id
 * @property string $type_id 字典类别id
 * @property string $parent_type_id 父级类别id
 * @property string $itrm_name 名称
 * @property string $item_value 内容
 * @property int $item_sort 排序
 * @property string $description 描述
 * @property int $is_enable 否启用 1为禁用
 * @property string $create_date 创建时间
 * @property string $update_date 更新时间
 * @property string $creator_id 创建人id
 * @property string $updator_id 更新人id
 */
class DictionaryItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_dictionary_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type_id', 'item_name', 'item_value'], 'required'],
            [['item_sort', 'is_enable'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['id', 'type_id', 'parent_type_id', 'creator_id', 'updator_id'], 'string', 'max' => 32],
            [['item_name'], 'string', 'max' => 20],
            [['item_value'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 100],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
  /*  public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_id' => 'Type ID',
            'parent_type_id' => 'Parent Type ID',
            'itrm_name' => 'Itrm Name',
            'item_value' => 'Item Value',
            'item_sort' => 'Item Sort',
            'description' => 'Description',
            'is_enable' => 'Is Enable',
            'create_date' => 'Create Date',
            'update_date' => 'Update Date',
            'creator_id' => 'Creator ID',
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
            Log::createLog('2','增加了字典子类');
        }else{
            Log::createLog('3','修改了字典子类');
        }
        return parent::afterSave($insert,$array);
    }

    /**
     * 删除后添加日志
     */
    public function afterDelete(){
        Log::createLog('2','删除了字典子类');
        return parent::afterDelete();
    }
}
