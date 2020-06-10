<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * PasswordForm is the model behind the password form.
 */
class PasswordForm extends Model
{
    //public $username;
    public $password;
    public $encrypted_password;
    //public $rememberMe = true;

    //private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['encrypted_password'], 'safe'],
            // password required
            [['password'], 'required'],
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
        if ($this->hasErrors()) {
            $this->addError($attribute, Yii::t('app', 'Invalid or unsupported password.'));
        }
    }
    
    /**
     * Encrypt current password.
     * @return string Password hash if successful, false if not.
     */
    public function encrypt()
    {
        if ($this->validate()) {
            return password_hash($this->password, PASSWORD_DEFAULT);  // hash
            //return $this->password;                                 // plain
        }
        return false;
    }
}
