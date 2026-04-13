<?php

use yii\db\Migration;

/**
 * Migration: Convert database and all tables to UTF-8 MB4 (emoji support)
 *
 * This migration converts the entire database from utf8mb3 to utf8mb4 to support
 * emojis and other 4-byte UTF-8 characters.
 *
 * Run with: yii migrate/to m260331_120000_convert_to_utf8mb4
 * Revert with: yii migrate/down 1
 */
class m260331_120000_convert_to_utf8mb4 extends Migration
{
    public function up()
    {
        $connection = Yii::$app->db;
        $dbName = $connection->createCommand('SELECT DATABASE()')->queryScalar();

        // 1. Convert database charset
        $this->execute("ALTER DATABASE `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

        // 2. Get all tables
        $tables = $connection->schema->getTableNames();

        // 3. Convert each table
        foreach ($tables as $table) {
            // Remove table prefix if present
            $rawTableName = $connection->schema->getRawTableName($table);
            
            echo "Converting table: `{$rawTableName}`\n";

            // Alter table charset
            $this->execute("ALTER TABLE `{$rawTableName}` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        }

        echo "Database and all tables converted to utf8mb4_unicode_ci successfully.\n";
        return true;
    }

    public function down()
    {
        $connection = Yii::$app->db;
        $dbName = $connection->createCommand('SELECT DATABASE()')->queryScalar();

        // Convert back to utf8mb3 (if reverting)
        $this->execute("ALTER DATABASE `{$dbName}` CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci");

        // Get all tables and convert back
        $tables = $connection->schema->getTableNames();
        foreach ($tables as $table) {
            $rawTableName = $connection->schema->getRawTableName($table);
            echo "Reverting table: `{$rawTableName}`\n";
            $this->execute("ALTER TABLE `{$rawTableName}` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci");
        }

        echo "Database and all tables reverted to utf8mb3_unicode_ci.\n";
        return true;
    }
}
