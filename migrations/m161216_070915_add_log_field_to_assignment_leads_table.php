<?php

use yii\db\Migration;

class m161216_070915_add_log_field_to_assignment_leads_table extends Migration
{
    private $table = 'assignment_leads';
    public function up()
    {
        $this->addColumn($this->table, 'log', $this->integer(2));
    }

    public function down()
    {
        $this->dropColumn($this->table, 'log');
        return true;
    }
}
