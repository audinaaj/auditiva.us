<?php

namespace app\controllers;

use Yii;
use app\models\AppSetting;
use app\models\AppSettingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * AppSettingController implements the CRUD actions for AppSetting model.
 */
class AppSettingController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                //'only' => ['index', 'create', 'view', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'view', 'update', 'clone', 'delete', 'admin-index', ],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {  // Admin users
                            return (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin());
                        }
                    ],
                    //[
                    //   'allow' => true,
                    //   'actions' => ['index'],
                    //   'roles' => ['@'],  // @ = Authenticated users
                    //],
                    //[
                    //   'allow' => true,
                    //   'actions' => ['index'],
                    //   'roles' => ['?'],  // ? = Guest users
                    //],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all AppSetting models.
     * @return mixed
     */
    public function actionIndex($filter='')
    {
        $searchModel = new AppSettingSearch();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search(yii\helpers\ArrayHelper::merge(
            Yii::$app->request->queryParams,
            ['AppSettingSearch' => [
                'key' => $filter,
            ]]
        ));
        
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin()) {
            return $this->render('admin/index', [
                'searchModel'  => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            return $this->render('index', [
                'searchModel'  => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }
    
    /**
     * Lists all AppSetting models.
     * @return mixed
     */
    public function actionAdminIndex($filter='')
    {
        $searchModel = new AppSettingSearch();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search(yii\helpers\ArrayHelper::merge(
            Yii::$app->request->queryParams,
            ['AppSettingSearch' => [
                'key' => $filter,
            ]]
        ));

        return $this->render('admin/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AppSetting model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('admin/view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AppSetting model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AppSetting();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('admin/create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing AppSetting model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
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
     * Copies an existing AppSetting model.
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
         $dataCopy['key'] = $dataCopy['key'] . ' (Copy)';

         $newModel = new AppSetting();
         $newModel->setAttributes($dataCopy, false);
         
         if ($newModel->save()) {
             Yii::$app->session->setFlash('success', "Successfully cloned setting item.");
             return $this->redirect(['update', 'id' => $newModel->id]);
         } else {
             // Could not save copy, so we simply view original record
             Yii::$app->session->setFlash('error', "Failed to clone setting item.");
             return $this->redirect(['view', 'id' => $model->id]);
         }
         
         //$this->enableCsrfValidation = true;  // restore CSRF validation
     }

    /**
     * Deletes an existing AppSetting model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['admin-index']);
    }

    /**
     * Finds the AppSetting model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AppSetting the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AppSetting::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
