<?php

namespace admin\models;

use Yii;
use common\mypublic\Myfunction;

/**
 * This is the model class for table "t_log".
 *
 * @property string $id
 * @property int $status 状态 1登陆 2增加 3修改 4删除
 * @property string $user_id 用户id
 * @property string $content 内容
 * @property string $ip 操作ip
 * @property string $date 操作时间
 * @property int $is_del 逻辑删除
 */
class Log extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'user_id', 'content', 'ip'], 'required'],
            [['status', 'is_del'], 'integer'],
            [['content'], 'string'],
            [['date'], 'safe'],
            [['id', 'user_id'], 'string', 'max' => 32],
            [['ip'], 'string', 'max' => 25],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Status',
            'user_id' => 'User ID',
            'content' => 'Content',
            'ip' => 'Ip',
            'date' => 'Date',
            'is_del' => 'Is Del',
        ];
    }
    /**
     * 添加log
     */
    public static function createLog($module,$name){
//        var_dump($module);
        if($module==0){
            $data=array(
                'id'=>Myfunction::getUUID(),
                'user_id'=>Yii::$app->user->id,
                'status'=>$module,
                'ip'=>Yii::$app->getRequest()->getUserIP(),
                'content'=>'用户:'.$name
            );
        }else{
            $data=array(
                'id'=>Myfunction::getUUID(),
                'user_id'=>Yii::$app->user->id,
                'status'=>$module,
                'ip'=>Yii::$app->getRequest()->getUserIP(),
                'content'=>'用户:'.Yii::$app->user->identity->name."(".Yii::$app->user->identity->user_name.")，".$name
            );
        }
        $log=new Log();
        $log->load($data,'');
        $log->save();
    }
    /**
     * 添加log
     */
    public static function createLoginLog($id,$name){
//        var_dump($module);
        $data=array(
            'id'=>Myfunction::getUUID(),
            'user_id'=>$id,
            'status'=>0,
            'ip'=>Yii::$app->getRequest()->getUserIP(),
            'content'=>'用户:'.$name
        );
        $log=new Log();
        $log->load($data,'');
        $log->save();
    }
}
