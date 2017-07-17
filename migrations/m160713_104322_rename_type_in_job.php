<?php

use yii\db\Migration;

class m160713_104322_rename_type_in_job extends Migration
{
    public function up()
    {
        $this->renameColumn('job', 'type', 'collection');
    }

    public function down()
    {
        $this->renameColumn('job', 'collection', type);
    }
}
