<?php

use yii\db\Migration;

/**
 * Handles the creation for table `collections`.
 */
class m161204_155533_create_collections_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('collections', [
            'id' => 'pk',
            'label' => 'VARCHAR(255)',
            'color' => 'VARCHAR(10)',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('collections');
    }
}
