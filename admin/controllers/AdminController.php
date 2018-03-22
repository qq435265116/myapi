<?php
/**
 * Created by PhpStorm.
 * User: KNKJ-3
 * Date: 2018/3/9
 * Time: 14:06
 */

namespace admin\controllers;

use admin\models\AdminLoginForm;
use admin\models\AdminModule;
use admin\models\Adminuser;
use yii\rest\ActiveController;
use common\myerror\ErrorMsg;
use yii\filters\Cors;
use yii\web\Response;
use yii\filters\ContentNegotiator;
use yii;
class AdminController extends ActiveController
{
    public $modelClass="admin\models\Adminuser";
    public function actionLogin(){
        $model=new AdminLoginForm();
        if($model->load(Yii::$app->getRequest()->getBodyParams(),'')&&$model->login()){
            //启用redis 存储权限列表
            $rs=$model->login();

            $p_list=AdminModule::find()
                ->where(['u_id'=>$rs['id']])
                ->asArray()
                ->all();
                $p_list_json=json_encode($p_list);
            $user_name=Yii::$app->request->post('user_name');
            $redis = Yii::$app->redis;
            $redis->set($rs['id'],$rs['access_token']);
            $redis->expire($rs['id'],36000);
            $user=Adminuser::findOne($rs['id']);
            $user->login_date=date("Y-m-d H:i:s");
            $user->login_ip=Yii::$app->getRequest()->getUserIP();
            $user->save();
            $redis->set($user_name,$p_list_json);
            $redis->expire($user_name,36000);
            //返回access_token；permission列表
            return ['data'=>['data'=>[
                'access_token'=>$rs['access_token'],
                'permission'=>$p_list
                ],
                'code'=>0,
                'msg'=>'OK',
                ]];
        }else{
            ErrorMsg::Info(Yii::t('yii','账号或密码错误！'));
        }
    }


}