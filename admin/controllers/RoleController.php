<?php
/**
 * Created by PhpStorm.
 * User: KNKJ-3
 * Date: 2018/3/9
 * Time: 15:26
 */

namespace admin\controllers;

use admin\models\PermissionRole;
use admin\models\RoleModule;
use admin\models\RoleUser;
use yii\data\ActiveDataProvider;
use admin\components\Controller;
class RoleController extends Controller
{
    public $modelClass='admin\models\Role';
    /**
     * 配置新的页面容量
     */
    public function actions(){
        $actions=parent::actions();
        unset($actions['index']);
        return $actions;
    }

    public function actionIndex(){
        $modelClass=$this->modelClass;
        return new ActiveDataProvider(
            [
                'query'=>$modelClass::find()->asArray(),
                //设置不加分页
                'pagination'=>false,
                //设置每页页面容量
//                'pagination'=>['pageSize'=>5]
            ]
        );
    }
    /**
     * 授权函数
     */
    public function actionEmpower(){
        $permission=\Yii::$app->getRequest()->getBodyParams()['permission_id'];
        $role_id=\Yii::$app->getRequest()->getBodyParams()['role_id'];
        if($role_id){
            PermissionRole::deleteAll('role_id = :role_id', [':role_id' => $role_id]);
        }
        $row=[];
        foreach ($permission as $v){
            $row[]=array(
                'role_id'=>$role_id,
                'permission_id'=>$v,
                'creator_id'=>\Yii::$app->user->id,
                'updator_id'=>\Yii::$app->user->id,
            );
        }
        $rs=\Yii::$app->db->createCommand()
            ->batchInsert(PermissionRole::tableName(),
            ['role_id', 'permission_id','creator_id','updator_id'],
            $row)
            ->execute();
        echo json_encode(['data'=>['data' => $rs, 'code' => '0','msg'=>'Ok']]);
        exit(0);
//        return
    }
    /**
     * 角色权限列表
     */
    public function actionRoleModule(){
        return RoleModule::find()
            ->where(['r_id'=>\Yii::$app->getRequest()->getBodyParams()['role_id']])
            ->asArray()
            ->all();
    }
    /**
     * 分配角色
     */
    public function actionDistributionRole(){
        $role_id=\Yii::$app->getRequest()->getBodyParams()['role_id'];
        $user_id=\Yii::$app->getRequest()->getBodyParams()['user_id'];
        if($user_id){
            RoleUser::deleteAll('user_id = :user_id', [':user_id' => $user_id]);
        }
        $row=[];
        foreach ($role_id as $v){
            $row[]=array(
                'user_id'=>$user_id,
                'role_id'=>$v,
                'creator_id'=>\Yii::$app->user->id,
                'updator_id'=>\Yii::$app->user->id,
            );
        }
        $rs=\Yii::$app->db->createCommand()
            ->batchInsert(RoleUser::tableName(),
                ['user_id', 'role_id','creator_id','updator_id'],
                $row)
            ->execute();
        echo json_encode(['data'=>['data' => $rs, 'code' => '0','msg'=>'Ok']]);
        exit(0);
    }
}