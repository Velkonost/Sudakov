<?php

use yii\db\Migration;

class m161203_152156_fix_updated_at extends Migration
{
    public function up()
    {
        $this->execute("UPDATE `amo_leads_log` SET `updated_at`=`created_at`");
    }

    public function down()
    {
        // nope
    }

}
