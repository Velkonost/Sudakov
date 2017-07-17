<?php

use yii\db\Migration;

/**
 * Handles the creation for table `options`.
 */
class m161215_054628_create_options_table extends Migration
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
        $this->createTable('options', [
            'id' => $this->primaryKey(),
            'option' => $this->string(1024)->notNull(),
            'value'  => $this->string(4096)->defaultValue('0'),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('options');
    }
}
