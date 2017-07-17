<?php

use yii\db\Migration;

class m160724_163312_add_payments_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%payment}}', [
            'id' => $this->primaryKey(),
            'ext_id' => $this->integer()->notNull(), // внешний ключ сделки
            'pnum' => $this->integer(2)->notNull(), // первый или второй счет (предоплата и постоплата)
            'client' => $this->string(100)->null(),
            'comment' => $this->string()->null(),
            'manager' => $this->string()->null(),
            'sum' => $this->float()->notNull()->defaultValue(0),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->null(),
            'paid_at' => $this->integer()->null(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%payment}}');
    }
}
