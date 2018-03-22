<?php

namespace admin\models;

use Yii;
use common\mypublic\Myfunction;

/**
 * This is the model class for table "t_role".
 *
 * @property string $id
 * @property string $role_name 角色名称
 * @property string $description 简介
 * @property bool $is_enabled
 * @property int $order_sort 排序
 * @property string $update_date 更新时间
 * @property string $create_date 创建时间
 * @property string $creator_id 创建人id
 * @property string $updator_id 更新人id
 */
class Role extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_role';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role_name', 'order_sort'], 'required'],
            [['is_enabled'], 'boolean'],
            [['order_sort'], 'integer'],
            [['update_date', 'create_date'], 'safe'],
            [['id', 'creator_id', 'updator_id'], 'string', 'max' => 32],
            [['role_name'], 'string', 'max' => 20],
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
            'role_name' => 'Role Name',
            'description' => 'Description',
            'is_enabled' => 'Is Enabled',
            'order_sort' => 'Order Sort',
            'update_date' => 'Update Date',
            'create_date' => 'Create Date',
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
            Log::createLog('2','增加了角色');
        }else{
            Log::createLog('3','修改了角色');
        }
        return parent::afterSave($insert,$array);
    }
    /**
     * 删除前删除所有角色相关信息
     */
    public function beforeDelete(){
        PermissionRole::deleteAll('role_id = :role_id', [':role_id' => $this->id]);
        RoleUser::deleteAll('role_id = :role_id', [':role_id' => $this->id]);
        return  parent::beforeDelete();
    }
    /**
     * 删除后添加日志
     */
    public function afterDelete(){
        Log::createLog('2','删除了角色');
        return parent::afterDelete();
    }
}
