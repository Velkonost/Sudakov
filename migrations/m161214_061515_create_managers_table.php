<?php

use yii\db\Migration;

/**
 * Handles the creation for table `queue_leads`.
 */
class m161214_061515_create_managers_table extends Migration
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
        $this->createTable('manager_option', [
            'manager_id' => $this->primaryKey(),
            'user_ext_id' => $this->integer(11)->unique(),
            'user_name' => $this->string(128),
            'is_manager' => $this->smallInteger(1),
            'member_allocation' => $this->smallInteger(1),
            'coefficient' => $this->integer(11),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('manager_option');
    }
}
