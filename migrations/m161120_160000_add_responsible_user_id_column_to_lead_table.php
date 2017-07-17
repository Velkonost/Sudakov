<?php

use yii\db\Migration;

/**
 * Handles adding responsible_user_id to table `lead`.
 */
class m161120_160000_add_responsible_user_id_column_to_lead_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('lead', 'responsible_user_id', 'INT(11) NULL');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('lead', 'responsible_user_id');
    }
}
