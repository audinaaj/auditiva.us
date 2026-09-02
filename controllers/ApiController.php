<?php

namespace app\controllers;

use Yii;
use yii\rest\Controller;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\CompositeAuth;
use yii\filters\AccessControl;

use app\models\UtilsData;

class ApiController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'authenticator' => [
                'class' => CompositeAuth::class,
                'authMethods' => [
                    HttpBearerAuth::class,
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['backup-database'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin());
                        }
                    ],
                ],
            ],
        ];
    }

    /**
     * Dumps the MySQL database via API endpoint.
     * Requires Bearer token authentication (access_token).
     * AccessControl ensures only admin users are permitted.
     *
     * @param string $tables Comma separated list of tables you want to download, or '*' if you want to download them all.
     */
    public function actionBackupDatabase($tables = '*')
    {
        $backup = UtilsData::generateDatabaseBackup($tables);
        $filename = $backup['databaseName'] . '-backup-' . date('Y-m-d_H-i-s') . '.sql';
        Yii::$app->response->sendContentAsFile($backup['sql'], $filename, ['mimeType' => 'text/x-sql']);
    }
}
