<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use app\models\ContentCategory;
use app\models\ContentCategorySearch;

/**
 * ContentCategoryController implements the CRUD actions for ContentCategory model.
 */
class ContentCategoryController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'view', 'update', 'clone', 'delete', 'admin-index'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin());
                        }
                    ],
                    [
                        'actions' => ['index', 'view'],
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
     * Lists all ContentCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            //--------------------------------
            // Authenticated user content
            //--------------------------------
            return $this->redirect(['site/index']);
        } else {
            //--------------------------------
            // Unauthenticated user content
            //--------------------------------
            return $this->redirect(['site/index']);
        }
    }
    
    /**
     * Lists all ContentCategory models.
     * @return mixed
     */
    public function actionAdminIndex()
    {
        $searchModel = new ContentCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('admin/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ContentCategory model.
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
     * Creates a new ContentCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ContentCategory();

        //if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //        return $this->redirect(['view', 'id' => $model->id]);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::info('Failed to save updates');
                return $this->render('admin/create', [
                    'model' => $model,
                ]);
            }
        } else {
            return $this->render('admin/create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ContentCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        //if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //    return $this->redirect(['view', 'id' => $model->id]);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::info('Failed to save updates');
                return $this->render('admin/create', [
                    'model' => $model,
                ]);
            }
        } else {
            return $this->render('admin/update', [
                'model' => $model,
            ]);
        }
    }
    
    /**
     * Copies an existing ContentCategory model.
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
        $dataCopy['title'] = $dataCopy['title'] . ' (Copy)';
        $newModel = new ContentCategory();
        $newModel->setAttributes($dataCopy, false);
        
        if ($newModel->save()) {
            Yii::$app->session->setFlash('success', "Successfully cloned Content Category.");
            return $this->redirect(['update', 'id' => $newModel->id]);
        } else {
            // Could not save copy, so we simply view original record
            Yii::$app->session->setFlash('error', "Failed to clone Content Category.");
            return $this->redirect(['view', 'id' => $model->id]);
        }
        
        //$this->enableCsrfValidation = true;  // restore CSRF validation
    }

    /**
     * Deletes an existing ContentCategory model.
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
     * Finds the ContentCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ContentCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ContentCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

