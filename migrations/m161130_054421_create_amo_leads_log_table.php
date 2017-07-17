<?php

use yii\db\Migration;

/**
 * Handles the creation for table `amo_log`.
 */
class m161130_054421_create_amo_leads_log_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('amo_leads_log', [
            'id' => $this->primaryKey(),
            'pk' => $this->integer(11)->notNull(),
            'name' => $this->string(256)->notNull(),
            'full_name' => $this->string(512),
            'text' => $this->string(4096),
            'created_at' => $this->integer(11),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('amo_leads_log');
    }
}
