<?php

use yii\db\Migration;

class m160908_181033_add_table_lead_status extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%lead_status}}', [
            'id' => $this->primaryKey(),
            'ext_id' => $this->integer()->notNull()->unique(),
            'label' => $this->string(50)->notNull(),
            'color' => $this->string(10)->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%lead_status}}');
    }
}
