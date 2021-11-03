<p>Развертка проекта на Open Server</p>

<p>1. Скачать zip архив с кодом проекта и извлечь в папку OpenServer/domains</p>
<p>2. Затем открыть консоль в OpenServer перейти в папку проекта и ввести команду "composer update"</p>
<p>3. Изменить настройки подключения к базе данных</p>

DB_CONNECTION=mysql

DB_HOST=127.0.0.1

DB_PORT=3306

DB_DATABASE=tech-sup

DB_USERNAME=root

DB_PASSWORD=

<p>4. Изменить настройки для работы почты</p>
MAIL_DRIVER=postmark
MAIL_HOST=smtp.googlemail.com
MAIL_PORT=465
MAIL_USERNAME=test228.loc
MAIL_PASSWORD=Egor56575859
MAIL_ENCRYPTION=ssl

<p>5. Затем в консоле OpenServer в папке проекта совершаем миграцию "php artisan migrate"</p>
