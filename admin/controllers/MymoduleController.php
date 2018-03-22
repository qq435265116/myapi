<?php
/**
 * Created by PhpStorm.
 * User: KNKJ-3
 * Date: 2018/3/9
 * Time: 15:26
 */

namespace admin\controllers;

use yii\data\ActiveDataProvider;
use admin\components\Controller;
use yii\helpers\ArrayHelper;
use yii\filters\auth\HttpHeaderAuth;

use admin\models\Module;
class MymoduleController extends Controller
{
    public $modelClass='admin\models\Module';
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
     * 搜索函数
     */
    public function actionSearch(){
        return Module::find()->where(['like','name',\Yii::$app->getRequest()->getBodyParams()])->all();
    }
}