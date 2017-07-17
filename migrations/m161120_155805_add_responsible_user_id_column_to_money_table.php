<?php

use yii\db\Migration;

/**
 * Handles adding responsible_user_id to table `money`.
 */
class m161120_155805_add_responsible_user_id_column_to_money_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('money', 'responsible_user_id', 'INT(11) NULL');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('money', 'responsible_user_id');
    }
}
