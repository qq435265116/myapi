<?php
/**
 * Created by PhpStorm.
 * User: KNKJ-3
 * Date: 2018/3/1
 * Time: 11:37
 */

namespace api\controllers;

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
//    public function afterAction($action, $result)
//    {
//        $rs = parent::afterAction($action, $result);
//        // 也可以再定义 response
//         $response = Yii::$app->response;
////         unset($response->statusCode);
////         $response->statusCode = 200;
////         $response->data = ['message' => 'hello world'];
////         var_dump($response->headers->set('test','123'));
////        $response->statusCode=200;
//        $response->headers->removeAll();
//        return ['data' => $rs, 'error' => '0'];
//    }

}