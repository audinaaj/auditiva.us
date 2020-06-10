<?php
namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;
use yii\helpers\StringHelper;
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
            //$user->setPassword($this->password);
            //$user->generateAuthKey();
            
            $user->first_name         = (!empty($this->first_name)         ? \app\models\StringUtils::nameize($this->first_name) : '');
            $user->last_name          = (!empty($this->last_name)          ? \app\models\StringUtils::nameize($this->last_name)  : '');
            $user->phone              = (!empty($this->phone)              ? $this->phone                     : '');
            //$user->address1           = (!empty($this->address1)           ? ucwords($this->address1)    : '');
            //$user->address2           = (!empty($this->address2)           ? ucwords($this->address2)    : '');
            //$user->city               = (!empty($this->city)               ? ucwords($this->city)        : '');
            //$user->state_prov         = (!empty($this->state_prov)         ? $this->state_prov           : '');
            //$user->postal_code        = (!empty($this->postal_code)        ? $this->postal_code          : '');
            //$user->country            = (!empty($this->country)            ? $this->country              : '');
            //$user->company_name       = (!empty($this->company_name)       ? $this->ucname($this->company_name) : '');
            //$user->job_title          = (!empty($this->job_title)          ? ucwords($this->job_title)   : '');
            //$user->account_number     = (!empty($this->account_number)     ? strtoupper(\app\models\StringUtils::stripSpaces($this->account_number)) : '');
            //$user->receive_newsletter = (!empty($this->receive_newsletter) ? $this->receive_newsletter   : 1);

            if ($user->save()) {
                // Set default role for new user.
                // This block is required when using authManager (see /app/config/main.php):
                try {
                    $auth = Yii::$app->authManager;
                    $roleRegistered = $auth->getRole('registered');  // default role
                    $auth->revokeAll($user->getId());                // revoke all roles for this user
                    $auth->assign($roleRegistered, $user->getId());  // assign new role
                } catch (\Exception $ex) {
                    if (!empty(substr($ex->getMessage(), 0, strlen('Authorization item')))) {
                        // Ignore exception if this is "Authorization item 'rolename' has already been assigned to user 'userid'"
                        // Eg: "Authorization item 'registered' has already been assigned to user '3'"
                    } else {
                        throw $ex;  // rethrow exception
                    }
                }
                
                return $user;
            } else {
                //print_r($user->getErrors(), true);
                Yii::$app->session->setFlash('error', print_r($user->getErrors(), true) );
                return null;
            }
        }

        return null;
    }
}
