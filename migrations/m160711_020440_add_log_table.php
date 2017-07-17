<?php

use yii\db\Migration;

class m160711_020440_add_log_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%log}}', [
            'id' => $this->primaryKey(),
            'job_id' => $this->integer()->notNull(),
            'old_status' => $this->integer()->notNull(),
            'new_status' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%log}}');
    }
}
