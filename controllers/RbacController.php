<?php
//----------------------------------------------------------------------------------------
// Controller:     /console/controllers/RbacController.php
// Documentation:  http://www.yiiframework.com/doc-2.0/guide-security-authorization.html
// Usage:
//   - Create data directory for RBAC settings files (items.php, assignments.php, rules.php):
//       $ mkdir ../common/rbac/data
//   - Execute once as a console script:
//       $ yii rbac/init
//----------------------------------------------------------------------------------------
namespace console\controllers; 

use Yii;
use yii\console\Controller;
use app\rbac\AuthorRule;
use app\rbac\UserRoleRule;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll(); // remove previous rbac data files under app/rbac/data
        
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
        
        // Permission to view technical manual
        $permViewTechnicalManual= $auth->createPermission('viewTechnicalManual');
        $permViewTechnicalManual->description = 'View Technical Manual';
        $auth->add($permViewTechnicalManual);
        
        // add "createPost" permission
        $permCreatePost = $auth->createPermission('createPost');
        $permCreatePost->description = 'Create a post';
        $auth->add($permCreatePost);

        // add "updatePost" permission
        $permUpdatePost = $auth->createPermission('updatePost');
        $permUpdatePost->description = 'Update post';
        $auth->add($permUpdatePost);
        
        // add "createUser" permission
        $permCreateUsers = $auth->createPermission('createUser');
        $permCreateUsers->description = Yii::t('app', 'Create User');
        $auth->add($permCreateUsers);
     
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

        // add "module" role with 'registered' permissions + tech manual access
        $roleModule = $auth->createRole('module');  
        $roleModule->ruleName = $ruleUserRole->name;
        $auth->add($roleModule);
        $auth->addChild($roleModule, $roleRegistered);      // 'registered' is a child of 'module'
        // add permissions as children of 'module'
        $auth->addChild($roleModule, $permViewTechnicalManual);
        
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
        
        // editor role
        $roleEditor = $auth->createRole('editor');
        $roleEditor->ruleName = $ruleUserRole->name;
        $auth->add($roleEditor);
        $auth->addChild($roleEditor, $roleAuthor);            // 'author' is a child of 'editor'
        // add permissions as children of 'editor'
        $auth->addChild($roleEditor, $permUpdateUserProfile); // 'editor' can edit profiles
        $auth->addChild($roleEditor, $permUpdateContent);     // 'editor' role can update content

        // add "manager" role
        $roleManager = $auth->createRole('manager');
        $roleManager->ruleName = $ruleUserRole->name;
        $auth->add($roleManager);
        $auth->addChild($roleManager, $roleEditor);          // 'editor' is child of 'manager', therefore 'author', 'poweruser', and 'registered' are also children of 'admin'
        // add permissions as children of 'manager'
        $auth->addChild($roleManager, $permCreateUsers);     // manager role can create users and also edit users because is parent of editor
        $auth->addChild($roleManager, $permUpdateContent);   // manager role can update content
        
        // add "admin" role and give this role the "updateContent" permission
        // as well as the permissions of the "author" role
        $roleAdmin = $auth->createRole('admin');
        $roleAdmin->ruleName = $ruleUserRole->name;
        $auth->add($roleAdmin);
        $auth->addChild($roleAdmin, $roleEditor);          // 'manager' is child of 'admin', therefore 'editor', 'author', 'poweruser', and 'registered' are also children of 'admin'
        // add permissions as children of 'admin'
        $auth->addChild($roleAdmin, $permCreateUsers);     // admin role can create users and also edit users because is parent of editor
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
        // $auth->assign($roleRegistered, 2 /* user_id */);
        // $auth->assign($roleAdmin,  1 /* user_id */);
        $auth->assign($roleAdmin,  \app\models\User::findByUsername('admin')->getId());
        $auth->assign($roleAuthor, \app\models\User::findByUsername('demo')->getId());
    }
}