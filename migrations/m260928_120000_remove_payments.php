<?php

use yii\db\Migration;

/**
 * Migration: Remove payments support / tables.
 *
 * This migration removes the 'payments' table(s).
 *
 * Run with: yii migrate/to m260928_120000_remove_payments
 * Revert with: yii migrate/down 1
 */
class m260928_120000_remove_payments extends Migration
{
    public function up()
    {
        if ($this->db->schema->getTableSchema('payments', true) !== null) {
            $this->dropTable('payments');
        }
    }

    public function down()
    {
        echo "The payments table cannot be restored automatically.\n";
        return false;
    }
}
