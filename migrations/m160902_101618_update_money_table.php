<?php

use yii\db\Migration;

class m160902_101618_update_money_table extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE `money` CHANGE `city` `city` VARCHAR(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;");
    }

    public function down()
    {
    }
}
