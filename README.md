<h2>Развертка проекта</h2>

<p>1. Склонировать проект git clone <url></p>
<p>2. Ввести команду "composer update"</p>
<p>3. Изменить настройки в файле .env.example на собственные, затем переименовать файл в .env</p>
<p>4. Ввести команды "php artisan key:generate"</p>
<p>"php artisan migrate"</p>
<p>5. Запустить локальный сервер, вы можете использовать встроенный от Laravel, введя команду "php artisan serve"</p>
<br>
<br>

<h2>Наполнение тестовыми данными</h2>
<p> Для создания user и manager в количестве 5 и 2, использовать команду "php artisan db:seed  --class=UserSeeder"
<p>Данные: user {name: user$i, email: user$i@gmail.com, password:2281337}</p>
<p>Данные: manager {name: manager$i, email: manager$i@gmail.com, password:2281337}</p>
<br>
<br>
<h2>Собственные artisan команды</h2>
<p>php artisan make:manager</p>
