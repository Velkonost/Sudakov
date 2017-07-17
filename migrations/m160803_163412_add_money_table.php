<?php

use yii\db\Migration;

class m160803_163412_add_money_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%money}}', [
            'id' => $this->primaryKey(),
            'ext_id' => $this->integer()->notNull()->unique(),
            'created_at' => $this->integer()->notNull(),
            'client_name' => $this->string(50)->notNull(), // фио
            'phone' => $this->string(20)->notNull(), // телефон клиента
            'city' => $this->string(20)->notNull(), // город клиента

            // Деньги фактические
            'total_amount' => $this->decimal()->notNull()->defaultValue(0),
            'first_payment_amount' => $this->decimal()->notNull()->defaultValue(0), // сумма первой оплаты
            'first_payment_status' => $this->smallInteger()->notNull()->defaultValue(0), // оплачено?
            'first_payment_method' => $this->smallInteger()->notNull()->defaultValue(0), // метод первой оплаты
            'first_payment_date' => $this->integer()->notNull()->defaultValue(0), // когда оплатили?
            'first_payment_valid' => $this->smallInteger()->notNull()->defaultValue(0),
            'second_payment_amount' => $this->decimal()->notNull()->defaultValue(0), // сумма второй оплаты
            'second_payment_status' => $this->smallInteger()->notNull()->defaultValue(0), // оплачено?
            'second_payment_method' => $this->smallInteger()->notNull()->defaultValue(0), // метод первой оплаты
            'second_payment_date' => $this->integer()->notNull()->defaultValue(0), // когда оплатили?
            'second_payment_valid' => $this->smallInteger()->notNull()->defaultValue(0),

            // Данные без эквайринга
            'registry_check' => $this->smallInteger()->notNull()->defaultValue(0), // Сверка с реестром (галочка)

            // Товарные чеки
            'goods_bill_num' => $this->integer()->notNull(),
            'goods_bill_date' => $this->integer()->notNull(),
            'goods_bill_comment' => $this->string(1000)->notNull(),

            // Комментарий
            'comment' => $this->string(3000)->notNull(),

            // ID изделия
            'collection' => $this->string(50)->notNull(),
            'count' => $this->integer()->notNull(),
            'units' => $this->string(10)->notNull(),
            'deadline' => $this->integer()->notNull(),
            'finished_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%money}}');
    }

}
