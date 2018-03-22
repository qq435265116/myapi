<?php
/**
 * Created by PhpStorm.
 * User: KNKJ-3
 * Date: 2018/3/8
 * Time: 13:57
 */

namespace common\myerror;

use yii;
class ErrorMsg
{
    public static function Info($_errors) {
        $Factory =  new  FactoryMsg;

        $result  = strstr($_errors,Yii::t('yii','Not exist'));   //数据不存在  20001
        $result1 = strstr($_errors,Yii::t('yii','Null'));        //参数不能为空  20002
        $result2 = strstr($_errors,Yii::t('yii','Fail'));        //新增、更新、删除失败 20003
        $result3 = strstr($_errors,Yii::t('yii','Not right'));   //XX不正确 20004
        $result4 = strstr($_errors,Yii::t('yii','Robc'));        //XX无权限 20005
//        var_dump($_errors);
        //数据不存在  404
        if(!empty($result)){
            $M = $Factory->Msg();
            $M->Error($_errors,'404');die;
        }

        //参数不能为空  401
        if(!empty($result1)){
            $M = $Factory->Msg();
            $M->Error($_errors,'401');die;
        }

        //新增、更新、删除失败 20003
        if(!empty($result2)){
            $M = $Factory->Msg();
            $M->Error($_errors,'403');die;
        }

        //XX不正确 20004
        if(!empty($result3)){
            $M = $Factory->Msg();
            $M->Error($_errors,'402');die;
        }

        //XX无权限 20005
        if(!empty($result4)){
            $M = $Factory->Msg();
            $M->Error($_errors,'405');die;
        }

        //默认类型 21000
        $M = $Factory->Msg();
        $M->Error($_errors,'1');
        exit(0);
    }
}