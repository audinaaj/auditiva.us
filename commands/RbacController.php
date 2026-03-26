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
namespace app\commands;

use Yii;
use yii\console\Controller;
use app\rbac\AuthorRule;
use app\rbac\UserRoleRule;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll(); // remove previous rbac data files under common/rbac/data
        
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
        // Permission to create users
        $permCreateUsers = $auth->createPermission('createUsers');
        $permCreateUsers->description = 'Create Users';
        $auth->add($permCreateUsers);
     
        // Permission to edit user profile
        $permUpdateUserProfile = $auth->createPermission('updateUserProfile');
        $permUpdateUserProfile->description = 'Update User Profile';
        $auth->add($permUpdateUserProfile);
        
        // add "createContent" permission
        $permCreateContent = $auth->createPermission('createContent');
        $permCreateContent->description = 'Create Content';
        $auth->add($permCreateContent);

        // add "updateContent" permission
        $permUpdateContent = $auth->createPermission('updateContent');
        $permUpdateContent->description = 'Update Content';
        $auth->add($permUpdateContent);
        
        //-----------------------------------
        // Roles
        //-----------------------------------
        // add "registered" role with only basic permissions
        $roleRegistered = $auth->createRole('registered');  
        $roleRegistered->ruleName = $ruleUserRole->name;
        $auth->add($roleRegistered); 
        // add permissions as children of 'registered' ...
        //none in this example

        // add "author" role, and give this role the "createContent" permission
        $roleAuthor = $auth->createRole('author');
        $roleAuthor->ruleName = $ruleUserRole->name;
        $auth->add($roleAuthor);
        $auth->addChild($roleAuthor, $roleRegistered);      // 'registered' is a child of 'author'
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
        $auth->addChild($roleAdmin, $roleManager);          // 'manager' is child of 'admin', for consequence 'author' and 'registered' is also child of 'admin'
        // add permissions as children of 'admin'
        $auth->addChild($roleAdmin, $permCreateUsers);     // admin role can create users and also edit users because is parent of editor
        $auth->addChild($roleAdmin, $permUpdateContent);   // admin role can update content
        
        //-----------------------------------
        // Permissions with dependencies in Roles/Rules
        //-----------------------------------
        // add the "updateOwnContent" permission and associate the rule with it.
        $permUpdateOwnContent = $auth->createPermission('updateOwnContent');
        $permUpdateOwnContent->description = 'Update own content';
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
        $auth->assign($roleRegistered, 2 /* user_id */);
        $auth->assign($roleAdmin,  1 /* user_id */);
    }
}