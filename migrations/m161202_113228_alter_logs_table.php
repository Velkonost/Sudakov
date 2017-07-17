<?php

use yii\db\Migration;

class m161202_113228_alter_logs_table extends Migration
{
    public function up()
    {
        $this->renameColumn('amo_leads_log', 'full_name', 'username');
        $this->alterColumn('amo_leads_log', 'username', $this->string(120));
        $this->alterColumn('amo_leads_log', 'text', $this->string(1500));
        $this->alterColumn('amo_leads_log', 'pk', $this->bigInteger()->unsigned());
    }

    public function down()
    {
        $this->renameColumn('amo_leads_log', 'username', 'full_name');
    }
}
