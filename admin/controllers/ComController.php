<?php
/**
 * Created by PhpStorm.
 * User: KNKJ-3
 * Date: 2018/3/1
 * Time: 11:37
 */

namespace admin\controllers;

use yii\filters\auth\HttpHeaderAuth;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii;
class ComController extends ActiveController
{
    public function behaviors(){
        return ArrayHelper::merge(parent::behaviors(),[
            'authenticatior'=>[
                'class'=>HttpHeaderAuth::className(),
                'header'=>'accessToken',
            ]
        ]);
    }
    /**
     * 检验权限
     */
    public function checkAccess($action, $model = null, $params = [])
    {
//        $model=UserRole::find()
//            ->where(['user_id'=>Yii::$app->user->id])
//            ->one();

//        if(!in_array($action,$params)){
//            var_dump(in_array($action,$params));
//            var_dump($action);
//            exit(0);
//            throw new UnauthorizedHttpException('您没有权限，请重新登陆！');
//        }
//        throw new UnauthorizedHttpException('您没有权限，请重新登陆！');

    }
    public function afterAction($action, $result)
    {
        $rs = parent::afterAction($action, $result);
        return ['data' => $rs, 'error' => '0','msg'=>'Ok'];
    }
}