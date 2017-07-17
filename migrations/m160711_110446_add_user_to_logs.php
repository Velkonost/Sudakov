<?php

use yii\db\Migration;

/**
 * Handles adding user to table `logs`.
 */
class m160711_110446_add_user_to_logs extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('log', 'username', 'varchar(50) NULL');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('log', 'username');
    }
}
