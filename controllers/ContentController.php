<?php

namespace app\controllers;

use Yii;
use yii\base\Model;
use yii\web\Controller;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

use app\models\Content;
use app\models\ContentSearch;
use app\models\ContentCategory;
use app\models\ContentType;

class ContentController extends Controller
{
    public function behaviors()
    {
        //public $enableCsrfValidation = true;  // Set to 'false' if having trouble saving data (create/update, etc.)
        
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'create', 'view', 'update', 'clone', 'delete',  
                            'carousel-create', 'carousel-form', 'carousel-index', 'carousel-update', 'carousel-view', 'carousel-clone',
                            'motd-create', 'motd-form', 'motd-index', 'motd-update', 'motd-view', 'motd-clone',
                            'admin-index',
                        ],
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin());
                        }
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'carousel-index', 'carousel-view'],
                        'roles' => ['@'],  // @ = Authenticated users
                    ],
                    [
                       'allow' => true,
                       'actions' => ['index', 'view'],
                       'roles' => ['?'],  // ? = Guest user
                    ],
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
     * Lists all Content models.
     * @return mixed
     */
    public function actionIndex($category='N/A', $tags='', $ord='asc', $by='')
    {
        switch($ord) {
            case 'asc':  $sortOrder = SORT_ASC; break;
            case 'desc': $sortOrder = SORT_DESC; break;
            default:     $sortOrder = SORT_ASC; break;
        }
        
        // OrderBy: id, title, ordering, created_at, updated_at, publish_up
        switch($by) {
            case 'id':         $sortField = 'id'; break;
            case 'title':      $sortField = 'title'; break;
            case 'ordering':   $sortField = 'ordering'; break;
            case 'created_at': $sortField = 'created_at'; break;
            case 'updated_at': $sortField = 'updated_at'; break;
            case 'publish_up': $sortField = 'publish_up'; break;
            default:           $sortField = 'title'; break;
        }
        
        
        // to retrieve all *active* content, and order them by their ID:
        $query = Content::find()
            ->joinWith('category')
            ->where(['status' => Content::STATUS_ACTIVE])
            ->andWhere(['content_category.alias' => $category])
            ->andWhere(
                //['or', ['publish_up'=> null], ['<=', 'publish_up', date("Y-m-d 23:59:00")]]     // handle date only
                ['or', ['publish_up'=> null], ['<=', 'publish_up', date("Y-m-d H:i:s")]]          // handle date & time
            )
            ->andWhere(
                //['or', ['publish_down'=> null], ['>=', 'publish_down', date("Y-m-d 23:59:00")]]  // handle date only
                ['or', ['publish_down'=> null], ['>=', 'publish_down', date("Y-m-d H:i:s")]]       // handle date & time
            )
            ->andFilterWhere(['like', 'tags', $tags])
            ->orderBy([$sortField => $sortOrder])   
            ->all();
            
        /*
        $countQuery = clone $query;  // generates error: __clone method called on non-object
        $pages      = new Pagination(['totalCount' => $countQuery->count()]);
        $models     = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        */
        
        return $this->render('index', [
             //'models' => $models,
             //'pages'  => $pages,
             'models'   => $query,
             //'categoryTitle' => $query['content_category.title']
             'category' => $category,
             'tags'     => $tags,
             'ord'      => $ord,
             'by'       => $by,
        ]);
    }
    
    /**
     * Lists all Content models.
     * @return mixed
     */
    public function actionAdminIndex($category='N/A', $tags='', $ord='asc', $by='')
    {
        switch($ord) {
            case 'asc':  $sortOrder = SORT_ASC; break;
            case 'desc': $sortOrder = SORT_DESC; break;
            default:     $sortOrder = SORT_ASC; break;
        }
        
        // OrderBy: id, title, ordering, created_at, updated_at, publish_up
        switch($by) {
            case 'id':         $sortField = 'id'; break;
            case 'title':      $sortField = 'title'; break;
            case 'ordering':   $sortField = 'ordering'; break;
            case 'created_at': $sortField = 'created_at'; break;
            case 'updated_at': $sortField = 'updated_at'; break;
            case 'publish_up': $sortField = 'publish_up'; break;
            default:           $sortField = 'title'; break;
        }
        
        $searchModel = new ContentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        // additional query filters
        if (!empty($category) && ($category !== 'N/A')) {
            $dataProvider->query->andWhere(['content_category.alias' => $category]);  
        }
        if (!empty($tags)) {
            $dataProvider->query->andWhere(['like', 'tags', $tags]); 
        }

        // query order
        $dataProvider->sort = ['defaultOrder' => [$sortField => $sortOrder]];
        
        return $this->render('admin/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Displays a single Content model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        //$model = new Content();
        //$model = Content::find()->where(['content.id' => $id]); //->joinWith('customer')->one();

        return $this->render('view', [
            'model' => $this->findModel($id), //$model,
        ]);
    }
    

    /**
     * Creates a new Content model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Content();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            // set default values before rendering
            if (empty($model->show_hits))   $model->show_hits   = 0;
            if (empty($model->show_rating)) $model->show_rating = 0;
            if (empty($model->featured))    $model->featured    = 0;
            if (empty($model->ordering))    $model->ordering    = 0;
            if (empty($model->created_by))  $model->created_by = Yii::$app->user->id;
            
            return $this->render('admin/create', [
                'model' => $model,
            ]);
        }
    }
    
    /**
     * Updates an existing Content model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        //$this->enableCsrfValidation = false;  // set to 'false' to overcome 'Unable to verify your data submission: Bad request (#400)' error.
        
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            // set values before rendering
            if (empty($model->updated_by)) $model->updated_by = Yii::$app->user->id;
            
            return $this->render('admin/update', [
                'model' => $model,
            ]);
        }
        
        //$this->enableCsrfValidation = true;  // restore CSRF validation
    }
    
    /**
     * Clones an existing Content model.
     * If copy is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionClone($id)
    {
        //$this->enableCsrfValidation = false;  // set to 'false' to overcome 'Unable to verify your data submission: Bad request (#400)' error.
        
        $newModel = $this->cloneModel($id);
        
        if ($newModel->save()) {
            Yii::$app->session->setFlash('success', "Successfully cloned article.");
            return $this->redirect(['update', 'id' => $newModel->id]);
        } else {
            // Could not save copy, so we simply view original record
            Yii::$app->session->setFlash('error', "Failed to clone article.");
            return $this->redirect(['view', 'id' => $model->id]);
        }
        
        //$this->enableCsrfValidation = true;  // restore CSRF validation
    }
    
    /**
     * Deletes an existing Content model.
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
     * Lists all Content models.
     * @return mixed
     */
    public function actionCarouselIndex()
    {
        $searchModel = new ContentSearch();
        $dataProvider = $searchModel->searchCarousel(Yii::$app->request->queryParams);

        return $this->render('admin/carousel-index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Content model.
     * @param integer $id
     * @return mixed
     */
    public function actionCarouselView($id)
    {
        return $this->render('admin/carousel-view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Content model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCarouselCreate()
    {
        $model = new Content();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['carousel-view', 'id' => $model->id]);
        } else {
            // set default values before rendering
            if (empty($model->show_hits))   $model->show_hits   = 0;
            if (empty($model->show_rating)) $model->show_rating = 0;
            if (empty($model->featured))    $model->featured    = 0;
            if (empty($model->ordering))    $model->ordering    = 0;
            if (empty($model->created_by))  $model->created_by = Yii::$app->user->id;
            
            return $this->render('carousel-create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Content model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionCarouselUpdate($id)
    {
        //$this->enableCsrfValidation = false;  // set to 'false' to overcome 'Unable to verify your data submission: Bad request (#400)' error.
        
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['carousel-view', 'id' => $model->id]);
        } else {
            // set values before rendering
            if (empty($model->updated_by)) $model->updated_by = Yii::$app->user->id;
            
            return $this->render('admin/carousel-update', [
                'model' => $model,
            ]);
        }
        
        //$this->enableCsrfValidation = true;  // restore CSRF validation
    }
    
    /**
     * Clones an existing Content model.
     * If copy is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionCarouselClone($id)
    {
        //$this->enableCsrfValidation = false;  // set to 'false' to overcome 'Unable to verify your data submission: Bad request (#400)' error.
        
        $newModel = $this->cloneModel($id);
        
        if ($newModel->save()) {
            Yii::$app->session->setFlash('success', "Successfully cloned carousel.");
            return $this->redirect(['carousel-update', 'id' => $newModel->id]);
        } else {
            // Could not save copy, so we simply view original record
            Yii::$app->session->setFlash('error', "Failed to clone carousel.");
            return $this->redirect(['carousel-view', 'id' => $model->id]);
        }
        
        //$this->enableCsrfValidation = true;  // restore CSRF validation
    }
    
    /**
     * Lists all Content models.
     * @return mixed
     */
    public function actionMotdIndex()
    {
        $searchModel = new ContentSearch();
        $dataProvider = $searchModel->searchMotd(Yii::$app->request->queryParams);

        return $this->render('admin/motd-index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Content model.
     * @param integer $id
     * @return mixed
     */
    public function actionMotdView($id)
    {
        return $this->render('admin/motd-view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Content model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionMotdCreate()
    {
        $model = new Content();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['motd-view', 'id' => $model->id]);
        } else {
            // set default values before rendering
            if (empty($model->category_id)) $model->category_id = 4; // 4 = News
            if (empty($model->type_id))     $model->category_id = 8; // 8 = Message of the Day
            if (empty($model->show_hits))   $model->show_hits   = 0;
            if (empty($model->show_rating)) $model->show_rating = 0;
            if (empty($model->featured))    $model->featured    = 0;
            if (empty($model->ordering))    $model->ordering    = 0;
            if (empty($model->created_by))  $model->created_by = Yii::$app->user->id;
            
            return $this->render('admin/motd-create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Content model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionMotdUpdate($id)
    {
        //$this->enableCsrfValidation = false;  // set to 'false' to overcome 'Unable to verify your data submission: Bad request (#400)' error.
        
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['motd-view', 'id' => $model->id]);
        } else {
            // set values before rendering
            if (empty($model->updated_by)) $model->updated_by = Yii::$app->user->id;
            
            return $this->render('admin/motd-update', [
                'model' => $model,
            ]);
        }
        
        //$this->enableCsrfValidation = true;  // restore CSRF validation
    }
    
    /**
     * Clones an existing Content model.
     * If copy is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionMotdClone($id)
    {
        //$this->enableCsrfValidation = false;  // set to 'false' to overcome 'Unable to verify your data submission: Bad request (#400)' error.
        
        $newModel = $this->cloneModel($id);
        
        if ($newModel->save()) {
            Yii::$app->session->setFlash('success', "Successfully cloned MOTD.");
            return $this->redirect(['motd-update', 'id' => $newModel->id]);
        } else {
            // Could not save copy, so we simply view original record
            Yii::$app->session->setFlash('error', "Failed to clone MOTD.");
            return $this->redirect(['motd-view', 'id' => $model->id]);
        }
        
        //$this->enableCsrfValidation = true;  // restore CSRF validation
    }
    
    /**
     * Finds the Content model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Content the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Content::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
     * Clones the specified Content model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Content the cloned model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function cloneModel($id)
    {
        $model = $this->findModel($id);
        
        // Copy data (except ID)
        $dataCopy = $model->attributes;
        unset($dataCopy['id']);  // to insert new record with a copy of the data
        $dataCopy['title'] = $dataCopy['title'] . ' (Copy)';
        $dataCopy['created_at'] = date("Y-m-d H:i:s");
        $dataCopy['updated_at'] = date("Y-m-d H:i:s");
        $newModel = new Content();
        $newModel->setAttributes($dataCopy, false);
        
        return $newModel;
    }

}
