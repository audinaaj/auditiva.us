<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\StringHelper;
use himiklab\yii2\recaptcha\ReCaptchaValidator;

use app\models\User;
/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $password;
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $verifyCode;  // reCaptcha
    //public $address1;
    //public $address2;
    //public $city;
    //public $state_prov;
    //public $postal_code;
    //public $country;
    //public $company_name;
    //public $job_title;
    //public $account_number;
    //public $receive_newsletter;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => Yii::t('app', 'This username has already been taken.')],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => Yii::t('app', 'This email address has already been taken.')],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            
            [[
                'first_name', 'last_name', 'phone', 
                //'address1', 'address2', 'city', 'state_prov', 'postal_code', 'country', 
                //'company_name', 'job_title', 'account_number',
            ], 'string', 'max' => 255],
            [[
                'first_name', 'last_name', 'phone', 
                //'address1', 'city', 'state_prov', 'postal_code', 'country', 
                //'job_title',
            ], 'required'],
            
            //['receive_newsletter', 'safe']
            ['verifyCode', ReCaptchaValidator::class, 'uncheckedMessage' => 'The verification code is incorrect.'],  // reCaptcha
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email    = $this->email;
            $user->password = $this->password;
            $user->status = (Yii::$app->params['isSignupApprovalRequired'] ? User::STATUS_INACTIVE : User::STATUS_ACTIVE);

            $user->first_name = (!empty($this->first_name) ? \app\models\StringUtils::nameize($this->first_name) : '');
            $user->last_name = (!empty($this->last_name) ? \app\models\StringUtils::nameize($this->last_name) : '');
            $user->phone = (!empty($this->phone) ? $this->phone : '');

            if ($user->save()) {
                return $user;
            } else {
                Yii::$app->session->setFlash('error', print_r($user->getErrors(), true) );
                return null;
            }
        }

        return null;
    }
}
