<?php

use yii\db\Migration;

class m180508_100000_create_session_table extends Migration
{
    public function up()
    {
        if (!$this->getDb()->getTableSchema('{{%session}}')) {
            $this->createTable('{{%session}}', [
                'id' => $this->char(64)->notNull(),
                'expire' => $this->integer(),
                'data' => $this->binary(),
                'PRIMARY KEY (id)',
            ]);
        }
    }

    public function down()
    {
        $this->dropTable('{{%session}}');
    }
}
