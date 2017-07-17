<?php

// НЕ менять доступы к базе тут!
// для локальной базы нужно продублировать этот файл с именем local-db.php и изменить логин/пароль к базе там.
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=crm-sudakov',
    'username' => 'root',
    'password' => 'root',
    'charset' => 'utf8',
];
