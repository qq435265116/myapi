<?php
/**
 * Created by PhpStorm.
 * User: KNKJ-3
 * Date: 2018/3/1
 * Time: 11:37
 */

namespace admin\controllers;

use yii\filters\auth\HttpHeaderAuth;
use common\models\Article;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\filters\auth\QueryParamAuth;
use admin\controllers\ComController;
class ArticleController extends ComController
{
    public $modelClass="common\models\Article";
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
//                'pagination'=>false,
                //设置每页页面容量
                'pagination'=>['pageSize'=>5]
            ]
        );
    }
    /**
     * 搜索函数
     */
    public function actionSearch(){
        return Article::find()->where(['like','title',\Yii::$app->getRequest()->getBodyParams()])->all();
    }
}