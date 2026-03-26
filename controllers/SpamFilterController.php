<?php

namespace app\controllers;

use Yii;
use app\models\SpamFilter;
use app\models\SpamFilterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * SpamFilterController implements the CRUD actions for SpamFilter model.
 */
class SpamFilterController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'create', 'view', 'update', 'clone', 'delete', 'admin-index',
                        ],
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin());
                        }
                    ],
                    //[
                    //    'allow' => true,
                    //    'actions' => ['index', 'view',],
                    //    'roles' => ['@'],  // @ = Authenticated users
                    //],
                    //[
                    //   'allow' => true,
                    //   'actions' => ['index', 'view'],
                    //   'roles' => ['?'],  // ? = Guest user
                    //],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all SpamFilter models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SpamFilterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin()) {
            return $this->render('admin/index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);

        }
    }
    
    /**
     * Lists all SpamFilter models.
     * @return mixed
     */
    public function actionAdminIndex()
    {
        $searchModel = new SpamFilterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('admin/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SpamFilter model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('admin/view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new SpamFilter model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SpamFilter();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('admin/create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SpamFilter model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('admin/update', [
            'model' => $model,
        ]);
    }
    
    /**
     * Copies an existing SpamFilter model.
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
        $dataCopy['name'] = $dataCopy['name'] . ' (Copy)';
        $newModel = new SpamFilter();
        $newModel->setAttributes($dataCopy, false);
        
        if ($newModel->save()) {
            Yii::$app->session->setFlash('success', "Successfully cloned Spam Filter.");
            return $this->redirect(['update', 'id' => $newModel->id]);
        } else {
            // Could not save copy, so we simply view original record
            Yii::$app->session->setFlash('error', "Failed to clone Spam Filter.");
            return $this->redirect(['view', 'id' => $model->id]);
        }
        
        //$this->enableCsrfValidation = true;  // restore CSRF validation
    }

    /**
     * Deletes an existing SpamFilter model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['admin-index']);
    }

    /**
     * Finds the SpamFilter model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SpamFilter the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SpamFilter::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
