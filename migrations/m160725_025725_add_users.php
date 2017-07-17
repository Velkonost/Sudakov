<?php

use yii\db\Migration;

class m160725_025725_add_users extends Migration
{
    public function up()
    {
        $p1 = '$2y$13$0xB0ADmyJuFOrtencZ1lruxZ9ZJlysRZiEq5alPz1j.cAx8N1HUaq';
        $p2 = '$2y$13$kTTTCNrl1xPaLTmjTICPMOacBDM/Wa0CncW/Sv0SGa8VPgaos6HOy';
        $p3 = '$2y$13$UAmnJ1.os6T4ioVq3h8lc.3Emu9cURsc5ItHfkE/VcxN7CCQdKetu';
        $this->execute("INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `fio`) VALUES
(1, 'admin', 'CQLzzlnJbkBdY_WSV0OqlrdhIbknOfY1', '{$p1}', NULL, 'mail@art-prog.ru', 10, 1468167796, 1468196101, 'Администратор'),
(2, 'superadmin', 'i0E-Sdt3PCFZgnfIKQ49fEO56fGyDlDq', '{$p2}', NULL, 'contact@sudakovsergey.com', 10, 1468194065, 1468194065, 'Супер Администратор'),
(3, 'worker', '_JC6OwvTwrNTOPQBhItUdgISRJoed2gK', '{$p3}', NULL, 'adamasantares@gmail.com', 10, 1468196285, 1468196285, 'Сотрудник')");

        // add roles
        $this->execute("INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, NULL, NULL, NULL, 1468165032, 1468165032),
('superadmin', 1, NULL, NULL, NULL, 1468165032, 1468165032),
('worker', 1, NULL, NULL, NULL, 1468165032, 1468165032),
('buh', 1, NULL, NULL, NULL, 1469424198, 1469424198),
('manager-payment', 1, NULL, NULL, NULL, 1469421752, 1469421752)");

        // relate roles to users
        $this->execute("INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '1', 1468196101),
('superadmin', '2', 1468194065),
('worker', '3', 1468196285)");

    }

    public function down()
    {
        // no revert
    }

}
