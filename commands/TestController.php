<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;

class TestController extends Controller
{
    public $defaultAction = 'email';

    public function actionEmail($fromEmail = 'smtp@auditiva.us')
    {
        $email = Yii::$app->mailer->compose()
            ->setSender(Yii::$app->params['mail.username'])
            ->setFrom([$fromEmail => Yii::$app->params['companyName']])
            ->setTo('ajdavis@auditiva.us')
            ->setSubject('Auditiva.us mail test ' . date('Y-m-d H:i:s'))
            ->setTextBody('This is a test sent from the command line using the configured mailer.');

        // output email to console for testing
        Console::output($email->toString() . "\n");

        $email->send();
    }
}