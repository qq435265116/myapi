<?php
/**
 * Created by PhpStorm.
 * User: KNKJ-3
 * Date: 2018/3/1
 * Time: 11:37
 */

namespace api\controllers;

use api\models\LoginForm;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use common\models\Article;
use yii\data\ActiveDataProvider;
use yii\filters\auth\QueryParamAuth;
use yii;
class UserController extends ActiveController
{
    public $modelClass="common\models\User";
    public function actionLogin(){
        $model=new LoginForm();
//        $model->username=Yii::$app->getRequest()->getBodyParams()['username'];
//        $model->password=Yii::$app->getRequest()->getBodyParams()['password'];
        if($model->load(Yii::$app->getRequest()->getBodyParams(),'')&&$model->login()){
            return ['access_token'=>$model->login()];
        }else{
            $model->validate();
            return $model;
        }
    }


}