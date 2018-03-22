<?php

namespace admin\models;

use Yii;
use common\mypublic\Myfunction;
/**
 * This is the model class for table "t_module".
 *
 * @property string $id
 * @property string $parent_id 父级id
 * @property string $name 模块名称
 * @property string $link_url 模块链接地址
 * @property bool $is_menu 是否是目录
 * @property string $description 模块简介
 * @property bool $enabled 是否启用 0未启用 1为禁用
 * @property string $update_date 更新时间
 * @property string $icon 图标
 * @property string $create_date 创建时间
 * @property string $creator_id 创建人id
 * @property string $updator_id 修改人id
 */
class Module extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_module';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'link_url',], 'required'],
            [['is_menu', 'is_enabled'], 'boolean'],
            [['update_date', 'create_date'], 'safe'],
            [['id', 'parent_id', 'creator_id', 'updator_id'], 'string', 'max' => 32],
            [['name', 'icon'], 'string', 'max' => 20],
            [['link_url'], 'string', 'max' => 50],
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
            'parent_id' => 'Parent ID',
            'name' => 'Name',
            'link_url' => 'Link Url',
            'is_menu' => 'Is Menu',
            'description' => 'Description',
            'enabled' => 'Enabled',
            'update_date' => 'Update Date',
            'icon' => 'Icon',
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
        $name=$this->name;
            if($insert){
                Log::createLog('2','增加了模块'.$name);
            }else{
                Log::createLog('3','修改了模块'.$name);
            }
            return parent::afterSave($insert,$array);
    }

    /**
     * 删除后添加日志
     */
    public function afterDelete(){
        $name=$this->name;
            Log::createLog('2','删除了模块'.$name);
        return parent::afterDelete();
    }
}
