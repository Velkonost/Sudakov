<?php

use yii\db\Migration;

/**
 * Handles adding admchek to table `job`.
 */
class m161222_160600_add_admchek_column_to_job_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
		 $this->addColumn('job', 'adminchek', 'TINYINT(1) DEFAULT "0"');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
		$this->dropColumn('job', 'adminchek');
    }
}
