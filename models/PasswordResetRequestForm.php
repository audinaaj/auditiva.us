<?php
namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\app\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                //'message' => Yii::t('app', 'There is no user with such email.')  // Too much info
                'message' => Yii::t('app', 'Sorry, we are unable to reset password for email provided.')
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if ($user) {
            if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
                $user->generatePasswordResetToken();
            }

            if ($user->save()) {
                \Yii::trace('User saved with new password reset token', __METHOD__);
                return \Yii::$app->mailer->compose('passwordResetToken', ['user' => $user])
                    //->setFrom([\Yii::$app->params['adminEmail'] => \Yii::$app->name . ' robot'])
                    ->setFrom([\Yii::$app->params['adminEmail'] => \Yii::$app->params['companyName']])
                    ->setTo($this->email)
                    ->setBcc([\Yii::$app->params['debugEmail'] => 'Debug Email'])
                    //->setSubject('Password reset for ' . \Yii::$app->name)
                    ->setSubject(Yii::t('app', 'Password reset for {companyName} website', ['companyName' => \Yii::$app->params['companyNameShort']]))
                    ->send();
            }
        } else {
            \Yii::trace('User not found. Unable to generate password.', __METHOD__);
        }
        \Yii::trace('User data: ' . print_r($user, true), __METHOD__);

        return false;
    }
}
