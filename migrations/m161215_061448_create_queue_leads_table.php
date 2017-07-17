<?php

use yii\db\Migration;

/**
 * Handles the creation for table `queue_leads_options`.
 */
class m161215_061448_create_queue_leads_table extends Migration
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
        $this->createTable('queue_leads', [
            'queue_leads_id' => $this->primaryKey(),
            'lead_id' => $this->integer(11),
            'created_at' => $this->integer(11),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('queue_leads');
    }
}
