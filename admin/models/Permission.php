<?php

namespace admin\models;

use Yii;
use common\mypublic\Myfunction;
/**
 * This is the model class for table "t_permission".
 *
 * @property string $id
 * @property string $name 权限名称
 * @property string $code 模块编号
 * @property string $description 简介
 * @property bool $is_enabled 是否启用 0为启用 1为禁用
 * @property string $module_id 模块id
 * @property string $update_date 更新时间
 * @property string $create_date 创建时间
 * @property string $creator_id 创建人id
 * @property string $updator_id 修改人id
 */
class Permission extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_permission';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'code', 'module_id'], 'required'],
            [['is_enabled'], 'boolean'],
            [['update_date', 'create_date'], 'safe'],
            [['id', 'creator_id', 'updator_id'], 'string', 'max' => 32],
            [['name'], 'string', 'max' => 20],
            [['code'], 'string', 'max' => 225],
            [['description'], 'string', 'max' => 100],
            [['module_id'], 'string', 'max' => 50],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
   /* public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'code' => 'Code',
            'description' => 'Description',
            'is_enabled' => 'Is Enabled',
            'module_id' => 'Module ID',
            'update_date' => 'Update Date',
            'create_date' => 'Create Date',
            'creator_id' => 'Creator ID',
            'updator_id' => 'Updator ID',
        ];
    }*/
    /**
     * 设置创建人/修改人的id
     */
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
        $name=$this->name;
        if($insert){
            Log::createLog('2','增加了权限',$name);
        }else{
            Log::createLog('3','修改了权限',$name);
        }
        return parent::afterSave($insert,$array);
    }

    /**
     * 删除后添加日志
     */
    public function afterDelete(){
        $name=$this->name;
        Log::createLog('2','删除了权限',$name);
        return parent::afterDelete();
    }
}
