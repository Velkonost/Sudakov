<?php

use yii\db\Migration;

class m161250_160600_fix_instagram_media extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropTable('instagram_media');
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('instagram_media', [
            'id' => $this->primaryKey(),
            'media_id' => $this->string(50),
            'media_url' => $this->string(100),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // nope
    }
}
