<?php

use yii\db\Migration;

/**
 * Handles the creation for table `feedbacks`.
 */
class m170516_050038_create_feedbacks_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('feedbacks', [
            'id' => $this->primaryKey(),
            'date' => $this->integer()->notNull(),
            'fio' => $this->string(255)->notNull(),
            'budget' => $this->decimal()->notNull(),
            'thumbnail' => $this->string(500),
            'text' => $this->text(),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('feedbacks');
    }
}
