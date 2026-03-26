<?php

use yii\db\Schema;
use yii\db\Migration;

class m180406_100000_init extends Migration
{
    private $useExtendedUserProfile = false;  // set it to your needs
    
    //public function init()
    //{
    //    $this->db = 'db2';
    //    parent::init();
    //}
    
    // # Run specific migration:
    // $ yii migrate/to m180406_100000_init     # perform migration
    // $ yii migrate/down 1                     # revert the most recently applied migration
    public function up()
    {
        $this->create_user_table();
        if ($this->useExtendedUserProfile) {
            $this->alter_user_table();
        }
    }

    public function down()
    {
        //$this->dropTable('{{%user}}');
        //echo "m180406_100000_init cannot be reverted.\n";
        //return false;
        
        $this->drop_tables();
 
        return true;
    }
 
    public function drop_tables()
    {   
        // Get database connection
        $connection = Yii::$app->db;                  // get connection
        $dbSchema   = $connection->schema;            // or $connection->getSchema();
        $allTables  = $dbSchema->getTableNames();     // returns array of tbl schema's
        
        // Available Tables: must be listed in reverse creation order,
        // and dropping tables with foreign keys first.
        $targetTables = [
            //$this->db->schema->getRawTableName(app\models\Content::tableName()),
            $this->db->schema->getRawTableName(app\models\User::tableName()),
        ];
        
        echo "\nAvailable Tables: \n- ".implode("\n- ", $allTables)."\n";
        echo "\nTarget Tables: \n- ".implode("\n- ", $targetTables)."\n\n";
        
        foreach($targetTables as $curTable) {
            echo "Checking table: {$curTable}\n";
            if (in_array($curTable, $allTables)) {
                //if ($curTable == $this->db->schema->getRawTableName(app\models\Content::tableName())) {
                //    //$this->dropForeignKey('FK_name', $curTable);
                //}
                if ($curTable == $this->db->schema->getRawTableName(app\models\User::tableName())) {
                    //$this->dropForeignKey('FK_name', $curTable);
                }
                
                $this->truncateTable($curTable);   // delete all records
                $this->dropTable($curTable);       // drop table
            }
        }
        
        if ($this->useExtendedUserProfile) {
            // Restore any original table changes
            $this->restore_user_table();
        }
    }
    
    public function create_user_table()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        //CREATE TABLE `user` (
        //    `id`                   INT(11) NOT NULL AUTO_INCREMENT,
        //    `username`             VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
        //    `password_hash`        VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
        //    `password_reset_token` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `auth_key`             VARCHAR(32) NOT NULL COLLATE 'utf8_unicode_ci',
        //    `access_token`         VARCHAR(32) NOT NULL COLLATE 'utf8_unicode_ci',
        //    `first_name`           VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `last_name`            VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `email`                VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
        //    `phone`                VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `address1`             VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `address2`             VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `city`                 VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `state_prov`           VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `postal_code`          VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `country`              VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `company_name`         VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `job_title`            VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `account_number`       VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `receive_newsletter`   TINYINT(1) NOT NULL DEFAULT '1',
        //    `avatar`               VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `role`                 SMALLINT(6) NOT NULL DEFAULT '{app\models\User::ROLE_REGISTERED}',
        //    `status`               SMALLINT(6) NOT NULL DEFAULT '{app\models\User::STATUS_INACTIVE}',
        //    `created_at`           DATETIME NULL DEFAULT NULL,
        //    `updated_at`           DATETIME NULL DEFAULT NULL,
        //    `last_login`           DATETIME NULL DEFAULT NULL,
        //    PRIMARY KEY (`id`),                              
        //)
        //COLLATE='utf8_unicode_ci'
        //ENGINE=InnoDB
        //AUTO_INCREMENT=1;
        
        $tableExists   = true;
        $tableRowCount = 0;
        try {
            // Check if 'user' table exists
            if (Yii::$app->db->getTableSchema('{{%user}}') !== null) {
                if (($rows = Yii::$app->db->createCommand("SELECT * FROM {{%user}} WHERE 1 LIMIT 100")->queryAll()) !== false) {
                    $tableRowCount = count($rows);
                }
            } else {
                $tableExists = false;
            }
            echo "Table {{%user}} has {$tableRowCount} rows.\n";
        } 
        catch(Exception $ex)
        {
            echo 'Caught exception: ',  $ex->getMessage(), "\n";
            $tableExists = false;
            echo "Table {{%user}} does not exist.\n";
        }
        
        if ($tableExists) {
            echo "Table {{%user}} already exists.  Skipping creation.\n";
        } else {
            $this->createTable('{{%user}}', [
                'id'                   => $this->primaryKey(),
                'username'             => $this->string()->notNull(),
                'password_hash'        => $this->string()->notNull(),
                'password_reset_token' => $this->string(),  
                'auth_key'             => $this->string(32)->notNull(),
                'access_token'         => $this->string(32)->notNull(),
                'first_name'           => $this->string(),  
                'last_name'            => $this->string(),  
                'email'                => $this->string()->notNull(),
                'phone'                => $this->string()->notNull(),
                'avatar'               => $this->string(),  
                'role'                 => $this->smallInteger(6)->notNull()->defaultValue(app\models\User::ROLE_REGISTERED),
                'status'               => $this->smallInteger(6)->notNull()->defaultValue(app\models\User::STATUS_INACTIVE),
                'created_at'           => $this->datetime(),
                'updated_at'           => $this->datetime(),
                'last_login'           => $this->datetime(),
            ], $tableOptions);
            $tableExists = true;
        }
        
        if ($tableExists && ($tableRowCount < 1)) {
            // Insert data as a row
            echo "Inserting admin and demo users to table {{%user}}.\n";
            $this->insert('{{%user}}', [
                'username'      => 'admin',
                'password_hash' => Yii::$app->security->generatePasswordHash('admin'),
                //'auth_key'      => Yii::$app->security->generateRandomString(),
                'auth_key'      => 'test100key',  // no random string so we can perform unit testing
                //'access_token'  => md5('100-token'),
                'access_token'  => '100-token',  // no md5 so we can perform unit testing
                'first_name'    => 'System',  
                'last_name'     => 'Administrator', 
                'email'         => 'admin@example.com',
                'phone'         => '',
                'role'          => \app\models\User::ROLE_ADMIN,
                'status'        => \app\models\User::STATUS_ACTIVE,
                'created_at'    => date("Y-m-d H:i:s"),
                'updated_at'    => date("Y-m-d H:i:s"),
                //'last_login'    => $this->datetime(),
            ]);
            
            // Generate RBAC assignments.php file
    $filecontent = "<?php
return [
];";  // empty file
            $filename = Yii::getAlias('@app') ."/rbac/data/assignments.php";
            file_put_contents($filename, $filecontent);
        }
    }
    
    private function alter_user_table()
    {
        $this->addColumn('{{%user}}', 'address1', $this->string());
        $this->addColumn('{{%user}}', 'address2', $this->string());
        $this->addColumn('{{%user}}', 'city', $this->string());
        $this->addColumn('{{%user}}', 'state_prov', $this->string());
        $this->addColumn('{{%user}}', 'postal_code', $this->string());
        $this->addColumn('{{%user}}', 'country', $this->string());
        //$this->addColumn('{{%user}}', 'organization_name', $this->string());
        //$this->addColumn('{{%user}}', 'school_name', $this->string());
        $this->addColumn('{{%user}}', 'company_name', $this->string());
        $this->addColumn('{{%user}}', 'job_title', $this->string());
        $this->addColumn('{{%user}}', 'receive_newsletter', $this->tinyInteger()->notNull()->defaultValue(1));
    }
 
    private function restore_user_table()
    {
        $this->dropColumn('{{%user}}', 'address1');
        $this->dropColumn('{{%user}}', 'address2');
        $this->dropColumn('{{%user}}', 'city');
        $this->dropColumn('{{%user}}', 'state_prov');
        $this->dropColumn('{{%user}}', 'postal_code');
        $this->dropColumn('{{%user}}', 'country');
        $this->dropColumn('{{%user}}', 'company_name');
        $this->dropColumn('{{%user}}', 'job_title');
        $this->dropColumn('{{%user}}', 'receive_newsletter');
    }
}
