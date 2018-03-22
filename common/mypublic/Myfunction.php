<?php
/**
 * Created by PhpStorm.
 * User: KNKJ-3
 * Date: 2018/3/8
 * Time: 10:35
 */

namespace common\mypublic;

use linslin\yii2\curl;
use yii;
class Myfunction
{
    /**
     * 获取uuid函数
     */
    public static function getUUID(){
        if (function_exists('com_create_guid')){
            return com_create_guid();
        }else{
            mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
            $charid =md5(uniqid(rand(), true));
            $uuid =substr($charid, 0, 8)
                .substr($charid, 8, 4)
                .substr($charid,12, 4)
                .substr($charid,16, 4)
                .substr($charid,20,12);
            return $uuid;
        }
    }
    /**
     * 发送验证码
     */
    public static function sendSMS( $mobile) {
        //生成随机数
        $msg=Myfunction::createNoncestrNum(6);
        //地址
        $chuanglan_config['api_send_url'] = 'https://sapi.253.com/msg/HttpBatchSendSM';
        //账号
        $chuanglan_config['api_account']	= 'BG1MSZL_TEST';
        //密码
        $chuanglan_config['api_password']	= 'Hnkj6222360';
        $data=array(
            "account"=>$chuanglan_config['api_account'],
            "pswd"=>$chuanglan_config['api_password'],
            "mobile"=>$mobile,
            "msg"=>$msg
        );
        $postArr = '{"account":"'.$chuanglan_config['api_account'].'",
                      "pswd":"'.$chuanglan_config['api_password'].'",
                      "mobile":"'.$mobile.'"
                      "content":"'.$msg.'",
                     }';
        $curl = new curl\Curl();
        $response = $curl->setPostParams($postArr)
            ->setOption(CURLOPT_SSL_VERIFYPEER,false)
            ->post($chuanglan_config['api_send_url']);
//        $result = $this->curlPost( $chuanglan_config['api_send_url'] , $postArr);
        return $response;
    }
    /**
     * 发送邮件
     */
    public static function sendMail($mail,$name,$title,$body) {
        //生成随机数
        $msg=Myfunction::createNoncestrNum(6);
        $mail = Yii::$app->mailer->compose()
            ->setFrom(['sunjinxinwd@163.com' => $name])
            ->setTo($mail)
            ->setSubject($title)
            //->setTextBody('Yii中文网教程真好 www.yii-china.com')   //发布纯文字文本
            ->setHtmlBody($body)    //发布可以带html标签的文本
            ->send();
        if($mail){
            $response= 'success';
        }else{
            $response= 'fail';
        }
        return $response;
    }
    /**
     * 作用：产生随机字符串
     */
    public static function createNoncestr( $length = 32 )
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str ="";
        for ( $i = 0; $i < $length; $i++ )  {
            $str.= substr($chars, mt_rand(0, strlen($chars)-1), 1);
        }
        return $str;
    }
    public static function createNoncestrNum( $length = 32 )
    {
        $chars = "0123456789";
        $str ="";
        for ( $i = 0; $i < $length; $i++ )  {
            $str.= substr($chars, mt_rand(0, strlen($chars)-1), 1);
        }
        return $str;
    }

    /**
     * 获取当前操作系统
     */
    public static function getOS()
    {
        $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
        if(strpos($agent, 'windows nt')) {
            $platform = 'windows';
        } elseif(strpos($agent, 'macintosh')) {
            $platform = 'mac';
        } elseif(strpos($agent, 'ipod')) {
            $platform = 'ipod';
        } elseif(strpos($agent, 'ipad')) {
            $platform = 'ipad';
        } elseif(strpos($agent, 'iphone')) {
            $platform = 'iphone';
        } elseif (strpos($agent, 'android')) {
            $platform = 'android';
        } elseif(strpos($agent, 'unix')) {
            $platform = 'unix';
        } elseif(strpos($agent, 'linux')) {
            $platform = 'linux';
        } else {
            $platform = 'other';
        }
        return $platform;
    }
}