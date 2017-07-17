<?php

use yii\db\Migration;

class m160907_160836_alter_table_money_add_cm_fin extends Migration
{
    public function up()
    {
        $this->addColumn('money', 'comment_fin', 'TEXT(3000) NULL');
    }

    public function down()
    {
        $this->dropColumn('money', 'comment_fin');
    }
}
