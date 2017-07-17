<?php

use yii\db\Migration;

/**
 * Handles the creation for table `lead_log`.
 */
class m161028_133123_create_lead_log_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('lead_log', [
            'id' => $this->primaryKey(),
            'lead_id' => $this->integer()->notNull(),
            'lead_ext_id' => $this->integer()->notNull(),
            'lead_status_id' => $this->integer()->notNull()->defaultValue(0),
            'lead_ext_status_id' => $this->integer()->notNull()->defaultValue(0),
            'updated_at' => $this->integer()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('lead_log');
    }
}
