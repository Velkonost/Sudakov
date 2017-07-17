<?php

use yii\db\Migration;

/**
 * Handles the creation for table `instagram_media`.
 */
class m161203_150232_create_instagram_media_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('instagram_media', [
            'id' => $this->primaryKey(),
            'media_id' => $this->string(31),
            'media_url' => $this->string(40),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('instagram_media');
    }
}
