<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Html;

use app\models\User;
use app\models\UserSearch;
use app\models\SignupForm;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
                    //[  // Guest users: No access to user management
                    //   'allow' => false,
                    //   'actions' => [],
                    //   'roles' => ['?'],  // ? = Guest user
                    //],
                    [  // Guest users: No access to user management, except these
                       'allow'   => true,
                       'actions' => [
                            'signup',                                     // Required when using express signup (no approval required)
                            'activate', 'deactivate', 'ban',              // Required when using approvals through email
                            'request-password-reset', 'reset-password',   // Required always
                        ],
                       'roles'   => ['?'],  // ? = Guest user
                    ],
                    [  // Authenticated users: can only view or update their own profile
                        'allow'   => true,
                        'actions' => ['view', 'update'],
                        'roles'   => ['@'],  // @ = Authenticated users
                    ],
                    [  // Admin users: Access all user management
                        'allow'   => true,
                        'actions' => [
                            'index', 'admin-index', 'create', 'view', 'update', 'delete', 'password',
                            'activate', 'deactivate', 'ban',
                            'request-password-reset', 'reset-password',
                        ],
                        'matchCallback' => function ($rule, $action) {
                            return ((!Yii::$app->user->isGuest) && (Yii::$app->user->identity->isAdmin()));
                        }
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->actionAdminIndex();
    }
    
    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionAdminIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        Yii::$app->response->headers->add('Content-Type', 'text/html');

        return $this->render('admin/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        // Only allow to view your own user profile
        if ((Yii::$app->user->getId() == $id) || User::isCurrentUserAdmin() ) {
            return $this->render('admin/view', [
                'model' => $this->findModel($id),
            ]);
        } else {
            Yii::$app->session->setFlash('error', 
                Yii::t('app', "<strong>{username}</strong> does not have the rights to view user ID {id}'s profile, but only view your own profile.", 
                    ['username' => Yii::$app->user->identity->username, 'id' => $id]
                )
            );
            return $this->redirect(['view', 'id' => Yii::$app->user->getId()]);
        }
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        //if ($model->load(Yii::$app->request->post()) && $model->save()) {
        if ($model->load(Yii::$app->request->post())) {
            if($model->save()) {
                 return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', "Something went wrong when saving. User record not saved."));
            }
        }

        return $this->render('admin/create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        // Only allow to update your own user profile
        if ((Yii::$app->user->getId() == $id) || User::isCurrentUserAdmin() ) {
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    try {
                        // Save updated role
                        $auth = Yii::$app->authManager;
                        $role = $auth->getRole(User::getRoleLabel($model->role));  // default role
                        $auth->revokeAll($model->getId());                         // revoke all roles for this user
                        $auth->assign($role, $model->getId());                     // only assign new role
                    } catch (\Exception $ex) {
                        if (!empty(substr($ex->getMessage(), 0, strlen('Authorization item')))) {
                            // Ignore exception if this is "Authorization item 'rolename' has already been assigned to user 'userid'"
                            // Eg: "Authorization item 'registered' has already been assigned to user '3'"
                        } else {
                            throw $ex;  // rethrow exception
                        }
                    }
                    
                    Yii::$app->session->setFlash('success', Yii::t('app', "User profile for <strong>{username}</strong> was updated successfully.", ['username' => $model->username]));
                } else {
                    Yii::$app->session->setFlash('error', Yii::t('app', "Failed to update profile for user ID {id}.", ['id' => $id]));
                }
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('admin/update', [
                    'model' => $model,
                ]);
            }
        } else {
            Yii::$app->session->setFlash('error', Yii::t('app', "<strong>{username}</strong> does not have the rights to update user ID {id}'s profile, but only update your own profile.", 
                    ['username' => Yii::$app->user->identity->username, 'id' => $id]
                )
            );
            return $this->redirect(['view', 'id' => Yii::$app->user->getId()]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        // Only allow to delete your own user profile
        if ((Yii::$app->user->getId() == $id) || User::isCurrentUserAdmin() ) {
            $this->findModel($id)->delete();
            return $this->redirect(['admin-index']);
        } else {
            Yii::$app->session->setFlash('error', 
                Yii::t('app', "User <strong>{username}</strong> does not have rights to delete user {id}.", [
                    'username' => Yii::$app->user->identity->username,
                    'id' => id,
                ])
            );
            return $this->redirect(['site/index']); // site index (Home)
        }
    
    }
    
    /**
     * Activate an existing User model.
     * If activation is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $token
     * @return mixed
     */
    public function actionActivate($id, $token)
    {
        $model = $this->findModel($id);
        
        // Validate activation token.  Use validatePassword() only to generate a hash and compare it to token, not actual password.
        //if (Yii::$app->security->validatePassword($model->id . $model->email, $token)) {  
        if ($model->isValidActivationToken($token)) {  
            if ($model->status == User::STATUS_INACTIVE) {
                // Activate only inactive accounts
                if (($model->activate() == User::STATUS_ACTIVE) && $model->save()) {
                    // User account was approved and activated. Send email notification to user.
                    $emailBody = Yii::t('app', "Hello {firstname}", ['{firstname}' => Html::encode($model->first_name)]) . ", \n";
                    $emailBody .= "\n";
                    $emailBody .= Yii::t('app', "You recently signed up for an website account at {company_name}", ['company_name' => Yii::$app->params['companyName']]) . "\n";
                    $emailBody .= Yii::t('app', "Your account is active now. For your records, your username is {username}", ['username' => Html::encode($model->username)]) . "\n";
                    $emailBody .= "\n";
                    $emailBody .= Yii::t('app', "Do you want visit our website?") . ' ' . Yii::t('app', 'Click on the link below') . ": \n";
                    $emailBody .= "- [ " . Html::a('Website', ['site/index']) . " ]\n";

                    $useHtmlTemplate = true;
                    if (!empty($useHtmlTemplate) && $useHtmlTemplate) {
                        Yii::$app->mailer->compose('signupActivationApproved', ['user' => $model])  // html template
                            ->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->params['companyName']])
                            ->setTo($model->email)
                            ->setBcc([
                                Yii::$app->params['adminEmail'] =>  Yii::t('app', '{companyName} Support', ['companyName' => Yii::$app->params['companyNameShort']]), 
                                Yii::$app->params['debugEmail'] => Yii::t('app', 'Debug Email')
                            ])
                            ->setSubject(Yii::t('app', 'Website user was activated'))
                            ->send();
                    } else {
                        Yii::$app->mailer->compose()    // plain text template
                            ->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->params['companyName']])
                            ->setTo($model->email)
                            ->setBcc([
                                Yii::$app->params['adminEmail'] => Yii::t('app', '{companyName} Support', ['companyName' => Yii::$app->params['companyNameShort']]), 
                                Yii::$app->params['debugEmail'] => Yii::t('app', 'Debug Email')
                            ])
                            ->setSubject(Yii::t('app', 'Website user was activated'))
                            ->setTextBody($emailBody)
                            ->send();
                    }
                    Yii::$app->session->setFlash('success', Yii::t('app', "User <strong>{username}</strong> was activated successfully.", ['username' => $model->username]));
                } else {
                    Yii::$app->session->setFlash('error', Yii::t('app', "User ID {id} activation failed.  Manage user from admin dashboard instead.", ['id' => $id]));
                }
            } else {
                Yii::$app->session->setFlash('success', Yii::t('app', "User ID {id} current status is {status}. No action performed.", ['id' => $id, 'status' => User::getStatusLabel($model->status)]));
            }
        } else {
            Yii::$app->session->setFlash('error', Yii::t('app', "Invalid token. User ID {id} activation failed.", ['id' => $id]));
        }
    
        return $this->redirect(['site/index']); // Redirect to Home
    }
    
    /**
     * Deactivate an existing User model.
     * If deactivation is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $token
     * @return mixed
     */
    public function actionDeactivate($id, $token)
    {
        $model = $this->findModel($id);
        
        // Validate activation token.  Use validatePassword() only to generate a hash and compare it to token, not actual password.
        //if (Yii::$app->security->validatePassword($model->id . $model->email, $token)) {  
        if ($model->isValidActivationToken($token)) {  
            if ($model->status == User::STATUS_ACTIVE) {
                // Deactivate only active accounts
                if (($model->deactivate() == User::STATUS_INACTIVE) && $model->save()) {
                    // User account was deactivated. 
                    Yii::$app->session->setFlash('success', Yii::t('app', "User <strong>{username}</strong> was deactivated successfully.", ['username' => $model->username]));
                } else {
                    Yii::$app->session->setFlash('error', Yii::t('app', "User ID {id} deactivation failed.  Manage user from admin dashboard instead.", ['id' => $id]));
                }
            } else {
                Yii::$app->session->setFlash('success', Yii::t('app', "User ID {id} was already not active: {status}. No action performed.", ['id' => $id, 'status' => User::getStatusLabel($model->status)]));
            }
        } else {
            Yii::$app->session->setFlash('error', Yii::t('app', "Invalid token. User ID {id} deactivation failed.", ['id' => $id]));
        }
    
        return $this->redirect(['site/index']); // Redirect to Home
    }
    
    /**
     * Ban an existing User model.
     * If banning is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $token
     * @return mixed
     */
    public function actionBan($id, $token)
    {
        $model = $this->findModel($id);
        
        // Validate activation token.  Use validatePassword() only to generate a hash and compare it to token, not actual password.
        //if (Yii::$app->security->validatePassword($model->id . $model->email, $token)) {  
        if ($model->isValidActivationToken($token)) {  
            // Ban any active account
            if ($model->ban() && $model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('app', "User <strong>{username}</strong> was banned successfully. NOTE: Now you can only manage this user from the admin dashboard.", ['username' => $model->username]));
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', "User ID {id} banning failed.  Manage user from website's admin dashboard instead.", ['id' => $id]));
            }
        } else {
            Yii::$app->session->setFlash('error', Yii::t('app', "Invalid token. User ID {id} banning failed.", ['id' => $id]));
        }
    
        return $this->redirect(['site/index']); // Redirect to Home
    }
    
    /*
     * Generates an encrypted password.  It does not assign it to any user.
     * return $password Encrypted password
     */
    public function actionPassword()
    {
        $encrypted_password = '';
        $model = new \app\models\PasswordForm();
        if ($model->load(Yii::$app->request->post()) && $model->encrypt()) {
            Yii::$app->session->setFlash(Yii::t('app', 'Password encrypted'));
            $encrypted_password = $model->encrypt();
        }
 
        return $this->render('admin/password', [
            'model' => $model,
            'encrypted_password'  => $encrypted_password,
        ]);
    }
    
    /**
     * Displays signup page.
     *
     * @return string
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->params['isSignupApprovalRequired'] == false) {
                    // Successful Signup will Login automatically
                    if (Yii::$app->getUser()->login($user)) {
                        return $this->goHome();
                    }
                } else {
                    // Successful Signup cannot Login automatically. Must wait approval.
                    // Send email to request approval.
                    $isEmailSent = false;
                    if (!empty($user)) {
                        //$activationToken = Yii::$app->security->generatePasswordHash($user->id . $user->email);
                        $activationToken = $user->generateActivationToken();
                        
                        $useHtmlTemplate = true;
                        if (!empty($useHtmlTemplate) && $useHtmlTemplate) {
                            $isEmailSent = Yii::$app->mailer->compose('signupActivationRequest', ['user' => $user, 'token' => $activationToken])  // html template
                                ->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->params['companyName']])
                                ->setTo(Yii::$app->params['adminEmail'])
                                ->setBcc([Yii::$app->params['debugEmail'] => 'Debug Email'])
                                ->setSubject(Yii::t('app', 'New website user') . ' ('. Yii::t('app', 'approval request') . ')')
                                ->send();
                        } else {
                            $emailBody = Yii::t('app', "Details for New User") . ": \n"; // . print_r($user, true);
                            $emailBody .= Yii::t('app', "Username") . ": {$user->username}\n";
                            $emailBody .= Yii::t('app', "Name") . ": {$user->first_name} {$user->last_name}\n";
                            $emailBody .= Yii::t('app', "Email") . ": {$user->email}\n";
                            $emailBody .= Yii::t('app', "Phone") . ": {$user->phone}\n";
                            //$emailBody .= Yii::t('app', "Address") . ": {$user->address1}, {$user->address2}\n";
                            //$emailBody .= Yii::t('app', "City") . ": {$user->city}\n";
                            //$emailBody .= Yii::t('app', "State / Province") . ": {$user->state_prov}\n";
                            //$emailBody .= Yii::t('app', "ZIP / Postal Code") . ": {$user->postal_code}\n";
                            //$emailBody .= Yii::t('app', "Country") . ": {$user->country}\n";
                            //$emailBody .= Yii::t('app', "Company") . ": {$user->company_name}\n";
                            //$emailBody .= Yii::t('app', "Job Title") . ": {$user->job_title}\n";
                            //$emailBody .= Yii::t('app', "Acount Number") . ": {$user->account_number}\n";
                            //$emailBody .= "Receive Newsletters? {$user->receive_newsletter}\n";
                            $emailBody .= "\n";
                            $emailBody .= Yii::t('app', "Activate User Account?") . ' ' . Yii::t('app', 'Click on the link to activate and notify user') . ": \n";
                            //$emailBody .= Url::to(['user/activate', 'id' => $user->id, 'token' => $activationToken], true);
                            
                            $activateLink   = Yii::$app->urlManager->createAbsoluteUrl(['user/activate',   'id' => $user->id, 'token' => $activationToken]);
                            $deactivateLink = Yii::$app->urlManager->createAbsoluteUrl(['user/deactivate', 'id' => $user->id, 'token' => $activationToken]);
                            $banLink        = Yii::$app->urlManager->createAbsoluteUrl(['user/ban', 'id' => $user->id, 'token' => $activationToken]);
                            $emailBody .= "[" . 
                                Html::a(Yii::t('app', 'Activate & Notify Now'), $activateLink). " ][ " . 
                                Html::a(Yii::t('app', 'Deactivate'), $deactivateLink) . " ][ " . 
                                Html::a(Yii::t('app', 'Ban'), $banLink) . " ]";

                            $isEmailSent = Yii::$app->mailer->compose()    // plain text template
                                ->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->params['companyName']])
                                ->setTo(Yii::$app->params['adminEmail'])
                                ->setBcc([Yii::$app->params['debugEmail'] => 'Debug Email'])
                                ->setSubject(Yii::t('app', 'New website user') . ' ('. Yii::t('app', 'approval request') . ')')
                                ->setTextBody($emailBody)
                                ->send();
                        }
                    }
                    
                    if ($isEmailSent) {
                        Yii::$app->session->setFlash('success', Yii::t('app', 'Thank you for signing up with us. We will activate your account within 48 hrs.'));
                    } else {
                        Yii::$app->session->setFlash('error', Yii::t('app', 'There was an error sending the email notification to activate your account.  Please, contact support.'));
                    }
                }
                return $this->goHome();
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Request to reset password.
     *
     * @return string
     */
    public function actionRequestPasswordReset()
    {
        $model = new \app\models\PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Check your email for further instructions.'));

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Sorry, we are unable to reset password for email provided.') .
                    ( YII_ENV_TEST ? '<pre><p>' . print_r($model, true) . "\nERRORS: \n" . print_r($model->getErrors(), true) . '</pre>' : '' )
                );
            }
        }

        return $this->render('request-password-reset', [
            'model' => $model,
        ]);
    }

    /**
     * Reset password with the specified token.
     *
     * @return string
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new \app\models\ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('app', 'New password was saved.'));

            return $this->goHome();
        }

        return $this->render('reset-password', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
