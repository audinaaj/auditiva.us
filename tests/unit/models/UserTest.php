<?php
namespace tests\models;
use app\models\User;

class UserTest extends \Codeception\Test\Unit
{
    public function testFindUserById()
    {
        expect_that($user = User::findIdentity(1));
        expect($user->username)->equals('admin');

        expect_not(User::findIdentity(999));
    }

    public function testFindUserByAccessToken()
    {
        expect_that($user = User::findIdentityByAccessToken('100-token'));
        expect($user->username)->equals('admin');

        expect_not(User::findIdentityByAccessToken('non-existing'));
    }

    public function testFindUserByUsername()
    {
        expect_that($user = User::findByUsername('admin'));
        expect_not(User::findByUsername('not-admin'));
    }

    /**
     * @depends testFindUserByUsername
     */
    public function testValidateUser($user)
    {
        $user = User::findByUsername('admin');
        expect_that($user->validateAuthKey('test100key'));
        expect_not($user->validateAuthKey('test102key'));

        expect_that($user->validatePassword('admin'));
        expect_not($user->validatePassword('123456'));
    }
    
    public function testUserRoles()
    {
        $user = User::findbyUsername('admin');
        expect($user->role)->equals(User::ROLE_ADMIN);
        expect($user->role)->notEquals(User::ROLE_REGISTERED);
        
        $user = User::findbyUsername('demo');
        expect($user->role)->equals(User::ROLE_REGISTERED);
    }
    
    public function testUserStatus()
    {
        $user = User::findbyUsername('admin');
        expect($user->status)->equals(User::STATUS_ACTIVE);
        
        $user = User::findbyUsername('demo');
        expect($user->status)->equals(User::STATUS_ACTIVE);
        
        $user->deactivate();
        expect($user->status)->equals(User::STATUS_INACTIVE);
        
        $user->ban();
        expect($user->status)->equals(User::STATUS_BANNED);
        
        $user->activate();
        expect($user->status)->notEquals(User::STATUS_ACTIVE);  // Inactive still, since it is mandatory to use UI to modify status back to Active.
    }

}
