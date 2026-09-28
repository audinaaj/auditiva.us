<?php

namespace app\controllers;

use yii\web\Controller;
use Yii;

class HealthController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        // Quick health check (database test)
        try {
            Yii::$app->db->open();
            Yii::$app->response->statusCode = 200;
            return 'OK';
        } catch (\Exception $e) {
            Yii::$app->response->statusCode = 503;
            return 'Service Unavailable';
        }
    }
}