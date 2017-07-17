<?php

use yii\db\Migration;

class m161021_062016_add_pk_tolead_status_table extends Migration
{
    public function up()
    {
        $rows = $this->getDb()->createCommand("SELECT *  FROM `lead_status`")->queryAll();
        foreach ($rows as $key => $row) {
            $id = $key + 1;
            $this->execute("UPDATE `lead_status` SET `id` = {$id} WHERE `ext_id` = {$row['ext_id']}");
        }
        $this->execute("ALTER TABLE `lead_status` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;");
    }

    public function down()
    {
        // none
    }
}
