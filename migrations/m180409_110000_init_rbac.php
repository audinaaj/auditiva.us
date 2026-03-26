<?php
use yii\db\Migration;

class m180409_110000_init_rbac extends Migration
{
    // # Run specific migration:
    // $ yii migrate/to m180409_110000_init_rbac     # perform migration
    // $ yii migrate/down 1                          # revert the most recently applied migration
    public function up()
    {
        //$this->addDefaultPermissions();
        $this->addExtendedPermissions();
    }
    
    public function down()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll();  // remove previous rbac data files under [app]/rbac/data
    }
    
    /*
     * Default Permissions
     */
    public function addDefaultPermissions()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll(); // remove previous rbac data files under [app]/rbac/data

        //-----------------
        // Permissions
        //-----------------
        // add "createPost" permission
        $createPost = $auth->createPermission('createPost');
        $createPost->description = Yii::t('app', 'Create a post');
        $auth->add($createPost);

        // add "updatePost" permission
        $updatePost = $auth->createPermission('updatePost');
        $updatePost->description = Yii::t('app', 'Update post');
        $auth->add($updatePost);

        //-----------------
        // Roles
        //-----------------
        // add "author" role and give this role the "createPost" permission
        $roleAuthor = $auth->createRole('author');
        $auth->add($roleAuthor);
        $auth->addChild($roleAuthor, $createPost);

        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        $roleAdmin = $auth->createRole('admin');
        $auth->add($roleAdmin);
        $auth->addChild($roleAdmin, $updatePost);
        $auth->addChild($roleAdmin, $roleAuthor);

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        //$auth->assign($roleAdmin,  1 /* user_id */);
        //$auth->assign($roleAuthor, 2 /* user_id */);
        $auth->assign($roleAdmin,  \app\models\User::findByUsername('admin')->getId());
        $auth->assign($roleAuthor, \app\models\User::findByUsername('demo')->getId());
    }
    
    /*
     * Extended Permissions (include default permissions)
     */
    public function addExtendedPermissions()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll(); // remove previous rbac data files under [app]/rbac/data
        
        //-----------------------------------
        // Rules
        //-----------------------------------
        // Add rules 
        $ruleUserRole = new \app\rbac\UserRoleRule(); 
        $auth->add($ruleUserRole);

        $ruleAuthor = new \app\rbac\AuthorRule();
        $auth->add($ruleAuthor);

        //-----------------------------------
        // Permissions
        //-----------------------------------
        // add "createPost" permission
        $permCreatePost = $auth->createPermission('createPost');
        $permCreatePost->description = Yii::t('app', 'Create a post');
        $auth->add($permCreatePost);

        // add "updatePost" permission
        $permUpdatePost = $auth->createPermission('updatePost');
        $permUpdatePost->description = Yii::t('app', 'Update post');
        $auth->add($permUpdatePost);
        
        // add "createUser" permission
        $permCreateUser = $auth->createPermission('createUser');
        $permCreateUser->description = Yii::t('app', 'Create User');
        $auth->add($permCreateUser);
     
        // add "updateUserProfile" permission
        $permUpdateUserProfile = $auth->createPermission('updateUserProfile');
        $permUpdateUserProfile->description = Yii::t('app', 'Update User Profile');
        $auth->add($permUpdateUserProfile);
        
        // add "createContent" permission
        $permCreateContent = $auth->createPermission('createContent');
        $permCreateContent->description = Yii::t('app', 'Create Content');
        $auth->add($permCreateContent);

        // add "updateContent" permission
        $permUpdateContent = $auth->createPermission('updateContent');
        $permUpdateContent->description = Yii::t('app', 'Update Content');
        $auth->add($permUpdateContent);
        
        //-----------------------------------
        // Roles
        //-----------------------------------
        // add "registered" role with only basic permissions
        $roleRegistered = $auth->createRole('registered');  
        $roleRegistered->ruleName = $ruleUserRole->name;
        $auth->add($roleRegistered); 
        // add permissions as children of 'registered'
        //none in this example

        // add "poweruser" role, and give this role the "createContent" permission
        $rolePowerUser = $auth->createRole('poweruser');
        $rolePowerUser->ruleName = $ruleUserRole->name;
        $auth->add($rolePowerUser);
        $auth->addChild($rolePowerUser, $roleRegistered);      // 'register' is a child of 'poweruser'
        // add permissions as children of 'poweruser'
        //none in this example
        
        // add "author" role, and give this role the "createContent" permission
        $roleAuthor = $auth->createRole('author');
        $roleAuthor->ruleName = $ruleUserRole->name;
        $auth->add($roleAuthor);
        $auth->addChild($roleAuthor, $rolePowerUser);         // 'poweruser' is a child of 'author'
        // add permissions as children of 'author'
        $auth->addChild($roleAuthor, $permCreateContent);
        $auth->addChild($roleAuthor, $permCreatePost);

        // editor role
        $roleEditor = $auth->createRole('editor');
        $roleEditor->ruleName = $ruleUserRole->name;
        $auth->add($roleEditor);
        $auth->addChild($roleEditor, $roleAuthor);            // 'author' is a child of 'editor'
        // add permissions as children of 'editor'
        $auth->addChild($roleEditor, $permUpdateUserProfile); // 'editor' can edit profiles
        $auth->addChild($roleEditor, $permUpdateContent);     // 'editor' role can update content
        
        // manager role
        $roleManager = $auth->createRole('manager');
        $roleManager->ruleName = $ruleUserRole->name;
        $auth->add($roleManager);
        $auth->addChild($roleManager, $roleEditor);            // 'editor' is a child of 'manager'
        // add permissions as children of 'manager'
        $auth->addChild($roleManager, $permUpdateUserProfile); // 'manager' can edit profiles
        $auth->addChild($roleManager, $permUpdateContent);     // 'manager' role can update content

        // add "admin" role and give this role the "updateContent" permission
        // as well as the permissions of the "author" role
        $roleAdmin = $auth->createRole('admin');
        $roleAdmin->ruleName = $ruleUserRole->name;
        $auth->add($roleAdmin);
        $auth->addChild($roleAdmin, $roleManager);         // 'manager' is child of 'admin', therefore 'editor', 'author', 'poweruser', and 'registered' are also children of 'admin'
        // add permissions as children of 'admin'
        $auth->addChild($roleAdmin, $permCreateUser);      // admin role can create users and also edit users because is parent of editor and manager
        $auth->addChild($roleAdmin, $permUpdateContent);   // admin role can update content
        
        //-----------------------------------
        // Permissions with dependencies in Roles/Rules
        //-----------------------------------
        // add the "updateOwnContent" permission and associate the rule with it.
        $permUpdateOwnContent = $auth->createPermission('updateOwnContent');
        $permUpdateOwnContent->description = Yii::t('app', 'Update own content');
        $permUpdateOwnContent->ruleName = $ruleAuthor->name;
        // add permissions
        $auth->add($permUpdateOwnContent);
        $auth->addChild($permUpdateOwnContent, $permUpdateContent);  // "updateOwnContent" will be used from "updateContent"
        $auth->addChild($roleAuthor, $permUpdateOwnContent);         // allow "author" to update their own contents

        //-----------------------------------
        // Roles assignment to users
        //-----------------------------------
        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        //$auth->assign($roleAdmin,  1 /* user_id */);
        //$auth->assign($roleAuthor, 2 /* user_id */);
        $auth->assign($roleAdmin,  \app\models\User::findByUsername('admin')->getId());
    }
}