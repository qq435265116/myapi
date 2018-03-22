<?php
/**
 * Created by PhpStorm.
 * User: KNKJ-3
 * Date: 2018/3/10
 * Time: 16:19
 */

namespace admin\components;

use common\myerror\ErrorMsg;
use yii\filters\auth\HttpHeaderAuth;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\Cors;
use yii;
class Controller extends ActiveController
{
    public function behaviors(){
        if(Yii::$app->getRequest()->getMethod() !== 'OPTIONS'){
            return ArrayHelper::merge(parent::behaviors(),[
//            'authenticatior'=>[
//                'class'=>HttpHeaderAuth::className(),
//                'header'=>'accessToken',
//            ],
                'corsFilter'  => [
                    'class' => Cors::className(),
                    'cors'  => [
                        'Origin' => ['*'],
                        'Access-Control-Request-Headers' => ['*'],
                        'Access-Control-Allow-Credentials' => true,
                    ],
                ],
            ]);
        }else{
            return ArrayHelper::merge(parent::behaviors(),[
                'authenticatior'=>[
                    'class'=>HttpHeaderAuth::className(),
                    'header'=>'accessToken',
                ],
                'corsFilter'  => [
                    'class' => Cors::className(),
                    'cors'  => [
                        'Origin' => ['*'],
                        'Access-Control-Request-Headers' => ['*'],
                        'Access-Control-Allow-Credentials' => true,
                    ],
                ],
            ]);
        }

    }
    /**
     * 检验权限
     */
//    public function checkAccess($action, $model = null, $params = [])
//    {
//        $redis = Yii::$app->redis;
//
//        $parray=json_decode($redis->get(Yii::$app->user->identity->user_name),true );
//        $str = preg_replace_callback('/-+([a-z])/',function($matches){
//            return strtoupper($matches[1]);
//        },$action);
//        $result=false;
//        foreach ($parray as $v){
//            if($v['m_link_url']==$str){
//                $result=true;
//            }
//        }
//        if(!$result){
//            ErrorMsg::Info(Yii::t('yii','您没有权限进行此操作！'));
//        }
//
//    }
    public function afterAction($action, $result)
    {
//        var_dump($action);
        if(!$result){
            $result=['data'=>['data' => '', 'code' => '0','msg'=>'Ok']];
            echo json_encode($result);
            exit(0);
        }else{
            $type=false;
            $rs = parent::afterAction($action, $result);
            foreach ($rs as $v){
                if(!is_array($v)){
                    $type=true;
                }
            }
            if($type){
                $rs=array($rs);
            }
//        echo 123;
            return ['data'=>['data' => $rs, 'code' => '0','msg'=>'Ok']];
        }
    }

}