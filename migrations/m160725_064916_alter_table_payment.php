<?php

use yii\db\Migration;

class m160725_064916_alter_table_payment extends Migration
{
    public function up()
    {
        $this->addColumn('payment', 'items', 'text(5000) NULL');
    }

    public function down()
    {
        $this->dropColumn('payment', 'items');
    }

}
