Работаем из ветки develop, в мастер только готовые решения.

Для установки выполнить

```
composer global require "fxp/composer-asset-plugin:1.2.0"
composer install
```

создать локальную базу и конфиг к ней. Затем выполнить миграции:

```
yii migrate --migrationPath=@yii/rbac/migrations
yii migrate
```

Будут автоматически добавлены пользователи (они реальные и используются клиентом, пароли не менять!)

Супер администратор:
superadmin
108sudakovSuprasada

Выгрузка на сайт происходит ручным копированием, так как хостинг обычный.