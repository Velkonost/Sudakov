<?php

use yii\db\Migration;

class m160713_103530_add_columns_to_job_table extends Migration
{
    public function up()
    {
        $this->addColumn('job', 'plan_description', 'TEXT(5000) NULL');
    }

    public function down()
    {
        $this->dropColumn('job', 'plan_description');
    }
}
