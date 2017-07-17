<?php

use yii\db\Migration;

class m161203_151511_remove_wrong_user_pk extends Migration
{
    public function up()
    {
        $this->delete('amo_leads_log', "pk = 2147483647");
    }

    public function down()
    {
        // nope
    }

}
