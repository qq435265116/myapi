<?php

namespace api\models;

use Yii;
use common\myerror\ErrorMsg;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use common\mypublic\Myfunction;

/**
 * This is the model class for table "t_user".
 *
 * @property string $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string $access_token 用户access_token
 * @property int $expire_at 过期时间
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email',], 'required'],
            [['status', 'created_at', 'updated_at', 'expire_at'], 'integer'],
            [['id', 'auth_key'], 'string', 'max' => 32],
            [['username', 'password_hash', 'password_reset_token', 'email', 'access_token'], 'string', 'max' => 255],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    /*public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'access_token' => 'Access Token',
            'expire_at' => 'Expire At',
        ];
    }*/
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
