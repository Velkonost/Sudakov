<?php

use yii\db\Migration;

/**
 * Handles the creation for table `assignment_leads`.
 */
class m161215_082525_create_assignment_leads_table extends Migration
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
        $this->createTable('assignment_leads', [
            'id' => $this->primaryKey(),
            'manager_id' => $this->integer(11)->notNull(),
            'lead_id' => $this->integer(11)->notNull(),
            'status' => $this->integer(1)->defaultValue(0),
            'created_at' => $this->integer(11),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('assignment_leads');
    }
}
