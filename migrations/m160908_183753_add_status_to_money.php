<?php

use yii\db\Migration;


class m160908_183753_add_status_to_money extends Migration
{
    public function up()
    {
        $this->addColumn('money', 'lead_status', 'INT NULL');
    }

    public function down()
    {
        $this->dropColumn('money', 'lead_status');
    }

}
