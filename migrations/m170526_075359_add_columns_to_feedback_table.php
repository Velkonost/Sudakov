<?php

use yii\db\Migration;

class m170526_075359_add_columns_to_feedback_table extends Migration
{
    private $table = 'feedbacks';

    public function up()
    {
        $this->addColumn($this->table, 'phone', $this->string(20));
        $this->addColumn($this->table, 'ext_id', $this->integer());
    }

    public function down()
    {
        $this->dropColumn($this->table, 'phone');
        $this->dropColumn($this->table, 'lead_id');

        return true;
    }

}
