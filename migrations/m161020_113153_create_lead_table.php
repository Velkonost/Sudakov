<?php

use yii\db\Migration;

/**
 * Handles the creation for table `lead`.
 */
class m161020_113153_create_lead_table extends Migration
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
        $this->createTable('lead', [
            'lead_id' => $this->primaryKey(),
            'ext_id' => $this->integer(11)->null(),
            'name' => $this->string(512),
            'total_sum' => $this->decimal(12,2)->defaultValue(0),
            'created_at' => $this->integer(11),
            'status_id' => $this->integer(11),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('lead');
    }
}
