<?php

use yii\db\Migration;

class m161029_103113_alter_lead_table extends Migration
{
    public function up()
    {
        $this->addColumn('lead', 'city', $this->text(30)->notNull()->defaultValue(""));
    }

    public function down()
    {
        $this->dropColumn('lead', 'city');
    }
}
