<?php

namespace app\commands;

use Yii;
use yii\console\Controller;

class TestController extends Controller
{

    public function actionEmail($email = 'ajdavis@audina.net')
    {
        $email = Yii::$app->mailer->compose()
            ->setFrom(Yii::$app->params['mail.username'])
            ->setReplyTo('info@auditiva.us')
            ->setTo($email)
            ->setSubject('Auditiva.us mail test ' . date('Y-m-d H:i:s'))
            ->setTextBody('This is a test email sent from the command line using the configured mailer.');

        // output email to console for testing
        $email_as_string = $email->toString();
        echo($email_as_string);

        $email->send();
    }
}