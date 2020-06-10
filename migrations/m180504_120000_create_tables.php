<?php

use yii\db\Schema;
use yii\db\Migration;

class m180504_120000_create_tables extends Migration
{
    //public function init()
    //{
    //    $this->db = 'db2';
    //    parent::init();
    //}
    
    // # Run specific migration:
    // $ yii migrate/to m180504_120000_create_tables     # perform migration
    // $ yii migrate/down 1                              # revert the most recently applied migration
    public function up()
    {
        $this->createTableContentCategory();
        $this->createTableContentType();
        $this->createTableContent();
        $this->createTableDistributor();
        $this->createTablePayment();
        $this->createTableSpamFilter();
        $this->createTableTestimonial();
        $this->createTableAppSetting();
    }

    public function down()
    {
        //$this->dropTable('{{%user}}');
        //echo "m180504_120000_create_tables cannot be reverted.\n";
        //return false;
        
        // Get database connection
        $connection = Yii::$app->db;                  // get connection
        $dbSchema   = $connection->schema;            // or $connection->getSchema();
        $allTables  = $dbSchema->getTableNames();     // returns array of tbl schema's
        
        // Available Tables: must be listed in reverse creation order.
        // Tables with foreign keys must go last.
        $targetTables = [
            $this->db->schema->getRawTableName(app\models\AppSetting::tableName()),
            $this->db->schema->getRawTableName(app\models\Testimonial::tableName()),
            $this->db->schema->getRawTableName(app\models\SpamFilter::tableName()),
            $this->db->schema->getRawTableName(app\models\Payment::tableName()),
            $this->db->schema->getRawTableName(app\models\Distributor::tableName()),
            $this->db->schema->getRawTableName(app\models\Content::tableName()),
            $this->db->schema->getRawTableName(app\models\ContentCategory::tableName()),
            $this->db->schema->getRawTableName(app\models\ContentType::tableName()),
        ];
        
        echo "\nAvailable Tables: \n- ".implode("\n- ", $allTables)."\n";
        echo "\nTarget Tables: \n- ".implode("\n- ", $allTables)."\n\n";
        
        foreach($targetTables as $curTable) {
            echo "Checking table: {$curTable}\n";
            if (in_array($curTable, $allTables)) {
                if ($curTable == $this->db->schema->getRawTableName(app\models\Content::tableName())) {
                    $this->dropForeignKey('FK_content_category_id', $curTable);
                    $this->dropForeignKey('FK_content_content_type_id', $curTable);
                }
                if ($curTable == $this->db->schema->getRawTableName(app\models\ContentCategory::tableName())) {
                    //$this->dropForeignKey('FK_name', $curTable);
                }
                if ($curTable == $this->db->schema->getRawTableName(app\models\ContentType::tableName())) {
                    //$this->dropForeignKey('FK_name', $curTable);
                }
                if ($curTable == $this->db->schema->getRawTableName(app\models\Distributor::tableName())) {
                    //$this->dropForeignKey('FK_name', $curTable);
                }
                if ($curTable == $this->db->schema->getRawTableName(app\models\Payment::tableName())) {
                    //$this->dropForeignKey('FK_name', $curTable);
                }
                if ($curTable == $this->db->schema->getRawTableName(app\models\SpamFilter::tableName())) {
                    //$this->dropForeignKey('FK_name', $curTable);
                }
                
                $this->truncateTable($curTable);   // delete all records
                $this->dropTable($curTable);       // drop table
            }
        }
    }
    
    public function createTableContentCategory()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        //CREATE TABLE `content_category` (
        //    `id`          INT(11) NOT NULL AUTO_INCREMENT,
        //    `title`       VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
        //    `alias`       VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
        //    `intro_text`  MEDIUMTEXT NULL COLLATE 'utf8_unicode_ci',
        //    `image`       VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `image_float` VARCHAR(255) NULL DEFAULT 'none' COLLATE 'utf8_unicode_ci',
        //    `show_title`  INT(1) NOT NULL DEFAULT '1',
        //    `show_intro`  INT(1) NOT NULL DEFAULT '1',
        //    `show_image`  INT(1) NOT NULL DEFAULT '1',
        //    `ordering`    INT(11) NOT NULL DEFAULT '0',
        //    `published`   SMALLINT(1) NOT NULL DEFAULT '1',
        //    `created_by`  INT(11) NOT NULL,
        //    `created_at`  DATETIME NOT NULL,
        //    `updated_by`  INT(11) NOT NULL,
        //    `updated_at`  DATETIME NOT NULL,
        //    PRIMARY KEY (`id`),
        //)
        //COLLATE='utf8_unicode_ci'
        //ENGINE=InnoDB
        //AUTO_INCREMENT=1;
        
        $this->createTable('{{%content_category}}', [
            'id'          => $this->primaryKey(),
            'title'       => $this->string(),
            'alias'       => $this->string()->notNull(),
            'intro_text'  => "MEDIUMTEXT",
            'image'       => $this->string(),
            'image_float' => $this->string()->defaultValue('none'),
            'show_title'  => $this->tinyInteger()->notNull(1)->defaultValue('1'),
            'show_intro'  => $this->tinyInteger()->notNull(1)->defaultValue('1'),
            'show_image'  => $this->tinyInteger()->notNull(1)->defaultValue('1'),
            'ordering'    => $this->integer()->notNull()->defaultValue('0'),
            'published'   => $this->tinyInteger()->notNull(1)->defaultValue('1'),
            'created_at'  => $this->datetime(),
            'updated_at'  => $this->datetime(),
            'created_by'  => $this->integer()->notNull(),
            'updated_by'  => $this->integer()->notNull(),
        ], $tableOptions);
        
        // table name, column names, column values
        $db = Yii::$app->getDb();
        $db->createCommand()->batchInsert('{{%content_category}}', 
            [
                'id', 'title', 'alias', 'intro_text', 'image', 'image_float', 
                'show_title', 'show_intro', 'show_image', 'ordering', 'published', 
                'created_at', 'updated_at', 'created_by', 'updated_by',
            ],
            [
                [ 1, "Uncategorized", "uncategorized", "", "", "left", 1, 1, 0, 0, 1, 0, "2015-01-05 18:08:23", 1, "2015-02-12 10:15:34", ], 
                [ 2, "Home", "home", "", "", "left", 1, 1, 1, 1, 1, 0, "2015-01-06 15:15:10", 0, "2015-01-06 15:15:10", ], 
                [ 3, "About", "about", "", "", "left", 1, 1, 1, 2, 1, 0, "2015-01-06 15:15:24", 0, "2015-01-06 15:15:24", ], 
                [ 4, "News", "news", "", "", "left", 1, 1, 1, 3, 1, 0, "2015-01-06 15:15:58", 0, "2015-01-06 17:38:15", ], 
                [ 5, "Products", "products", "", "", "left", 1, 1, 1, 4, 1, 0, "2015-01-06 17:39:44", 0, "2015-01-06 17:39:44", ], 
                [ 6, "Professionals", "professionals", "", "", "left", 1, 1, 1, 5, 1, 0, "2015-01-06 17:40:15", 0, "2015-01-06 17:40:15", ], 
                [ 7, "Consumers", "consumers", "", "", "left", 1, 1, 1, 6, 1, 0, "2015-01-06 17:40:30", 0, "2015-01-06 17:40:30", ], 
                [ 8, "Product Styles", "product-styles", "", "", "left", 1, 1, 1, 0, 1, 0, "2015-01-22 18:04:31", 0, "2015-01-22 18:04:31", ], 
                [ 9, "Water Resistance", "product-water-resistance", "", "", "left", 1, 1, 1, 0, 1, 1, "2015-10-28 14:19:19", 1, "2015-10-28 14:19:19", ],
            ]
        )->execute();
    }
    
    public function createTableContentType()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        //CREATE TABLE `content_type` (
        //    `id`          INT(11) NOT NULL AUTO_INCREMENT,
        //    `title`       VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
        //    `alias`       VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
        //    `published`   SMALLINT(1) NOT NULL DEFAULT '1',
        //    PRIMARY KEY (`id`),
        //)
        //COLLATE='utf8_unicode_ci'
        //ENGINE=InnoDB
        //AUTO_INCREMENT=1;
        
        $this->createTable('{{%content_type}}', [
            'id'          => $this->primaryKey(),
            'title'       => $this->string(),
            'alias'       => $this->string()->notNull(),
            'published'   => $this->tinyInteger()->notNull(1)->defaultValue('1'),
        ], $tableOptions);
        
        // table name, column names, column values
        $db = Yii::$app->getDb();
        $db->createCommand()->batchInsert('{{%content_type}}', 
            ['id', 'title', 'alias', 'published'],
            [
                [ 1, "Article",            "article",   1, ], 
                [ 2, "Weblink",            "weblink",   1, ], 
                [ 3, "Contact",            "contact",   1, ], 
                [ 4, "News Feed",          "news-feed", 1, ], 
                [ 5, "Banner",             "banner",    1, ], 
                [ 6, "User Notes",         "user-notes",1, ], 
                [ 7, "Carousel",           "carousel",  1, ], 
                [ 8, "Message of the Day", "motd",      1, ], 
            ]
        )->execute();

    }
    
    public function createTableContent()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        //CREATE TABLE `content` (
        //    `id`                INT(11) NOT NULL AUTO_INCREMENT,
        //    `title`             VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
        //    `category_id`       INT(11) NOT NULL,
        //    `tags`              VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
        //    `intro_text`        MEDIUMTEXT NULL COLLATE 'utf8_unicode_ci',
        //    `full_text`         MEDIUMTEXT NULL COLLATE 'utf8_unicode_ci',
        //    `intro_image`       VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `intro_image_float` VARCHAR(255) NULL DEFAULT 'none' COLLATE 'utf8_unicode_ci',
        //    `main_image`        VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `main_image_float`  VARCHAR(255) NULL DEFAULT 'none' COLLATE 'utf8_unicode_ci',
        //    `hits`              INT(11) NOT NULL DEFAULT '0',
        //    `rating_sum`        INT(11) NOT NULL DEFAULT '0',
        //    `rating_count`      INT(11) NOT NULL DEFAULT '0',
        //    `show_title`        TINYINT(4) NOT NULL DEFAULT '1',
        //    `show_intro`        TINYINT(4) NOT NULL DEFAULT '1',
        //    `show_image`        TINYINT(4) NOT NULL DEFAULT '1',
        //    `show_hits`         TINYINT(4) NOT NULL DEFAULT '0',
        //    `show_rating`       TINYINT(4) NOT NULL DEFAULT '0',
        //    `content_type_id`   INT(11) NOT NULL DEFAULT '0',
        //    `featured`          TINYINT(4) NOT NULL DEFAULT '0',
        //    `ordering`          INT(11) NOT NULL DEFAULT '0',
        //    `publish_up`        DATETIME NULL DEFAULT NULL,
        //    `publish_down`      DATETIME NULL DEFAULT NULL,
        //    `status`            SMALLINT(6) NOT NULL DEFAULT '1',
        //    `created_by`        INT(11) NOT NULL,
        //    `created_at`        DATETIME NOT NULL,
        //    `updated_by`        INT(11) NOT NULL,
        //    `updated_at`        DATETIME NOT NULL,
        //    PRIMARY KEY (`id`),
        //    INDEX `FK_content_category_id` (`category_id`),
        //    INDEX `FK_content_content_type_id` (`content_type_id`),
        //    CONSTRAINT `FK_content_category_id` FOREIGN KEY (`category_id`) REFERENCES `content_category` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
        //    CONSTRAINT `FK_content_content_type_id` FOREIGN KEY (`content_type_id`) REFERENCES `content_type` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
        //)
        //COLLATE='utf8_unicode_ci'
        //ENGINE=InnoDB
        //AUTO_INCREMENT=1;
        
        $this->createTable('{{%content}}', [
            'id'                => $this->primaryKey(),
            'name'              => $this->string(),
            'title'             => $this->string()->notNull(),
            'category_id'       => $this->integer()->notNull(),
            'tags'              => $this->string()->notNull(),
            'intro_text'        => "MEDIUMTEXT",
            'full_text'         => "MEDIUMTEXT",
            'intro_image'       => $this->string(),
            'intro_image_float' => $this->string()->defaultValue('none'), 
            'main_image'        => $this->string(),
            'main_image_float'  => $this->string()->defaultValue('none'), 
            'hits'              => $this->integer()->notNull()->defaultValue('0'),
            'rating_sum'        => $this->integer()->notNull()->defaultValue('0'),
            'rating_count'      => $this->integer()->notNull()->defaultValue('0'),
            'show_title'        => $this->tinyInteger(4)->notNull()->defaultValue('1'),
            'show_intro'        => $this->tinyInteger(4)->notNull()->defaultValue('1'),
            'show_image'        => $this->tinyInteger(4)->notNull()->defaultValue('1'),
            'show_hits'         => $this->tinyInteger(4)->notNull()->defaultValue('0'),
            'show_rating'       => $this->tinyInteger(4)->notNull()->defaultValue('0'),
            'content_type_id'   => $this->integer()->notNull()->defaultValue('0'),
            'featured'          => $this->tinyInteger(4)->notNull()->defaultValue('0'),
            'ordering'          => $this->integer()->notNull()->defaultValue('0'),
            'publish_up'        => $this->datetime(),
            'publish_down'      => $this->datetime(),
            'status'            => $this->smallInteger(6)->notNull()->defaultValue('1'),
            'created_at'        => $this->datetime(),
            'updated_at'        => $this->datetime(),
            'created_by'        => $this->integer()->notNull(),
            'updated_by'        => $this->integer()->notNull(),
        ], $tableOptions);
        
        // Usage: $this->addForeignKey($name, $table, $columns, $refTable, $refColumns, $delete = null, $update = null)
        $this->addForeignKey(
          'FK_content_category_id', '{{%content}}', 'category_id', '{{%content_category}}', 'id', 'RESTRICT', 'RESTRICT'
        );
        $this->addForeignKey(
          'FK_content_content_type_id', '{{%content}}', 'content_type_id', '{{%content_type}}', 'id', 'RESTRICT', 'RESTRICT'
        );
    }
    
    public function createTableDistributor()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        //CREATE TABLE `distributor` (
        //    `id`              INT(11) NOT NULL AUTO_INCREMENT,
        //    `first_name`      VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `last_name`       VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `name_prefix`     VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `occupation`      VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `company_name`    VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `address`         VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `city`            VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `state_prov`      VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `postal_code`     VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `country`         VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `latitude`        VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `longitude`       VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `phone`           VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `fax`             VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `email`           VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `website`         VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `services`        VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `hours`           TEXT NULL COLLATE 'utf8_unicode_ci',
        //    `instructions`    TEXT NULL COLLATE 'utf8_unicode_ci',
        //    `status`          SMALLINT(6) NOT NULL DEFAULT '1',
        //    `created_at`      DATETIME NOT NULL,
        //    `updated_at`      DATETIME NOT NULL,
        //    `updated_by`      INT(11) NOT NULL,
        //    `created_by`      INT(11) NOT NULL,
        //    PRIMARY KEY (`id`),
        //)
        //COLLATE='utf8_unicode_ci'
        //ENGINE=InnoDB
        //AUTO_INCREMENT=1;
        
        $this->createTable('{{%distributor}}', [
            'id'           => $this->primaryKey(),
            'first_name'   => $this->string(),    
            'last_name'    => $this->string(),    
            'name_prefix'  => $this->string(50),  
            'occupation'   => $this->string(),    
            'company_name' => $this->string(),    
            'address'      => $this->string(),    
            'city'         => $this->string(),    
            'state_prov'   => $this->string(),    
            'postal_code'  => $this->string(),    
            'country'      => $this->string(),    
            'latitude'     => $this->string(),    
            'longitude'    => $this->string(),    
            'phone'        => $this->string(),    
            'fax'          => $this->string(50),  
            'email'        => $this->string(),    
            'website'      => $this->string(),    
            'services'     => $this->string(),    
            'hours'        => $this->text(),    
            'instructions' => $this->text(),      
            'status'       => $this->tinyInteger()->notNull(1)->defaultValue('1'),
            'created_at'   => $this->datetime(),
            'updated_at'   => $this->datetime(),
            'created_by'   => $this->integer()->notNull(),
            'updated_by'   => $this->integer()->notNull(),
        ], $tableOptions);
    }
    
    public function createTablePayment()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        //CREATE TABLE `payment` (
        //    `id`                INT(11) NOT NULL AUTO_INCREMENT,
        //    `full_name`         VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `company_name`      VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `address`           VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `city`              VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `state_prov`        VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `postal_code`       VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `country`           VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `email`             VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `phone`             VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `fax`               VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `account_number`    VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `amount`            VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `description`       VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `payment_date`      DATETIME NULL DEFAULT NULL,
        //    `payment_status`    VARCHAR(255) NOT NULL DEFAULT 'Unpaid' COLLATE 'utf8_unicode_ci',
        //    `crcard_type`       VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `crcard_number`     VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `crcard_first_name` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `crcard_last_name`  VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `trans_id`          VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `trans_invoice_num` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `trans_description` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `trans_response`    TEXT NULL COLLATE 'utf8_unicode_ci',
        //    `ip_address`        VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `notes`             TEXT NULL COLLATE 'utf8_unicode_ci',
        //    `active`            TINYINT(1) NOT NULL DEFAULT '1',
        //    `created_at`        DATETIME NULL DEFAULT NULL,
        //    `updated_at`        DATETIME NULL DEFAULT NULL,
        //    `created_by`        INT(11) NULL DEFAULT NULL,
        //    `updated_by`        INT(11) NULL DEFAULT NULL,
        //    PRIMARY KEY (`id`),
        //)
        //COLLATE='utf8_unicode_ci'
        //ENGINE=InnoDB
        //AUTO_INCREMENT=1;
        
        $this->createTable('{{%payment}}', [
            'id'           => $this->primaryKey(),
            'full_name'         => $this->string(),  
            'company_name'      => $this->string(),  
            'address'           => $this->string(),  
            'city'              => $this->string(),  
            'state_prov'        => $this->string(),  
            'postal_code'       => $this->string(),  
            'country'           => $this->string(),  
            'email'             => $this->string(),  
            'phone'             => $this->string(50),
            'fax'               => $this->string(50),
            'account_number'    => $this->string(50),
            'amount'            => $this->string(50),
            'description'       => $this->string(),  
            'payment_date'      => $this->datetime(),
            'payment_status'    => $this->string(),  
            'crcard_type'       => $this->string(),  
            'crcard_number'     => $this->string(),  
            'crcard_first_name' => $this->string(),  
            'crcard_last_name'  => $this->string(),  
            'trans_id'          => $this->string(),  
            'trans_invoice_num' => $this->string(),  
            'trans_description' => $this->string(),  
            'trans_response'    => $this->text(),    
            'ip_address'        => $this->string(),  
            'notes'             => $this->text(),    
            'active'       => $this->tinyInteger()->notNull(1)->defaultValue('1'),
            'created_at'   => $this->datetime(),
            'updated_at'   => $this->datetime(),
            'created_by'   => $this->integer()->notNull(),
            'updated_by'   => $this->integer()->notNull(),
        ], $tableOptions);
    }
    
    public function createTableSpamFilter()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        //CREATE TABLE `spam_filter` (
        //    `id`       INT(11) NOT NULL AUTO_INCREMENT,
        //    `name`     VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `category` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `keywords` TEXT NULL COLLATE 'utf8_unicode_ci',
        //    `status`   TINYINT(1) NOT NULL DEFAULT '1',
        //    PRIMARY KEY (`id`),
        //)
        //COLLATE='utf8_unicode_ci'
        //ENGINE=InnoDB
        //AUTO_INCREMENT=1;
        
        $this->createTable('{{%spam_filter}}', [
            'id'       => $this->primaryKey(),
            'name'     => $this->string(),
            'category' => $this->string(),
            'keywords' => $this->text(),
            'status'   => $this->smallInteger()->notNull()->defaultValue('1'),
        ], $tableOptions);
    }
    
    public function createTableTestimonial()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        //CREATE TABLE `testimonial` (
        //    `id`       INT(11) NOT NULL AUTO_INCREMENT,
        //    `comment`  TEXT NULL COLLATE 'utf8_unicode_ci',
        //    `author`   VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `location` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `tags`     VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //    `status`   TINYINT(1) NOT NULL DEFAULT '1',
        //    PRIMARY KEY (`id`),
        //)
        //COLLATE='utf8_unicode_ci'
        //ENGINE=InnoDB
        //AUTO_INCREMENT=1;
        
        $this->createTable('{{%testimonial}}', [
            'id'       => $this->primaryKey(),
            'comment'  => $this->text(),
            'author'   => $this->string(),
            'location' => $this->string(),
            'tags'     => $this->string(),
            'status'   => $this->smallInteger()->notNull()->defaultValue('1'),
        ], $tableOptions);
    }
    
    private function createTableAppSetting()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB AUTO_INCREMENT=1';
        }

        // CREATE TABLE `app_setting` (
        //     `id`       INT(11)      NOT NULL AUTO_INCREMENT,
        //     `key`      VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //     `value`    VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //     `default`  VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //     `status`   VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //     `type`     VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //     `unit`     VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //     `role`     VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
        //     `created_at` DATETIME     NULL DEFAULT NULL,
        //     `updated_at` DATETIME     NULL DEFAULT NULL,
        //     PRIMARY KEY (`id`)
        // )
        // COLLATE='utf8_unicode_ci'
        // ENGINE=InnoDB;
        
        $this->createTable('{{%app_setting}}', [
            'id'         => $this->primaryKey(),
            'key'        => $this->string(),
            'value'      => $this->string(),
            'default'    => $this->string(),
            'status'     => $this->string(),
            'type'       => $this->string(),
            'unit'       => $this->string(),
            'role'       => $this->string(),
            'created_at' => $this->datetime(),
            'updated_at' => $this->datetime(),
        ], $tableOptions);
        
        // insert data as a row
        //$this->insert('{{%app_setting}}', [
        //    'key'      => 'key',
        //    'value'    => 'value',
        //    'default'  => 'default',
        //    'status'   => 'status',
        //    'type'     => 'type',
        //    'unit'     => 'unit',
        //    'role'     => 'role',
        //]);
    }
}
