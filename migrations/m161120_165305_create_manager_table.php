<?php

use yii\db\Migration;

/**
 * Handles the creation for table `manager`.
 */
class m161120_165305_create_manager_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('manager', [
            'id' => 'pk',
            'responsible_user_id' => 'INT(11)',
            'name' => 'VARCHAR(255)',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('manager');
    }
}
