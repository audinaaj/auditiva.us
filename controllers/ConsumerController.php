<?php
namespace app\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use app\models\Content;
use app\models\FindProfessionalForm;

/**
 * Professional controller
 */
class ConsumerController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'testLimit' => 1,
                'foreColor' => 0xA02040,
            ],
        ];
    }

    public function actionIndex()
    {
        $this->redirect(['content/index', 'category' => 'consumers']);
    }
    
    public function actionTestimonials()
    {
        $models = \app\models\Testimonial::find()->where(['like', 'tags', 'consumer'])->all();

        return $this->render('/testimonial/index', [
            'models' => $models,
            'parent_breadcrumb_label' => 'Consumers',
            'parent_breadcrumb_route' => 'consumer/index',
        ]);
    }
    
    public function actionHearingAssociations()
    {
        return $this->render('hearing-associations');
    }
    
    public function actionProductBrochures($ShowAllProducts=1)
    {
        return $this->render('product-brochures');
    }
    
    public function actionFindProfessional()
    {
        //return $this->render('find-professional');
        
        $model = new FindProfessionalForm();
        if ($model->load(Yii::$app->request->post())) {
            // Preset some data
            $model->name = Yii::$app->request->post('firstName') . ' ' . Yii::$app->request->post('lastName');
            if (empty($model->productInterests)) {
                $model->productInterests = [];
            }

            // Validate
            if ($model->validate()) {
                if ($model->sendEmail($model->email)) {
                    Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
                } else {
                    Yii::$app->session->setFlash('error', 'There was an error sending email.');
                }

                return $this->refresh();
            } else {
                Yii::$app->session->setFlash('error', 'Email did not validate.  Try again. '  
                    //. '<pre>' . print_r($model, true) . "\n" . print_r($model->getErrors(), true) . '</pre>'
                );
                return $this->render('find-professional', [
                    'model' => $model,
                ]);
            }
        } else {
            //Yii::$app->session->setFlash('error', 'Email did not validate.  Try again.');
            return $this->render('find-professional', [
                'model' => $model,
            ]);
        }
    }
}
