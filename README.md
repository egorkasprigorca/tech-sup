<p>Развертка проекта на Open Server</p>

<p>1. Скачать zip архив с кодом проекта и извлечь в папку OpenServer/domains</p>
<p>2. Затем открыть консоль в OpenServer перейти в папку проекта и ввести команду "composer update"</p>
<p>3. Изменить настройки подключения к базе данных в файле .env</p>

DB_CONNECTION=mysql

DB_HOST=127.0.0.1

DB_PORT=3306

DB_DATABASE=tech-sup

DB_USERNAME=root

DB_PASSWORD=

<p>4. Изменить настройки для работы почты в файле .env</p>
MAIL_DRIVER=postmark
MAIL_HOST=smtp.googlemail.com
MAIL_PORT=465
MAIL_USERNAME=example@gmail.com
MAIL_PASSWORD=password
MAIL_ENCRYPTION=ssl

<p>5. Затем в консоле OpenServer в папке проекта совершаем миграцию "php artisan migrate"</p>
<p>6. Как СУБД можете использовать PhpMyAdmin открыть его по такой ссылке "http://localhost/openserver/phpmyadmin/"</p>
<p>7. Заходим в меню Open server и в пункте мои проекты выбираем "tech-sup.loc"</p>
