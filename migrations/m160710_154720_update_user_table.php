<?php

use yii\db\Migration;

class m160710_154720_update_user_table extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'fio', 'varchar(255) null');
    }

    public function down()
    {
        $this->dropColumn('user', 'fio');
    }

}
