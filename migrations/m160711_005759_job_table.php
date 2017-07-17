<?php

use yii\db\Migration;

class m160711_005759_job_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%job}}', [
            'id' => $this->primaryKey(),
            'ext_id' => $this->integer()->notNull()->unique(),
            'name' => $this->string()->notNull(),
            'client' => $this->string()->notNull(),
            'deadline' => $this->integer()->notNull(),
            'type' => $this->string()->notNull(),
            'sketch' => $this->string(5000)->notNull(),
            'plan' => $this->string(5000)->notNull(),
            'description' => $this->string(5000)->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'started_at' => $this->integer()->notNull(),
            'finished_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%job}}');
    }

}
