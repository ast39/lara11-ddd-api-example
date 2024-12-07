<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

### Технологии

- Миграции для развертывания БД
- Сидеры для наполнения БД первоначальными данными
- Авторизация через ```Sanctum``` по токену для моб. приложений
- Система комбинированных ролей пользователей
- Реализация ```CRUD``` для 4 сущностей: пользователи, категории, товары, отзывы
- Функционал загрузки изображений на сервер, использование ```symlink```
- Объемные решения в ```Eloquent``` моделях
- Функционал связей ```ManyToMany``` для привязки изображений к товарам и отзывам 
- Выполнение задачи в ```Schedule``` по удалению просроченных токенов
- Срабатывание ```Events``` и ```Listeners``` для выполнения сценария
- Использование очередей через ```Jobs``` для отправки уведомлений
- Реализация отправки писем через ```Mail``` класс и шаблоны в ```Blade```
- Использование ```Observers``` для отслеживания и чистки файлов при удалении товаров и отзывов
- Использование ```Request``` классов для валидации запросов
- Использование ```Resource``` классов для отдачи данных
- Использование ```Scope``` фильтров для фильтрации запросов
- Использование ```DTO``` классов для передачи информации между слоями
- Использование стандартов отдачи ошибок через свои ```Exceptions``` классы
- Полное описание в ```Swagger``` всех эндпоинтов и схем

### Развертка

После скачивания репозитория требуется небольшая настройка

```
# Установка пакетов композера
$ composer install

# Создать свой .env файл на основе .env.example
$ mv -v .env.example .env
```

Теперь заполните файл .env своими настройками подключения к БД

```
# Драйвер БД
DB_CONNECTION=mysql

# Хост
DB_HOST=127.0.0.1

# Порт
DB_PORT=3306

# Название БД
DB_DATABASE=lara11

# Пользователь БД
DB_USERNAME=lara11

# Пароль к БД
DB_PASSWORD=lara11
```

Прочие настройки .env

```
# Swagger роут для DEV сервера
L5_SWAGGER_DEV_HOST=http://127.0.0.1:8000/api

# Swagger роут для PROD сервера
L5_SWAGGER_PROD_HOST=http://127.0.0.1:8001/api

# Время жизни токена авторизации
TOKEN_LIFE_TIME=86400

# Роут SWAGGER документации
APP_SWAGGER_DOCS=api/docs
```

И последний этап

```
# Генерация Swagger документации
$ php artisan l5-swagger:generate

# Запуск миграций и сидеров
$ php artisan migrate --seed

# Создать симлинки
$ php artisan storage:link

# Запустить шедулер
$ php artisan schedule:work

# Запустить очереди
$ php artisan queue:work
```

### Рутовая учетка
- login: admin@test.com
- password: admin
