<?php
namespace admin\models;

use Yii;
use yii\base\Model;
use admin\models\Adminuser;
use common\myerror\ErrorMsg;
/**
 * Login form
 */
class AdminLoginForm extends Model
{
    public $user_name;
    public $password;
//    public $rememberMe = true;

    private $_user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_name', 'password'], 'required'],
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
                ErrorMsg::Info(Yii::t('yii','账号或密码错误！'));
            }else{

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
            return [
                'access_token'=>$access_token,
                'id'=>$user['id']
            ];
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
            $this->_user = Adminuser::findByUsername($this->user_name);
        }

        return $this->_user;
    }
}
