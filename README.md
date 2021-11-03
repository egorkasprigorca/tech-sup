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

