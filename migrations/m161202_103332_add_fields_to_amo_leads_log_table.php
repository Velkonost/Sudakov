<?php
use yii\db\Migration;

class m161202_103332_add_fields_to_amo_leads_log_table extends Migration
{
    private $table = 'amo_leads_log';

    public function up()
    {
        $this->addColumn($this->table, 'lead_ext_id', $this->integer(11)->notNull());
        $this->addColumn($this->table, 'updated_at', $this->integer(11)->notNull());
    }


    public function down()
    {
        $this->dropColumn($this->table, 'lead_ext_id');
        $this->dropColumn($this->table, 'updated_at');
    }
}
