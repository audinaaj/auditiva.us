<?php

namespace app\commands;

use Yii;
use yii\console\Controller;

class TestController extends Controller
{

    public function actionEmail($email = 'ajdavis@audina.net')
    {
        $email = Yii::$app->mailer->compose()
        //$email = Yii::$app->mailer->compose('signupActivationRequest', ['user' => '$user$', 'token' => '$token$'])  // html template
            ->setFrom('smtp@auditiva.us')
            ->setReplyTo('smtp@auditiva.us')
            ->setTo($email)
            ->setSubject('Auditiva.us mail test ' . date('Y-m-d H:i:s'))
            ->setTextBody('This is a test email sent from the command line using Yii2 Symfonymailer with SMTP user/password transport.');
            //->setTextBody('This is a test email sent from the command line using Yii2 Symfonymailer with Microsoft Graph API transport.');

        // output email to console for testing
        $email_as_string = $email->toString();
        echo($email_as_string);

        $email->send();
    }
}