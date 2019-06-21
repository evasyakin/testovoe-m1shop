<?php
namespace base;

use Evas\Orm\AppConnectionTrait;
use Evas\Web\App as WebApp;

/**
 * Класс приложения.
 */
class App extends WebApp
{
    /**
     * Подключаем расширение соединения с базой данных.
     */
    use AppConnectionTrait;
}
