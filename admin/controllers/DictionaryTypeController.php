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
class DictionaryTypeController extends Controller
{
    public $modelClass='admin\models\DictionaryType';
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
}