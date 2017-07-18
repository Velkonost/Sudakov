<?php

use yii\db\Migration;

/**
 * Handles adding manager_id to table `users`.
 */
class m170530_065500_add_manager_id_column_to_user_table extends Migration
{
    private $table = 'user';

    public function up()
    {
        $this->addColumn($this->table, 'manager_id', $this->integer(2));
    }

       public function down()
    {
        $this->dropColumn($this->table, 'manager_id');

        return true;
    }
}
