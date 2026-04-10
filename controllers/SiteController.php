<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

use app\models\ContactForm;
use app\models\ContactUsForm;
use app\models\Content;
use app\models\LoginForm;
use app\models\User;

class SiteController extends \yii\web\Controller
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
                'only' => ['backup-database'],
            ],
            //'access' => [
            //    'class' => AccessControl::class,
            //    'only' => ['logout'],
            //    'rules' => [
            //        [
            //            'actions' => [],
            //            'allow' => true,
            //            'roles' => ['?'],  // ? = Guest user
            //        ],
            //        [
            //            'actions' => ['logout'],
            //            'allow' => true,
            //            'roles' => ['@'],  // @ = Authenticated users
            //        ],
            //    ],
            //],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => [
                            'admin-dashboard', 'media-gallery', 'backup-database',
                            'error', 'about',
                        ],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin());
                        }
                    ],
                    [
                        'actions' => ['logout', 'index', 'message', ],
                        'allow' => true,
                        'roles' => ['@'],  // @ = authenticated users
                    ],
                    [
                        // any user (authenticated or not)
                        'actions' => ['index', 'login', 'error', 'about', 'contact-us', 'message', 'privacy', 'captcha'],
                        'allow' => true,
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['POST'],
                ],
            ],
        ];
    }

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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex($ord='desc', $by='')
    {
        //return $this->render('index');
        switch($ord) {
            case 'asc':  $sortOrder = SORT_ASC; break;
            case 'desc': $sortOrder = SORT_DESC; break;
            default:     $sortOrder = SORT_DESC; break;
        }
        
        // OrderBy: id, title, ordering, created_at, updated_at, publish_up
        switch($by) {
            case 'id':         $sortField = 'id'; break;
            case 'title':      $sortField = 'title'; break;
            case 'ordering':   $sortField = 'ordering'; break;
            case 'created_at': $sortField = 'created_at'; break;
            case 'updated_at': $sortField = 'updated_at'; break;
            case 'publish_up': $sortField = 'publish_up'; break;
            default:           $sortField = 'created_at'; break;
        }

        // Carousel
        // to retrieve all *active* content, and order them by their ID:
        $queryCarousel = Content::find()
            ->joinWith('category')
            ->joinWith('contentType')
            ->where(['status' => Content::STATUS_ACTIVE])
            ->andWhere(['content_type.alias' => 'carousel'])
            //->andWhere(['content_category.alias' => $category])
            ->andWhere(
                //['or', ['publish_up'=> null], ['<=', 'publish_up', date("Y-m-d H:i:s")]]      // handle date & time
                ['or', ['publish_up'=> null], ['<=', 'publish_up', date("Y-m-d 23:59:00")]]     // handle date only
            )
            ->andWhere(
                //['or', ['publish_down'=> null], ['>=', 'publish_down', date("Y-m-d H:i:s")]]   // handle date & time
                ['or', ['publish_down'=> null], ['>=', 'publish_down', date("Y-m-d 23:59:00")]]  // handle date only
            )
            //->andFilterWhere(['like', 'tags', $tags])
            ->orderBy(['content.'.$sortField => $sortOrder]) 
            ->all();

        // Featured Articles
        // to retrieve all *active* content, and order them by their ID:
        $queryFeatured = Content::find()
            ->joinWith('category')
            ->joinWith('contentType')
            ->where(['status' => Content::STATUS_ACTIVE])
            ->andWhere(['featured' => 1])
            ->andWhere(
                //['or', ['publish_up'=> null], ['<=', 'publish_up', date("Y-m-d H:i:s")]]      // handle date & time
                ['or', ['publish_up'=> null], ['<=', 'publish_up', date("Y-m-d 23:59:00")]]     // handle date only
            )
            ->andWhere(
                //['or', ['publish_down'=> null], ['>=', 'publish_down', date("Y-m-d H:i:s")]]   // handle date & time
                ['or', ['publish_down'=> null], ['>=', 'publish_down', date("Y-m-d 23:59:00")]]  // handle date only
            )
            //->andFilterWhere(['like', 'tags', $tags])
            ->orderBy(['content.created_at' => SORT_DESC]) 
            ->all();
            
        return $this->render('index', [
             'modelsCarousel' => $queryCarousel,
             'modelsFeatured' => $queryFeatured,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            // log login
            Yii::$app->user->identity->last_login = date("Y-m-d H:i:s");
            Yii::$app->user->identity->save();

            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                //Yii::$app->session->setFlash('contactFormSubmitted');
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionContactUs()
    {
        //return $this->render('contact-us');
        
        $model = new ContactUsForm();
        if ($model->load(Yii::$app->request->post())) {
            // Preset some data
            //$model->name = Yii::$app->request->post('firstName') . ' ' . Yii::$app->request->post('lastName');
            
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
                //$this->createAction('captcha')->getVerifyCode(true); // to regenerate new captcha after failed validation
                return $this->render('contact-us', [
                    'model' => $model,
                ]);
            }
        } else {
            //Yii::$app->session->setFlash('error', 'Email did not validate.  Try again.');
            return $this->render('contact-us', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
    
    public function actionInternational()
    {
        return $this->render('international');
    }
    
    public function actionOffline()
    {
        return $this->render('offline');
    }
    
    public function actionPrivacy()
    {
        return $this->render('privacy');
    }
    
    public function actionAdminDashboard()
    {
        return $this->render('admin/dashboard');
    }
    
    public function actionMediaGallery()
    {
        return $this->render('media-gallery');
    }
    
    public function actionMessage($type, $title, $message, $button_name='', $button_url='')
    {
        switch($type)
        {
            case 'error':
            case 'success':
            case 'info':
                break;
                
            default:
                $type = 'info';
                break;
        }
        return $this->render('/site/message', [
            'type'        => $type, 
            'title'       => $title, 
            'message'     => $message,
            'button_name' => $button_name,
            'button_url'  => $button_url,
        ]);
    }
    
    private function sendMessage($srcMail, $srcName, $dstEmail, $subject, $textBody)
    {
        $success = Yii::$app->mailer->compose()
                ->setFrom([$srcMail => $srcName])
                ->setTo($dstEmail)
                ->setBcc([Yii::$app->params['debugEmail'] => 'Debug Email'])
                ->setSubject($subject)
                ->setTextBody($textBody)
                ->send();
              
        return $success;
    }
    
    /** 
     *  Get host name or database name from database connection string in 
     *  Yii::$app->db->dsn:
     *   [dsn] => 'mysql:host=localhost;dbname=acme_mydatabase'
     *  Usage:
     *    $db = Yii::$app->getDb();
     *   $dbName = $this->getDsnAttribute('dbname', $db->dsn);
     */
    private function getDsnAttribute($name, $dsn)
    {
        if (preg_match('/' . $name . '=([^;]*)/', $dsn, $match)) {
            return $match[1];
        } else {
            return null;
        }
    }
    
    /**
     * Generate database backup SQL dump.
     * Private helper method used by both UI and API backup actions.
     *
     * @param string $tables Comma separated list of tables or '*' for all
     * @return array Array with 'sql', 'databaseName', and 'timestamp' keys
     * @throws \Exception
     */
    private function generateDatabaseBackup($tables = '*')
    {
        $output = '';

        $db = Yii::$app->getDb();
        $databaseName = $this->getDsnAttribute('dbname', $db->dsn);

        // Do a short header with charset declaration
        $output .= '-- Database: `' . $databaseName . '`' . "\n";
        $output .= '-- Generation time: ' . date('D jS M Y H:i:s') . "\n\n\n";
        $output .= "/*!40101 SET NAMES utf8mb4 */;\n";
        $output .= 'SET FOREIGN_KEY_CHECKS=0;' . "\n\n";

        if ($tables == '*') {
            $tables = array();
            $result = $db->createCommand('SHOW TABLES')->queryAll();
            foreach($result as $resultKey => $resultValue) {
                $tables[] = $resultValue['Tables_in_'.$databaseName];
            }
        } else {
            $tables = is_array($tables) ? $tables : explode(',', $tables);
        }

        // Run through all the tables
        foreach ($tables as $table) {
            $tableData = $db->createCommand('SELECT * FROM ' . $table)->queryAll();

            $output .= 'DROP TABLE IF EXISTS ' . $table . ';';
            $createTableResult = $db->createCommand('SHOW CREATE TABLE ' . $table)->queryAll();
            $createTableEntry = current($createTableResult);
            $output .= "\n\n" . $createTableEntry['Create Table'] . ";\n\n";

            // Output the table data
            foreach($tableData as $tableDataIndex => $tableDataDetails) {
                $output .= 'INSERT INTO ' . $table . ' VALUES(';
            
                foreach($tableDataDetails as $dataKey => $dataValue) {
                    if(is_null($dataValue)) {
                        $escapedDataValue = 'NULL';
                    } elseif (in_array($dataValue, ['0000-00-00 00:00:00', '0000-00-00'])) {
                        // Convert zero dates to NULL to comply with strict mode
                        $escapedDataValue = 'NULL';
                    } else {
                        // Convert the encoding
                        //$escapedDataValue = mb_convert_encoding( $dataValue, "UTF-8", "ISO-8859-1" );
                        $escapedDataValue = $dataValue;  // no char conversion (keep it as UTF-8)
            
                        // Escape any apostrophes using the datasource of the model.
                        $escapedDataValue = str_replace("'", "\'", $escapedDataValue);  // escape apostrophes
                        //if (stripos($escapedDataValue, ' ') !== false) {
                        //    $escapedDataValue = "'" . $escapedDataValue . "'";  // quote string if spaces found
                        //}
                        //if (!is_numeric($escapedDataValue)) {
                        //    $escapedDataValue = "'" . $escapedDataValue . "'";  // quote string if non-numeric
                        //}
                        $escapedDataValue = "'" . $escapedDataValue . "'";        // quote string for all fields without NULL
                    }
            
                    $tableDataDetails[$dataKey] = $escapedDataValue;
                }
                $output .= implode(',', $tableDataDetails);
            
                $output .= ");\n";
            }

            $output .= "\n\n\n";
        }

        $output .= 'SET FOREIGN_KEY_CHECKS=1;' . "\n\n";

        return [
            'sql' => $output,
            'databaseName' => $databaseName,
            'timestamp' => date('Y-m-d H:i:s'),
        ];
    }

    /**
     * Dumps the MySQL database that this controller's model is attached to.
     * This action will serve the sql file as a download so that the user can save the backup to their local computer.
     *
     * @param string $tables Comma separated list of tables you want to download, or '*' if you want to download them all.
     */
    public function actionBackupDatabase($tables = '*')
    {
        $backup = $this->generateDatabaseBackup($tables);
        $filename = $backup['databaseName'] . '-backup-' . date('Y-m-d_H-i-s') . '.sql';
        Yii::$app->response->sendContentAsFile($backup['sql'], $filename, ['mimeType' => 'text/x-sql']);
    }


}
