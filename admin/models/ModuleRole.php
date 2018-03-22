<?php

namespace admin\models;

use Yii;
use common\mypublic\Myfunction;

/**
 * This is the model class for table "t_module_role".
 *
 * @property string $module_id 权限id
 * @property string $role_id 角色id
 * @property string $rank 数据访问级别（默认：1-私有，只允许查询自己的）
 * @property string $create_date 创建时间
 * @property string $update_date 更新时间
 * @property string $creator_id 创建人id
 * @property string $updator_id 更新人id
 */
class ModuleRole extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_module_role';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['module_id', 'role_id'], 'required'],
            [['rank'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['module_id', 'role_id', 'creator_id', 'updator_id'], 'string', 'max' => 32],
            [['module_id', 'role_id'], 'unique', 'targetAttribute' => ['module_id', 'role_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    /*public function attributeLabels()
    {
        return [
            'module_id' => 'Module ID',
            'role_id' => 'Role ID',
            'rank' => 'Rank',
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
        $name=$this->name;
        if($insert){
            Log::createLog('2','增加了私密模块',$name);
        }else{
            Log::createLog('3','修改了私密模块',$name);
        }
        return parent::afterSave($insert,$array);
    }

    /**
     * 删除后添加日志
     */
    public function afterDelete(){
        $name=$this->name;
        Log::createLog('2','删除了私密模块',$name);
        return parent::afterDelete();
    }
}
