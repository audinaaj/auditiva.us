<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\StringHelper;
use luyadev\recaptcha\ReCaptchaValidator2;

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
    public $verifyCode;  // captcha
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
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => Yii::t('app', 'This username has already been taken.')],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => Yii::t('app', 'This email address has already been taken.')],

            ['password', 'string', 'min' => 6],
            
            [['first_name', 'last_name', 'phone'], 'string', 'max' => 255],
            [['first_name', 'last_name', 'phone', 'username', 'email', 'password'], 'required'],

            ['verifyCode', ReCaptchaValidator2::class, 'uncheckedMessage' => 'The verification code is incorrect.'],
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
