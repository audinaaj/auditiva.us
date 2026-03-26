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
        $DS = DIRECTORY_SEPARATOR;
        //$dir     = Yii::$app->basePath . $DS . 'web' . $DS . 'media' . $DS . 'brochure';
        $dirBrochure   = str_replace('frontend', 'backend', Yii::$app->basePath) . $DS . 'web' . $DS . 'media' . $DS . 'brochure';
        $dirUserManual = str_replace('frontend', 'backend', Yii::$app->basePath) . $DS . 'web' . $DS . 'media' . $DS . 'usermanual';
        
        //echo '<pre>Dir: ' . $dir . '</pre>';
        //$files1 = scandir($dir, SCANDIR_SORT_ASCENDING);
        //$files2 = scandir($dir, SCANDIR_SORT_DESCENDING);
        //$files3 = array_diff(scandir($dir), array('..', '.'));  // get rid of the dot files

        //echo '<pre>Files found: ' . print_r($files1, true) . '</pre><p>';
        //echo '<pre>Files found: ' . print_r($files2, true) . '</pre>';
        //echo '<pre>Files found: ' . print_r($files3, true) . '</pre>';
        
        $filesBrochure   = array();
        $filesUserManual = array();
        $folders         = array();
        $this->GetFileAndFolderList($dirBrochure,   "pdf", $filesBrochure,   $folders);
        $this->GetFileAndFolderList($dirUserManual, "pdf", $filesUserManual, $folders);
       
        //echo '<pre>Files found: ' . print_r($files, true) . '</pre>';
    
        return $this->render('product-brochures', [
                'filesBrochure'   => $filesBrochure,
                'dirBrochure'     => $dirBrochure,
                'filesUserManual' => $filesUserManual,
                'dirUserManual'   => $dirUserManual,
                'ShowAllProducts' => $ShowAllProducts,
            ]);
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
    
    //-------------------------------------------------------------------------------------------------
    // description: Get file list for the specified path (filtered by the specified extension).
    //              Eg: $files = GetFileList("/catalog", "*.pdf");
    //                  echo "<br><pre>" . print_r($files, true) . "</pre><p>"; 
    // parameters : $aBaseDir (no trailing slash), $aFilePattern (eg: *.jpg)
    // return     : $files (string array)
    //-------------------------------------------------------------------------------------------------
    function GetFileList($aBaseDir, $aFilePattern)
    {
        $filepattern = $_SERVER["DOCUMENT_ROOT"] . $aBaseDir . "/". $aFilePattern;
        //$filepattern = $aBaseDir . "/". $aFilePattern;
        echo $filepattern;
            
        $files       = @glob($filepattern);
        $filestotal  = @count($files);
        $curfile     = "";

        //for ($filecurcnt = 0; $filecurcnt < $filestotal; $filecurcnt++)
        //{
        //    $curfile = $files[$filecurcnt];
        //    echo $curfile . "<br>"; // here you can get full address of files (one by one)
        //}
        return $files;
    }

    //-------------------------------------------------------------------------------------------------
    // description: Get file and folder list for the specified path (filtered by the specified extension).
    //              Eg: 
    //                $files = array();
    //                $folders = array();
    //                GetFileAndFolderList("/catalog", "pdf", $files, $folders);
    //                echo "<br><pre>" . print_r($files, true) . "</pre><p>"; 
    // parameters : $aBaseDir (no trailing slash), $aFileType (no leading dot), $Files_Result (output array), $Folders_Result (output array)
    // return     : void
    //-------------------------------------------------------------------------------------------------
    function GetFileAndFolderList($aBaseDir, $aFileType, &$Files_Result, &$Folders_Result)
    {
        $aBaseDir = rtrim($aBaseDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;  // add trailing slash
        
        $Folders_Result = array();
        $Files_Result   = array();
        if (is_dir($aBaseDir)) {
            $dirhandle = opendir($aBaseDir);
            
            while (($file = readdir($dirhandle)) !== false) {
                if($file != "." and $file != "..") {
                    if(is_dir($aBaseDir . $file)) {  
                        $Folders_Result[] = $file;
                    } else {
                        $ext = pathinfo($file, PATHINFO_EXTENSION);
                        //$filename = pathinfo($file, PATHINFO_FILENAME); 
                        if ($ext == $aFileType) {
                            $Files_Result[] = $file;
                        }
                    }
                }
            }
            closedir($dirhandle);
            
            // sort, just in case
            if (defined('SORT_NATURAL')) {  // supported in PHP 5.4.0 or newer only
                if (isset($Files_Result))   { sort($Files_Result,   SORT_NATURAL | SORT_FLAG_CASE); }
                if (isset($Folders_Result)) { sort($Folders_Result, SORT_NATURAL | SORT_FLAG_CASE); }
            } else {
                if (isset($Files_Result))   { sort($Files_Result,   SORT_STRING); }
                if (isset($Folders_Result)) { sort($Folders_Result, SORT_STRING); }
            }
        } 
    }
    
}
