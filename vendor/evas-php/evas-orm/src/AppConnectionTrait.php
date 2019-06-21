<?php
/**
 * @package evas-php/evas-orm
 */
namespace Evas\Orm;

use \Exception;
use Evas\Orm\Connection;

/**
 * Расширение поддержки базы данных приложения.
 * @author Egor Vasyakin <e.vasyakin@itevas.ru>
 * @since 1.1
 */
trait AppConnectionTrait
{
    /**
     * @var ConnectionsManager мененджер соединений
     */
    private static $_connection;

    /**
     * Установка соединения.
     * @param Connection
     */
    public static function setDb(Connection $connection)
    {
        static::$_connection = &$connection;
    }

    /**
     * Инициализация соединения.
     * @param array параметры соединения
     */
    public static function initDb(array $params)
    {
        static::setDb(new Connection($params));
    }

    /**
     * Получение соединения.
     * @throws Exception
     * @return Connection
     */
    public static function getDb()
    {
        if (empty(static::$_connection)) {
            throw new Exception('AppConnectionTrait exception: Database connection does not set');
        }
        return static::$_connection;
    }
}
