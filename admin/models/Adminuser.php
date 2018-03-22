<?php

namespace admin\models;

use Yii;
use common\myerror\ErrorMsg;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use common\mypublic\Myfunction;

/**
 * This is the model class for table "t_adminuser".
 *
 * @property string $id
 * @property string $user_name 账号
 * @property string $name 姓名
 * @property string $password 密码
 * @property string $mobile 手机号
 * @property string $mail 邮箱
 * @property string $login_date 最后登录时间
 * @property string $login_ip 最后登陆ip
 * @property string $login_equipment 最后登录设备
 * @property string $dictionary_item_id 密保问题id
 * @property string $answer 密保问题答案
 * @property int $is_del 逻辑删除
 * @property string $create_date 创建时间
 * @property string $update_date 更新时间
 * @property string $creator_id 创建人id
 * @property string $updator_id 更新人id
 */
class Adminuser extends ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_adminuser';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_name', 'name', 'password', 'dictionary_item_id', 'answer'], 'required'],
            [['login_date', 'create_date', 'update_date'], 'safe'],
            [['is_del'], 'integer'],
            [['id', 'dictionary_item_id', 'creator_id', 'updator_id'], 'string', 'max' => 32],
            [['user_name', 'login_ip', 'login_equipment'], 'string', 'max' => 25],
            [['name'], 'string', 'max' => 20],
            [['password'], 'string', 'max' => 100],
            [['mobile'], 'string', 'max' => 15],
            [['mail'], 'string', 'max' => 50],
            [['answer'], 'string', 'max' => 255],
            [['id','user_name','mail','mobile'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
   /* public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_name' => 'User Name',
            'name' => 'Name',
            'password' => 'Password',
            'mobile' => 'Mobile',
            'mail' => 'Mail',
            'login_date' => 'Login Date',
            'login_ip' => 'Login Ip',
            'login_equipment' => 'Login Equipment',
            'dictionary_item_id' => 'Dictionary Item ID',
            'answer' => 'Answer',
            'is_del' => 'Is Del',
            'create_date' => 'Create Date',
            'update_date' => 'Update Date',
            'creator_id' => 'Creator ID',
            'updator_id' => 'Updator ID',
        ];
    }*/
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $token = Yii::$app->jwt->getParser()->parse((string) $token);
//        var_dump($token);
        $user_id=$token->getClaim('uid');
        $redis = Yii::$app->redis;
        if($redis->get($user_id)){
            if($redis->get($user_id)==$token){
                return static::find()
                    ->where(['id'=>$user_id])
                    ->one();
            }else{
                ErrorMsg::Info(Yii::t('yii','异地登录！'));
            }
        }else{
            ErrorMsg::Info(Yii::t('yii','授权过期！'));
        }
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['user_name' => $username,'is_del'=>0]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    /**
     * 生成access_token
     */
    public function generateAccessToken(){
//        $this->access_token=Yii::$app->security->generateRandomString();
        $token = Yii::$app->jwt->getBuilder()
//        ->setIssuer('http://example.com') // Configures the issuer (iss claim)
//        ->setAudience('http://example.org') // Configures the audience (aud claim)
//        ->setId('4f1g23a12aa', true) // Configures the id (jti claim), replicating as a header item
//        ->setIssuedAt(time()) // Configures the time that the token was issue (iat claim)
//        ->setNotBefore(time() + 60) // Configures the time before which the token cannot be accepted (nbf claim)
            ->setExpiration(time() + 3600) // Configures the expiration time of the token (exp claim)
            ->set('uid', $this->id) // Configures a new claim, called "uid"
            ->getToken(); // Retrieves the generated token
        $access_token=substr($token.'Lcobucci\JWT\Token',0,strlen($token.'Lcobucci\JWT\Token')-18);
        return ['access_token'=>$access_token,'id'=>$this->id,'token'=>$token];
    }

    /**
     * 设置创建人/修改人的id
     */
    public function beforeSave($insert){
        if(parent::beforeSave($insert)){
            if($insert){
                $this->id=Myfunction::getUUID();
                $this->setPassword($this->password);
                $this->creator_id=Yii::$app->user->id;
                $this->updator_id=Yii::$app->user->id;
            }else{
                if(Yii::$app->user->id){
                    if($this->password){
                        $this->setPassword($this->password);
                    }
                    $this->updator_id=Yii::$app->user->id;
                    $this->update_date=date('Y-m-d H:i:s');
                }
            }
            return true;
        }else{
            return false;

        }
    }
    /**
     * 修改过添加后添加日志
     */
    public function afterSave($insert,$array){
        if($insert){
            Log::createLog('2','增加了管理员');
        }else{
            if(Yii::$app->user->id){
                Log::createLog('3','修改了管理员');
            }
        }
        return parent::afterSave($insert,$array);
    }

    /**
     * 删除后添加日志
     */
    public function afterDelete(){
        Log::createLog('2','删除除了管理员');
        return parent::afterDelete();
    }
    /**
     * 删除前删除相关角色关系
     */
    public function beforeDelete(){
        RoleUser::deleteAll('user_id = :user_id', [':user_id' => $this->id]);
        return parent::beforeDelete();
    }
}
