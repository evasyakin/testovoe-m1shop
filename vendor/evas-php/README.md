# Расширенная предрелизная версия evas-php #

evas-php простой модульный фреймворк для PHP7.0+
https://github.com/evas-php/

### Интеграция ###

Директория ./vendor/evas-php
```
git clone https://evasyakin@bitbucket.org/vk_leaders/vk-leaders-evas-php.git
```

### Запуск ###

```php
// подключаем автозагрузку
include __DIR__ . '/vendor/evas-php/evas-loader/src/Loader.php';
(new Evas\Loader\Loader)
    ->namespaces([
        'Evas\\Di\\' => 'vendor/evas-php/evas-di/src/',
        'Evas\\Http\\' => 'vendor/evas-php/evas-http/src/',
        'Evas\\Orm\\' => 'vendor/evas-php/evas-orm/src/',
        'Evas\\Router\\' => 'vendor/evas-php/evas-router/src/',
        'Evas\\Store\\' => 'vendor/evas-php/evas-store/src/',
        'Evas\\Validate\\' => 'vendor/evas-php/evas-validate/src/',
        'Evas\\Web\\' => 'vendor/evas-php/evas-web/src/',
    ])
    ->dir('app/')
    ->run();
// ваш код
```

### Модули ###

evas-php/evas-di 		Контенер Di
evas-php/evas-http 		Интерфейс объекта Request
evas-php/evas-loader 	PSR4, PSR0 совместимый автозагрузчик
evas-php/evas-orm 		Обертка базы данных с поддержкой QueryBuilder, ActiveRecord и QueryResult
evas-php/evas-router 	Маршрутизатор по регулярным выражениям
evas-php/evas-store		Хранилища Session и Cookie
evas-php/evas-validate 	Валидаторы полей и набора полей
evas-php/evas-web 		Модуль веб-приложения под веб-сервер Apache/Nginx

### Код стайл ###

PSR0, PSR1, PSR2, PSR3, PSR4, PhpDoc

### Контакт создателя ###

Egor Vasyakin <e.vasyakin@itevas.ru>
