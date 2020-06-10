<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

use app\models\Distributor;
use app\models\DistributorSearch;
use app\models\User;

/**
 * DistributorController implements the CRUD actions for Distributor model.
 */
class DistributorController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'view', 'update', 'delete', 'clone', 'admin-index'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (User::isCurrentUserAdmin());
                        }
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],  // @ = Authenticated users
                    ],
                    [
                       'allow' => true,
                       'actions' => ['index'],
                       'roles' => ['?'],  // ? = Guest user
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Distributor models.
     * @return mixed
     */
    public function actionIndex()
    {
        $models = $this->findModelAll();
        return $this->render('index', [
           'models' => $models
        ]);
    }
    
    /**
     * Lists all Distributor models.
     * @return mixed
     */
    public function actionAdminIndex()
    {
        $searchModel = new DistributorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('admin/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]); 
    }

    /**
     * Displays a single Distributor model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('admin/view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Distributor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Distributor();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('admin/create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Distributor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('admin/update', [
                'model' => $model,
            ]);
        }
    }
    
    /**
     * Copies an existing Distributor model.
     * If copy is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionClone($id)
    {
        //$this->enableCsrfValidation = false;  // set to 'false' to overcome 'Unable to verify your data submission: Bad request (#400)' error.
        
        $model = $this->findModel($id);
        
        // Copy data (except ID)
        $dataCopy = $model->attributes;
        unset($dataCopy['id']);  // to insert new record with a copy of the data
        $dataCopy['company_name'] = $dataCopy['company_name'] . ' (Copy)';
        $newModel = new Distributor();
        $newModel->setAttributes($dataCopy, false);
        
        if ($newModel->save()) {
            Yii::$app->session->setFlash('success', "Successfully cloned Distributor.");
            return $this->redirect(['update', 'id' => $newModel->id]);
        } else {
            // Could not save copy, so we simply view original record
            Yii::$app->session->setFlash('error', "Failed to clone Distributor.");
            return $this->redirect(['view', 'id' => $model->id]);
        }
        
        //$this->enableCsrfValidation = true;  // restore CSRF validation
    }

    /**
     * Deletes an existing Distributor model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['admin-index']);
    }

    /**
     * Finds the Distributor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Distributor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Distributor::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
     * Finds all Distributor model based active status.
     * If the models are not found, a 404 HTTP exception will be thrown.
     * @return Distributor  array of models
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelAll()
    {
        if (($models = Distributor::find()
                ->where(['status' => Distributor::STATUS_ACTIVE])
                ->orderBy('dist_country')
                ->all()) !== null) {
            return $models;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
