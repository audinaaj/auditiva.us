<?php
namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property int $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $auth_key
 * @property string $access_token
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $phone
 * @property string $avatar
 * @property datetime $role
 * @property integer $status
 * @property datetime $created_at
 * @property datetime $updated_at
 * @property datetime $last_login
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    // Users
    const USER_ADMIN = 1;

    // Status
    const STATUS_BANNED   = -2;
    const STATUS_DELETED  = -1;
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE   = 1;

    // Roles
    const ROLE_ADMIN      = 1;   // Super user
    const ROLE_MANAGER    = 2;   // Create/update content, edit user profiles
    const ROLE_EDITOR     = 3;   // Create/update content
    const ROLE_AUTHOR     = 4;   // Create content, update own content only
    const ROLE_POWERUSER  = 5;   // Access to company content (not for public)
    const ROLE_MODULE     = 9;   // Basic site use + technical manual.
    const ROLE_REGISTERED = 10;  // Basic site use.

    public static $roles = [
        self::ROLE_ADMIN      => 'admin',
        self::ROLE_MANAGER    => 'manager',
        self::ROLE_EDITOR     => 'editor',
        self::ROLE_AUTHOR     => 'author',
        self::ROLE_POWERUSER  => 'poweruser',
        self::ROLE_MODULE     => 'module',
        self::ROLE_REGISTERED => 'registered',
    ];

    public $password = '';  // write-only (only used during record creation or update)

    /**
    * @inheritdoc
    */
    public static function tableName()
    {
        return '{{%user}}';
    }
   
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        date_default_timezone_set( (!empty(Yii::$app->params['timezone']) ? Yii::$app->params['timezone'] : 'America/New_York') );
        
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at', // OR 'create_time', to override default field name
                'updatedAtAttribute' => 'updated_at', // OR 'update_time', to override default field name
                'value' => new \yii\db\Expression('NOW()'),
            ],
            //[
            //    'class' => BlameableBehavior::class,
            //    'createdByAttribute' => 'created_by',  // OR 'author_id', to override default field name
            //    'updatedByAttribute' => 'updated_by',  // OR 'updater_id', to override default field name
            //],
        ];
    }
   
    public function rules()
    {
       return [
           ['status', 'default', 'value' => self::STATUS_INACTIVE],
           ['status', 'in', 'range' => [
               self::STATUS_ACTIVE, 
               self::STATUS_INACTIVE, 
               self::STATUS_DELETED, 
               self::STATUS_BANNED,
           ]],
           ['role', 'default', 'value' => self::ROLE_REGISTERED],
           ['role', 'in', 'range' => [
               self::ROLE_ADMIN, 
               self::ROLE_MANAGER,
               self::ROLE_EDITOR,
               self::ROLE_AUTHOR,
               self::ROLE_POWERUSER,
               self::ROLE_MODULE,
               self::ROLE_REGISTERED,
           ]],
           ['email', 'email'],  // the email attribute should be a valid email address
           [[
                //'id', 'first_name', 'last_name', 'username', 'phone', 'email', 'password_hash', 'password_reset_token', 'auth_key', 'access_token', 'avatar',
                //'address1', 'address2', 'city', 'state_prov', 'postal_code', 'country', 
                //'company_name', 'job_title', 'account_number',
                'first_name', 'last_name', 'full_name', 'username', 'email', 
            ], 'required'],
           [['id', 'role', 'status'], 'integer'],
           [[
                'first_name', 'last_name', 'username', 'phone', 'email', 
                'password_hash', 'password_reset_token', 'auth_key', 'access_token', 'avatar',
                //'address1', 'address2', 'city', 'state_prov', 'postal_code', 'country', 
                //'company_name', 'job_title', 'account_number', 
            ], 'string', 'max' => 255],
           [['created_at', 'updated_at', 'last_login'], 'safe'],
           ['password', 'string', 'min' => 6],
       ];
    }
   
    public function attributeLabels()
    {
       return [
           'id'                   => Yii::t('app', 'ID'),
           'first_name'           => Yii::t('app', 'First Name'),
           'last_name'            => Yii::t('app', 'Last Name'),
           'username'             => Yii::t('app', 'Username'),
           'phone'                => Yii::t('app', 'Phone'),
           'email'                => Yii::t('app', 'Email'),
           'password_hash'        => Yii::t('app', 'Password Hash'),
           'password_reset_token' => Yii::t('app', 'Password Reset Token'),
           'auth_key'             => Yii::t('app', 'Authentication Key'),
           'access_token'         => Yii::T('app', 'Access Token'),
           'avatar'               => Yii::t('app', 'Avatar'),
           'role'                 => Yii::t('app', 'Role'),
           'status'               => Yii::t('app', 'Status'),
           'created_at'           => Yii::t('app', 'Created At'),
           'updated_at'           => Yii::t('app', 'Updated At'),
           'last_login'           => Yii::t('app', 'Last Login'),
       ];
    }
   
    public static function findIdentity($id)
    {
        //return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
       
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }
   
    /**
    * @inheritdoc
    */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $user = self::find()->where(["access_token" => $token])->one();
        if (!$user) {
            return null;
        }
        return new static($user);
    }
    
    /**
    * Finds user by username
    *
    * @param string $username
    * @return static|null
    */
    public static function findByUsername($username)
    {
        //return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);  // fails tests when user not active
        return static::findOne(['username' => $username]);
    }
   
    public function findByUser($username) 
    {
        //return self::findOne()->where(["username" => $username, 'status' => self::STATUS_ACTIVE]);  // fails tests when user not active
        return self::findOne()->where(["username" => $username]);
    }
    
    /**
     * Find username for specified userid.
     *
     * @id integer  $id of user to search.
     * @return string Username if found, 'N/A' if not found.
     */
    public static function findUsername($id)
    {
        //$user = isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
        $user = self::find()->where(["id" => $id])->one();
        if (count($user) > 0)  {
            return $user->username;
        } else {
            return 'N/A';
        }
    }
    
    /**
     * get list of all usernames, to be used in dropdown.
     * @return array usernames.
     */
    public static function getUsernames()
    {
        //return \yii\helpers\ArrayHelper::map(User::$users, 'id', 'username');
        return \yii\helpers\ArrayHelper::map(User::find()->all(), 'id', 'username');
    }
    
    /**
    * @inheritdoc
    */
    public function getId()
    {
        //return $this->id;
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
   public function validateAuthKey($auth_key)
   {
       return $this->auth_key === $auth_key;
   }
   
   /**
    * Validates password
    *
    * @param string $password password to validate
    * @return bool if password provided is valid for current user
    */
   public function validatePassword($password)
   {
        //return $this->password === $password;                    // plain text password
        //return $this->password ===  md5($password);              // md5 password
        //return password_verify($password, $this->passwordHash);  // password hash (recommended)
        return Yii::$app->security->validatePassword($password, $this->password_hash);  // password hash (recommended)
   }
   
   /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        //$this->password_hash = password_hash($password, PASSWORD_DEFAULT);  // hash
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
    
    public function getPassword()
    {
        return $this->password;
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
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = (!empty(Yii::$app->params['user.passwordResetTokenExpire']) ? Yii::$app->params['user.passwordResetTokenExpire'] : 3600);
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }
    
    /**
     * Activate record
     */
    public function activate()
    {
        // Only activate if inactive.  Other status (i.e. Delete or Banned) remain intact.
        if ($this->status == self::STATUS_INACTIVE) {
            $this->status = self::STATUS_ACTIVE;
        }
        return $this->status;
    }
    
    public function generateActivationToken()
    {
        // Generate activation token.  Use generatePasswordHash() only to 
        // generate a hash, not an actual password.
        return Yii::$app->security->generatePasswordHash($this->id . $this->email);
    }
    
    public function isValidActivationToken($token)
    {
        $isValid = false;
        
        try {
            // Validate activation token.  Use validatePassword() only to 
            // generate a hash and compare it to token, not actual password.
            $isValid =(Yii::$app->security->validatePassword($this->id . $this->email, $token));
        } catch (\Exception $ex) {
            
        }
        return $isValid;
    }
    
    /**
     * Deactivate record
     */
    public function deactivate()
    {
        // Only inactivate if active.  Other status (i.e. Delete or Banned) remain intact.
        if ($this->status == self::STATUS_ACTIVE) {
            $this->status = self::STATUS_INACTIVE;
        }
        return $this->status;
    }
    
    /**
     * Ban record
     */
    public function ban()
    {
        $this->status = self::STATUS_BANNED;
        return $this->status;
    }
   
    /**
     * @return bool if user is admin
     */
    public function isAdmin()
    {
        return ($this->role == self::ROLE_ADMIN);  // Role is Admin
    }
    
    /**
     * @return bool if current user is admin
     */
    public static function isCurrentUserAdmin()
    {
        //return (isset(Yii::$app->user->identity) && (Yii::$app->user->identity->role == self::ROLE_ADMIN));  // Logged in and role is Admin
        return (!Yii::$app->user->isGuest && (Yii::$app->user->identity->role == self::ROLE_ADMIN));  // Logged in and role is Admin
    }
   
    /**
     * @inheritdoc
     */
    public function getRole()
    {
        return $this->role;
    }
    
    /**
     * @return string Get role as label.
     */
    public static function getRoleLabel($aRole)
    {
        //$roles = self::getRoles();
        //return $roles[$aRole];
        return self::$roles[$aRole];
    }
    
    /**
     * @return array Roles list.
     */
    public static function getRoles()
    {
        return self::$roles;
    }
    
    /**
     * @return string Get status as label.
     */
    public static function getStatusLabel($aStatus, $is_html=true)
    {
        $statuses = self::getStatuses();
        if ($is_html) {
            switch($aStatus) {
                case self::STATUS_ACTIVE:   return '<span class="label label-success">' . $statuses[$aStatus] . '</span>';
                case self::STATUS_INACTIVE: return '<span class="label label-warning">' . $statuses[$aStatus] . '</span>';
                default:                    return '<span class="label label-danger">'  . $statuses[$aStatus] . '</span>';
            }
        } else {
            return $statuses[$aStatus];
        }
    }
    
    /**
     * @return array Status list.
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_BANNED   => 'banned',
            self::STATUS_DELETED  => 'deleted',
            self::STATUS_INACTIVE => 'inactive',
            self::STATUS_ACTIVE   => 'active',
        ];
    }
   
    /**
     * @return success
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Do some work before saving.
            
            // Encrypt password
            if (!empty($this->password)) {
                $this->setPassword($this->password);
                $this->generateAuthKey();
            }
     
            return true;  // validated
        }
        return false;  // not validated
    }
    
    /**
     * @return array Status list.
     */
    public function getFull_Name()
    {
    return "{$this->first_name} {$this->last_name}";
    }
}
