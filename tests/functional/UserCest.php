<?php
class UserCest
{
    public function _before(FunctionalTester $I)
    {
        $tblUser = Yii::$app->db->schema->getRawTableName(app\models\User::tableName());
        
        // Inserts user records to be used
        //$I->haveInDatabase($tblUser, ['username' => 'admin']);
        //$I->haveInDatabase($tblUser, ['username' => 'demo']);
        $I->haveInDatabase($tblUser, [
            'username'      => 'test',
            'email'         => 'jdoe@example.com',
            'phone'         => '407-555-4444',
            'first_name'    => 'John',
            'last_name'     => 'Doe',
            'password_hash' => '$2y$13$GU0atvXcHvtszSoOgW3o/OB1WGSYh244IgAjMVDi16wzb8M0l5paS',
            'auth_key'      => '0d5QBmVsdb_HDRILGZQ_marAMHUMShNJ',
            'access_token'  => '103-token',
            'role'          => 10,
            'status'        => 0,
        ]);
        
        //$model_user_1 = $I->haveRecord('app\models\User', ['username' => 'admin']);
        //$model_user_2 = $I->haveRecord('app\models\User', ['username' => 'demo']);
        
        // Updates user record to be used
        $I->updateInDatabase($tblUser, ['status' => 0], ['username' => 'test']);

        // Verify user records are available
        $I->seeInDatabase($tblUser, ['username' => 'admin']);
        $I->seeInDatabase($tblUser, ['username' => 'demo']);
        
        $model_user_1 = $I->seeRecord('app\models\User', ['username' => 'admin']);
        $model_user_2 = $I->seeRecord('app\models\User', ['username' => 'demo']);
        
        // Get models for use
        //$model_user_1 = $I->grabRecord('app\models\User', ['username' => 'admin']);
        //$model_user_2 = $I->grabRecord('app\models\User', ['username' => 'demo']);

        //$I->amLoggedInAs(\app\models\User::findByUsername('admin'));
        //$I->amOnRoute('user/index');
    }

    public function _after(FunctionalTester $I)
    {
        
    }

    // tests
    public function openUserIndexPage(\FunctionalTester $I)
    {
        $I->amLoggedInAs(\app\models\User::findByUsername('admin'));
        $I->amOnRoute('user/index');
        
        $I->see('Users', 'h1');
        $I->see('admin');  // user
        $I->see('demo');   // user
        
        $I->expectTo('Verify search fields');
        $I->seeElement('input',  ['name' => 'UserSearch[username]']);
        $I->seeElement('input',  ['name' => 'UserSearch[first_name]']);
        $I->seeElement('input',  ['name' => 'UserSearch[last_name]']);
        $I->seeElement('input',  ['name' => 'UserSearch[phone]']);
        $I->seeElement('input',  ['name' => 'UserSearch[email]']);
        $I->seeElement('select', ['name' => 'UserSearch[role]']);
        $I->seeElement('select', ['name' => 'UserSearch[status]']);
        $I->seeElement('input',  ['name' => 'UserSearch[created_at]']);
        $I->seeElement('input',  ['name' => 'UserSearch[last_login]']);
        
        $I->seeInField(['name' => 'UserSearch[username]'], '');
       // $I->fillField(['name' => 'UserSearch[username]'], 'demo');
        
        $I->expectTo('Perform user search');
        
        // Equivalent
        //$I->fillField('input',   ['name' => 'UserSearch[username]'], 'demo');
        //$I->fillField(['name' => 'UserSearch[username]'], 'demo');
        //$I->fillField('UserSearch[username]', 'demo');
        //$I->fillField('#user-username', 'demo');
        //$I->fillField('#myformname input=[UserSearch[username]]', 'demo');
        //$I->fillField('input=[UserSearch[username]]', 'demo');
        //$I->fillField(['id' => 'user-username'], 'demo');
        //$I->fillField('input[id=user-username]', 'demo');
        
        //$I->seeOptionIsSelected('form select[id=user-status]', 'inactive');      // status: inactive
        //$I->seeOptionIsSelected('select[id=user-status]', 'inactive');           // status: inactive
        //$I->seeOptionIsSelected('#user-status', 'inactive');                     // status: inactive
        
        //$I->dontSee('admin');
        
    }
    
    public function addUserFromIndexPage(\FunctionalTester $I)
    {
        $faker = Faker\Factory::create();
        $username = $faker->userName;
        
        $I->amLoggedInAs(\app\models\User::findByUsername('admin'));
        $I->amOnPage(['user/index']);
        
        $I->expectTo('Create new user');
        //$I->seeLink('Create User', ['user/create']);
        $I->seeLink('Create User'); 
        $I->click(['link' => 'Create User']);
        
        $I->seeCurrentUrlMatches('/user(.+)create/');
        $I->see('Create User', 'h1'); 
        $I->fillField(['name' => 'User[username]'], $username);
        $I->fillField(['name' => 'User[password]'], 'testing');
        $I->fillField(['name' => 'User[first_name]'], $faker->firstName);
        $I->fillField(['name' => 'User[last_name]'], $faker->lastName);
        $I->fillField(['name' => 'User[email]'], $faker->email);
        $I->fillField(['name' => 'User[phone]'], $faker->phoneNumber);
        $I->click('Save');  // button
        
        $I->seeCurrentUrlMatches('/user(.+)view/');
        $I->seeLink('Update'); 
        $I->seeLink('Delete'); 
        $I->see($username);   // user listed in index view
    }
    
    public function viewUserFromIndexPage(\FunctionalTester $I)
    {
        $I->amLoggedInAs(\app\models\User::findByUsername('admin'));
        $I->amOnPage(['user/index']);
        
        $I->expectTo('View user record');
        $I->see('test');   // user
        $I->seeLink('test');
        $I->click(['link' => 'test']);
        $I->see('John Doe (test)', 'h1');
    }
    
    public function updateUserPage(\FunctionalTester $I)
    {
        $I->amLoggedInAs(\app\models\User::findByUsername('admin'));
        $I->amOnPage(['user/index']);
        
        $user = \app\models\User::findByUsername('test');
        
        $I->expectTo('Update user record from View page');
        $I->amOnPage(['user/view', 'id' => $user->id]);
        $I->see('John Doe (test)', 'h1');
        $I->seeLink('Update'); 
        $I->seeLink('Delete'); 
        $I->click(['link' => 'Update']);
        $I->see('Update User: John Doe (test)', 'h1');
        $I->seeInField(['name' => 'User[first_name]'], 'John');
        $I->seeInField(['name' => 'User[last_name]'], 'Doe');
        //$I->seeElement('select', ['name' => 'User[role]',   'value' => '10']);    // role: registered
        //$I->seeElement('select', ['name' => 'User[status]', 'value' => '0']);     // status: inactive
        $I->seeElement('select', ['id' => 'user-role']);     // role: registered
        $I->seeElement('select', ['id' => 'user-status']);   // status: inactive
    
        // Equivalent checks
        $I->seeOptionIsSelected('form select[id=user-status]', 'inactive');      // status: inactive
        $I->seeOptionIsSelected('select[id=user-status]', 'inactive');           // status: inactive
        $I->seeOptionIsSelected('#user-status', 'inactive');                     // status: inactive
    
        // Modify data
        $I->selectOption('form select[id=user-status]', 'active');         // status: active
        $I->click('Save');  // button
    
       $I->expectTo('Update user record from Update page');
       $I->amOnPage(['user/update', 'id' => $user->id]);
       $I->see('Update User: John Doe (test)', 'h1');
       $I->see('active');
       $I->click('Save');  // button
    }
    
    public function deleteUserFromIndexPage(\FunctionalTester $I)
    {
        $I->amLoggedInAs(\app\models\User::findByUsername('admin'));
        $I->amOnPage(['user/index']);
        
        $user = \app\models\User::findByUsername('test');
        
        $I->expectTo('Delete user record');
        //$I->amOnPage(['user/delete', 'id' => $user->id]);
        $I->amOnPage(['user/view', 'id' => $user->id]);
        $I->see('John Doe (test)', 'h1');
        $I->seeLink('Update'); 
        $I->seeLink('Delete'); 
        //$I->click(['link' => 'Delete']);  // Delete only accepts POST
        //$I->sendPOST('/user/delete', ['id' => $user->id]);  // requires REST module
        //$I->click('OK');                  // Javascript OK button
        
        // Debug
        //$this->debugSection('Request', $params);
        //$this->client->request($method, $uri, $params);
        //$this->debug('Response Code: ' . $this->client->getStatusCode());
    }
    
    public function activateUser(\FunctionalTester $I)
    {
        //$I->amLoggedInAs(\app\models\User::findByUsername('admin'));
        //$I->amOnPage(['user/index']);
        
        $user = \app\models\User::findByUsername('test');
        
        $I->expectTo('Activate user record');
        
        $I->amOnPage(['user/activate', 'id' => $user->id]);
        $I->see('Missing required parameters: token');
        $I->dontSee('activated successfully');
        
        $I->amOnPage(['user/activate', 'id' => $user->id, 'token' => '12345']);
        $I->see('Invalid token');
        $I->dontSee('activated successfully');
        
        $model = $I->grabRecord('app\models\User', ['username' => 'test']);
        $token = $model->generateActivationToken();
        $I->amOnPage(['user/activate', 'id' => $user->id, 'token' => $token]);
        $I->see('activated successfully');
    }
    
    public function deactivateUser(\FunctionalTester $I)
    {
        //$I->amLoggedInAs(\app\models\User::findByUsername('admin'));
        //$I->amOnPage(['user/index']);
        
        $user = \app\models\User::findByUsername('test');
        
        $I->expectTo('Deactivate user record');
        
        $I->amOnPage(['user/deactivate', 'id' => $user->id]);
        $I->see('Missing required parameters: token');
        $I->dontSee('was already not active');
        
        $I->amOnPage(['user/deactivate', 'id' => $user->id, 'token' => '12345']);
        $I->see('Invalid token');
        $I->dontSee('was already not active');
        
        $model = $I->grabRecord('app\models\User', ['username' => 'test']);
        $token = $model->generateActivationToken();
        $I->amOnPage(['user/deactivate', 'id' => $user->id, 'token' => $token]);
        $I->see('was already not active:  inactive. No action performed.');
        //$I->see('deactivated successfully');
    }
    
    public function banUser(\FunctionalTester $I)
    {
        //$I->amLoggedInAs(\app\models\User::findByUsername('admin'));
        //$I->amOnPage(['user/index']);
        
        $user = \app\models\User::findByUsername('test');
        
        $I->expectTo('Ban user record');
        
        $I->amOnPage(['user/ban', 'id' => $user->id]);
        $I->see('Missing required parameters: token');
        $I->dontSee('banned successfully');
        
        $I->amOnPage(['user/ban', 'id' => $user->id, 'token' => '12345']);
        $I->see('Invalid token');
        $I->dontSee('banned successfully');
        
        $model = $I->grabRecord('app\models\User', ['username' => 'test']);
        $token = $model->generateActivationToken();
        $I->amOnPage(['user/ban', 'id' => $user->id, 'token' => $token]);
        $I->see('banned successfully');
    }
    
    public function signupNewUser(\FunctionalTester $I)
    {
        $faker = Faker\Factory::create();
        $username = $faker->userName;
        
        //$I->amLoggedInAs(\app\models\User::findByUsername('admin'));
        //$I->amOnPage(['user/index']);
        
        $I->expectTo('Sign up new user');
        
        $I->amOnPage(['site/index']);
        //$I->seeLink('Signup', 'user/signup');
        //$I->click(['link' => 'Signup']);
        $I->see('Signup');
        $I->click('Signup');
        
        $I->seeCurrentUrlMatches('/user(.+)signup/');
        $I->see('Signup', 'h1'); 
        $I->fillField(['name' => 'SignupForm[username]'], $username);
        $I->fillField(['name' => 'SignupForm[password]'], 'testing');
        $I->fillField(['name' => 'SignupForm[first_name]'], $faker->firstName);
        $I->fillField(['name' => 'SignupForm[last_name]'], $faker->lastName);
        $I->fillField(['name' => 'SignupForm[email]'], $faker->email);
        $I->fillField(['name' => 'SignupForm[phone]'], $faker->phoneNumber);
        $I->click('Signup', 'button');  // button
        
        //$I->seeCurrentUrlMatches('/site(.+)index/');
        $I->seeCurrentUrlMatches('/(.+)index(.+)/');
        $I->see("Logout ({$username})");   // user
        //$I->see('Thank you for signing up with us');   // user
        $I->dontSee('Sign up as a user to get exclusive access to information.');
        $I->dontSee('Cannot be blank.');
        $I->dontSee('has already been taken.');
        $I->dontSeeCurrentUrlMatches('/user(.+)signup/');
        
        // //$I->see('Signup');
        // $I->dontSee('There was an error sending the email notification to activate your account');
        // 
        // $I->expectTo('Verify Sign up of new user');
        // $I->amLoggedInAs(\app\models\User::findByUsername('admin'));
        // $I->amOnPage(['site/index']);
        // $I->click('User (admin)');
        // $I->click('Logout (admin)');
        // $I->seeCurrentUrlMatches('/site(.+)logout/');
        // $I->see('Method Not Allowed: Method Not Allowed. This URL can only handle the following request methods: POST.');
        // 
         // logout
        \Yii::$app->user->logout();
        $I->amOnPage(['site/index']);
        $I->see('Signup');
        $I->see('Login');
        
    }
    
    public function requestNewPassword(\FunctionalTester $I)
    {
        $I->expectTo('Request new password');
    }
    
    public function setNewPassword(\FunctionalTester $I)
    {
        $I->expectTo('Set new password');
    }
}
