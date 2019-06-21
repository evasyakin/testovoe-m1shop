<?php
/**
 * Тестовое задание.
 * @package CD-Collection
 * 
 * @author Egor Vasyakin <e.vasyakin@itevas.ru>
 */

use base\App;
use base\config\CdCollectionDb;
use base\custom\AppResponse;
use base\custom\PagesController;
use base\helpers\Logger;

use Evas\Loader\Loader;
use Evas\Mvc\Route;
use Evas\Router\RestRouter;

use collection\controllers\CollectionApiV1;
use collection\controllers\AlbumApiV1;

// вывод ошибок
ini_set('display_errors', 1);
error_reporting(E_ALL);

// часовой пояс
define('TIMEZONE', 'Europe/Moscow');
date_default_timezone_set(TIMEZONE);

// имя приложения
define('APP_NAME', 'CD-Collection');

// подключаем автозагрузку
include __DIR__ . '/vendor/evas-php/evas-loader/src/Loader.php';
(new Loader)
    ->namespaces([
        'Evas\\Base\\' => 'vendor/evas-php/evas-base/src/',
        'Evas\\Di\\' => 'vendor/evas-php/evas-di/src/',
        'Evas\\Http\\' => 'vendor/evas-php/evas-http/src/',
        'Evas\\Mvc\\' => 'vendor/evas-php/evas-mvc/src/',
        'Evas\\Orm\\' => 'vendor/evas-php/evas-orm/src/',
        'Evas\\Router\\' => 'vendor/evas-php/evas-router/src/',
        'Evas\\Validate\\' => 'vendor/evas-php/evas-validate/src/',
        'Evas\\Web\\' => 'vendor/evas-php/evas-web/src/',
        'Evas\\Web\\Store\\' => 'vendor/evas-php/evas-web-store/src/',
    ])
    ->dir('app/')
    ->run();

// устанавливаем перехватчик исключений в журнал
set_exception_handler(function (\Throwable $e) {
    Logger::write($e->getMessage() . "\n" . $e->getFile() . ' on line ' . $e->getLine());
});

// устанавливаем базу данных
App::setDb(new CdCollectionDb);

// получаем объект запроса
$request = App::request();

// запускаем маршрутизацию
$route = (new RestRouter)
    ->routeClass(Route::class)
    ->get([
        '/' => 'home.php',
        '/cabinet' => 'cabinet.php',
    ])
    ->all([
        '/api/v1/(.*)' => (new RestRouter)
            ->routeClass(Route::class)
            ->pattern(':collectionAction', '(list|show|save|drop)')
            ->all([
                'collection/:collectionAction' => [CollectionApiV1::class],
                'album/(save|drop)' => [AlbumApiV1::class],
            ])
            ->default(function () {
                (new AppResponse)->sendError(404, '404. Страница не найдена');
            }),
    ])
    ->default('404.php')
    ->handle($request->getPath(), $request->getMethod());

// устанавливаем request в найденный route и выполняем разбор маршрута
$route->setRequest($request);
// устанавливаем класс контроллеров для view
$route->setViewControllerClass(PagesController::class);
$route->handle();

