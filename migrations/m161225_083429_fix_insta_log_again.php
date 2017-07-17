<?php

use yii\db\Migration;

class m161225_083429_fix_insta_log_again extends Migration
{
    public function up()
    {
        $this->alterColumn('amo_leads_log', 'username', $this->string(120));
        $this->alterColumn('amo_leads_log', 'text', $this->string(1500));
        $this->alterColumn('amo_leads_log', 'pk', $this->bigInteger()->unsigned());
    }

    public function down()
    {
    }

}
