<?php

use yii\db\Migration;

class m160713_110856_add_pan_ai extends Migration
{
    public function up()
    {
        $this->addColumn('job', 'plan_ai', 'TEXT(5000) NULL');
    }

    public function down()
    {
        $this->dropColumn('job', 'plan_ai');
    }

}
