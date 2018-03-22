<?php
namespace api\models;

use Yii;
use yii\base\Model;
use common\models\User;
use yii\web\UnauthorizedHttpException;
use common\myerror\ErrorMsg;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
//    public $rememberMe = true;

    private $_user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
//            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
//                $this->addError($attribute, '账号或密码错误！');
                ErrorMsg::Info(Yii::t('yii','账号或密码错误！'));
//                throw new UnauthorizedHttpException('账号或密码错误！','401');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {

            $user=$this->_user->generateAccessToken();
            $access_token=$user['access_token'];
            $redis = Yii::$app->redis;
            $redis->set($user['id'],$user['token']);
            $redis->expire($user['id'],36000);
//            return Yii::$app->getRequest()->getUserIP();
            return $access_token;
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
