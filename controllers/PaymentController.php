<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use AuthorizeNetAIM;

use app\models\AccountAging;
use app\models\Payment;
use app\models\PaymentSearch;
use app\models\User;

define("AUTHORIZENET_API_LOGIN_ID",    Yii::$app->params["authorizenetAPILoginId"]     );
define("AUTHORIZENET_TRANSACTION_KEY", Yii::$app->params["authorizenetTransactionKey"] );
define("AUTHORIZENET_SANDBOX",         Yii::$app->params["authorizenetSandbox"]        );

/**
 * PaymentController implements the CRUD actions for Payment model.
 */
class PaymentController extends Controller
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
                        'actions' => ['index', 'create', 'view', 'update', 'delete', 'admin-index'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin());
                        }
                    ],
                    [
                        'actions' => ['index', 'create', 'view'],
                        'allow' => true,
                        'roles' => ['@'],  // @ = Authenticated users
                    ],
                    [
                       'allow' => true,
                       'actions' => ['view', 'create'],
                       'roles' => ['?'],  // ? = Guest user
                    ],
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
     * Lists all Payment models.
     * @return mixed
     */
    public function actionIndex($owner_id=0)
    {
        $searchModel = new PaymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        // additional query filters
        $dataProvider->query->andWhere(['created_by' => $owner_id]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Lists all Payment models.
     * @return mixed
     */
    public function actionAdminIndex()
    {
        $searchModel = new PaymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('admin/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Displays a single Payment model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Payment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($amount=0)
    {
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin()) {
            //--------------------------------
            // Admin create test payment
            //--------------------------------
            $model = new Payment();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('admin/create', [
                    'model' => $model,
                ]);
            }
        } else {
            //-------------------------------------
            // Unauthenticated creates real payment
            //-------------------------------------
            $model = new Payment();

            // Pre-populate form (if user logged in)
            if (isset(Yii::$app->user->identity)) {
                $model->full_name         = Yii::$app->user->identity->full_name;
                $model->company_name      = Yii::$app->user->identity->company_name;
                $model->account_number    = Yii::$app->user->identity->account_number;
                $model->email             = Yii::$app->user->identity->email;
                $model->phone             = Yii::$app->user->identity->phone;
                $model->address           = Yii::$app->user->identity->address1 . ' ' . Yii::$app->user->identity->address2;
                $model->city              = Yii::$app->user->identity->city;
                $model->state_prov        = Yii::$app->user->identity->state_prov;
                $model->postal_code       = Yii::$app->user->identity->postal_code;
                $model->country           = Yii::$app->user->identity->country;
                
                if (strpos(Yii::$app->user->identity->full_name, ' ') !== false) {
                    list($first_name, $last_name) = explode(' ', Yii::$app->user->identity->full_name);
                    $model->crcard_first_name = $first_name;
                    $model->crcard_last_name  = $last_name;
                } else {
                    $model->crcard_first_name = Yii::$app->user->identity->full_name;
                    $model->crcard_last_name  = '';
                }
            }
            
            if ($model->load(Yii::$app->request->post())) {
                //Yii::$app->session->setFlash('success', "Payment Create: request post: <pre>".print_r(Yii::$app->request->post(), true)."</pre>");
                
                // Submit payment to Authorize.Net getaway
                $payment = new AuthorizeNetAIM();
                //$payment->login            = Yii::$app->params["authorizenetAPILoginId"];
                //$payment->tran_key         = Yii::$app->params["authorizenetTransactionKey"];
                $payment->test_request       = Yii::$app->params["authorizenetTestMode"];
                                            
                $payment->amount             = $model->amount;
                $payment->card_num           = $model->crcard_plain_number;   // '4111111111111111';
                $payment->exp_date           = "{$model->crcard_expiration_month}{$model->crcard_expiration_year}"; // '0418';
                
                $payment->description        = "Web Pmt for Account {$model->account_number}";
                $payment->first_name         = $model->crcard_first_name;
                $payment->last_name          = $model->crcard_last_name;
                $payment->company            = $model->company_name;
                $payment->address            = $model->address;
                $payment->city               = $model->city;
                $payment->state              = $model->state_prov;
                $payment->zip                = $model->postal_code;
                $payment->country            = $model->country;
                $payment->phone              = $model->phone;
                $payment->fax                = $model->fax;
                $payment->email              = $model->email;
                $payment->cust_id            = $model->account_number;
                $payment->customer_ip        = Yii::$app->request->userIP;
                $payment->invoice_num        = "INV".date("YmdHis");
                $payment->ship_to_first_name = $model->crcard_first_name;
                $payment->ship_to_last_name  = $model->crcard_last_name;
                $payment->ship_to_company    = $model->company_name;
                $payment->ship_to_address    = $model->address;
                $payment->ship_to_city       = $model->city;;
                $payment->ship_to_state      = $model->state_prov;
                $payment->ship_to_zip        = $model->postal_code;
                $payment->ship_to_country    = $model->country;
                //$payment->tax                = $tax = "0.00";
                //$payment->freight            = $freight = "Freight<|>ground overnight<|>12.95";
                //$payment->duty               = $duty = "Duty1<|>export<|>15.00";
                //$payment->tax_exempt         = $tax_exempt = "FALSE";
                //$payment->po_num             = $po_num = "12";
                
                //Yii::$app->session->setFlash('success', "AuthorizeNetAIM: payment: <pre>".print_r($payment, true)."</pre>");
                
                $response = $payment->authorizeAndCapture();
                if ($response->approved) {
                    //echo "Success! Transaction ID:" . $response->transaction_id;
                    Yii::$app->session->setFlash('success', "Response: {$response->response_reason_text}. Transaction ID: {$response->transaction_id}, Trans. Invoice Num: {$response->invoice_number}");

                    $model->description       = $response->description;
                    $model->payment_date      = date('Y-m-d H:i:s');
                    $model->payment_status    = $response->approved;
                    $model->trans_id          = $response->transaction_id;
                    $model->trans_invoice_num = $response->invoice_number;
                    $model->trans_response    = "[{$response->response_reason_code}] {$response->response_reason_text} ";
                    $model->trans_description = $response->description;
                    $model->ip_address        = Yii::$app->request->userIP;
                    $model->crcard_number     = $response->account_number;
                    
                    // Post payment amount to AccountAging
                    if (($aging = AccountAging::findOne(['account_number' => $model->account_number])) !== null) {
                        $aging->pending_payment = $aging->pending_payment + $model->amount;
                        $aging->save();
                    }
                    
                    //$this->assertTrue($response->approved);
                    //$this->assertEquals("1", $response->response_code);
                    //$this->assertEquals("1", $response->response_subcode);
                    //$this->assertEquals("1", $response->response_reason_code);
                    //$this->assertEquals("This transaction has been approved.", $response->response_reason_text);
                    //$this->assertGreaterThan(1, strlen($response->authorization_code));
                    //$this->assertEquals("Y", $response->avs_response);
                    //$this->assertGreaterThan(1, strlen($response->transaction_id));
                    //$this->assertEquals($invoice_number, $response->invoice_number);
                    //$this->assertEquals($description, $response->description);
                    //$this->assertEquals($amount, $response->amount);
                    //$this->assertEquals("CC", $response->method);
                    //$this->assertEquals("auth_capture", $response->transaction_type);
                    //$this->assertEquals($customer_id, $response->customer_id);
                    //$this->assertEquals($first_name, $response->first_name);
                    //$this->assertEquals($last_name, $response->last_name);
                    //$this->assertEquals($company, $response->company);
                    //$this->assertEquals($address, $response->address);
                    //$this->assertEquals($city, $response->city);
                    //$this->assertEquals($state, $response->state);
                    //$this->assertEquals($zip, $response->zip_code);
                    //$this->assertEquals($country, $response->country);
                    //$this->assertEquals($phone, $response->phone);
                    //$this->assertEquals($fax, $response->fax);
                    //$this->assertEquals($email, $response->email_address);
                    //$this->assertEquals($ship_to_first_name, $response->ship_to_first_name);
                    //$this->assertEquals($ship_to_last_name, $response->ship_to_last_name);
                    //$this->assertEquals($ship_to_company, $response->ship_to_company);
                    //$this->assertEquals($ship_to_address, $response->ship_to_address);
                    //$this->assertEquals($ship_to_city, $response->ship_to_city);
                    //$this->assertEquals($ship_to_state, $response->ship_to_state);
                    //$this->assertEquals($ship_to_zip_code, $response->ship_to_zip_code);
                    //$this->assertEquals($ship_to_country, $response->ship_to_country);
                    //$this->assertEquals($tax, $response->tax);
                    //$this->assertEquals("15.00", $response->duty);
                    //$this->assertEquals("12.95", $response->freight);
                    //$this->assertEquals($tax_exempt, $response->tax_exempt);
                    //$this->assertEquals($po_num, $response->purchase_order_number);
                    //$this->assertGreaterThan(1, strlen($response->md5_hash));
                    //$this->assertEquals("", $response->card_code_response);
                    //$this->assertEquals("2", $response->cavv_response);
                    //$this->assertEquals("XXXX1111", $response->account_number);
                    //$this->assertEquals("Visa", $response->card_type);
                    //$this->assertEquals("", $response->split_tender_id);
                    //$this->assertEquals("", $response->requested_amount);
                    //$this->assertEquals("", $response->balance_on_card);
                    
                    // Send receipt by email
                    if ($model->sendEmail($model->email)) {
                        //Yii::$app->session->setFlash('success', 'Thank you for ordering with us. We will contact you with a confirmation.');
                        Yii::trace('PaymentController::actionCreate(): Sent payment email successfully. ' . 
                            print_r([Yii::$app->request->post(), $response], true), __METHOD__
                        );
                        //return $this->render('/site/message', [
                        return $this->redirect(['site/message', 
                            'type'        => 'info', 
                            'title'       => 'Thank You', 
                            'message'     => 'Payment successfully submitted. Thank you. We will send you a confirmation by email.',
                            'button_name' => 'New Payment', 
                            'button_url'  => 'payment/create', 
                        ]);
                    } else {
                        Yii::$app->session->setFlash('error', 'There was an error sending payment by email.');
                        Yii::trace('PaymentController::actionCreate(): Failed to send payment email. ' . 
                            print_r([Yii::$app->request->post(), $response], true), __METHOD__
                        );
                        return $this->refresh();
                    }
                    
                    // Save payment
                    if ($model->save()) {
                        return $this->redirect(['view', 'id' => $model->id]);
                    } else {
                        Yii::$app->session->setFlash('error', "ERROR: Payment approved, but failed to save payment information (card {$model->crcard_number}).");
                        $this->refresh();
                        return $this->render('create', [
                            'model'  => $model,
                            'amount' => $amount,
                        ]);
                    }
                } else {
                    //echo "ERROR:" . $response->error_message;
                    //Yii::$app->session->setFlash('error', "ERROR: {$response->error_message}");
                    //Yii::$app->session->setFlash('error', "ERROR: response: <pre>".print_r($response, true)."</pre>");
                    Yii::$app->session->setFlash('error', "ERROR: [{$response->response_reason_code}] {$response->response_reason_text} ");
                    return $this->render('create', [
                        'model'  => $model,
                        'amount' => $amount,
                    ]);
                } 
            } else {
                return $this->render('create', [
                    'model'  => $model,
                    'amount' => $amount,
                ]);
            }
        }
    }
    
    /**
     * Updates an existing Payment model.
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
     * Deletes an existing Payment model.
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
     * Finds the Payment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Payment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Payment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    
}
