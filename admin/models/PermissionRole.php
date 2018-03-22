<?php

namespace admin\models;

use Yii;
use common\mypublic\Myfunction;

/**
 * This is the model class for table "t_permission_role".
 *
 * @property string $permission_id 权限id
 * @property string $role_id 角色id
 * @property string $create_date 创建时间
 * @property string $update_date 更新时间
 * @property string $creator_id 创建人id
 * @property string $updator_id 更新人id
 */
class PermissionRole extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_permission_role';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['permission_id', 'role_id'], 'required'],
            [['create_date', 'update_date'], 'safe'],
            [['permission_id', 'role_id', 'creator_id', 'updator_id'], 'string', 'max' => 32],
            [['permission_id', 'role_id'], 'unique', 'targetAttribute' => ['permission_id', 'role_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
   /* public function attributeLabels()
    {
        return [
            'permission_id' => 'Permission ID',
            'role_id' => 'Role ID',
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
//                $this->id=Myfunction::getUUID();
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
            Log::createLog('2','增加了角色权限');
        }else{
            Log::createLog('3','修改了角色权限');
        }
        return parent::afterSave($insert,$array);
    }

    /**
     * 删除后添加日志
     */
    public function afterDelete(){
        $name=$this->name;
        Log::createLog('2','删除了角色权限');
        return parent::afterDelete();
    }
}
