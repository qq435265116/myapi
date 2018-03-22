<?php
/**
 * Created by PhpStorm.
 * User: KNKJ-3
 * Date: 2018/3/21
 * Time: 13:51
 */

namespace api\controllers;

use api\models\Upload;
use yii\data\ActiveDataProvider;
use api\components\Controller;
use yii\web\UploadedFile;
class CommodityTypeController extends Controller
{
    public $modelClass="api\models\CommodityType";
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
    public function actionTest(){
//        $model = new Upload();
//
//        if (\Yii::$app->request->isPost) {
//            $model->file = UploadedFile::getInstance($model, 'file');
//
//            if ($model->file && $model->validate()) {
//                $model->file->saveAs('uploads/' . $model->file->baseName . '.' . $model->file->extension);
//            }
//        }

        return $_FILES;
    }
}