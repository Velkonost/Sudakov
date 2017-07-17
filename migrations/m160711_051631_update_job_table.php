<?php

use yii\db\Migration;

class m160711_051631_update_job_table extends Migration
{
    public function up()
    {
        $this->addColumn('job', 'created_at', 'INT(11) NOT NULL');
    }

    public function down()
    {
        $this->dropColumn('job', 'created_at');
    }

}
