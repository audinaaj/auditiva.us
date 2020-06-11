<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\helpers\Console;
use yii\console\Controller;

/**
 * Allow ssh forwarding.
 */
class RemoteDbController extends Controller
{
    public $defaultAction = 'connect';

    /**
     * Forward local db commands to a remote DB server via ssh using plink.
     * @param string $username The user on the remote ssh server.
     * @param string $server The remote ssh server (ip or hostname).
     */
    public function actionConnect($username = '', $server = '')
    {
        echo Console::renderColoredString("%y *** SSH agent must be running for this to work. ***%n\n");

        if (empty($server)) {
            $server = Console::prompt('Enter the database server you wish to connect to.');
        }

        if (empty($username)) {
            $username = Console::prompt('What is your username?');
        }

        echo Console::renderColoredString("%y Don't forget to hit enter after this command runs.%n\n");

        $target = "$username@$server";
        exec("plink -ssh $target -P 22 -N -L 3306:127.0.0.1:3306");
    }
}
