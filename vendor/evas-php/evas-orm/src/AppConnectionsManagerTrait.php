<?php
/**
 * @package evas-php/evas-orm
 */
namespace Evas\Orm;

use Evas\Orm\Connection;
use Evas\Orm\ConnectionsManager;

/**
 * Расширение поддержки множества баз данных приложения.
 * @author Egor Vasyakin <e.vasyakin@itevas.ru>
 * @since 1.1
 */
trait AppConnectionsManagerTrait
{
    /**
     * @var ConnectionsManager мененджер соединений
     */
    private static $_connectionsManager;

    /**
     * Получение менеджера соединений.
     * @return ConnectionsManager
     */
    public static function getConnectionsManager()
    {
        if (empty(static::$_connectionsManager)) {
            static::$_connectionsManager = new ConnectionsManager;
        }
        return static::$_connectionsManager;
    }

    /**
     * Установка соединения.
     * @param Connection
     */
    public static function setDb(Connection $connection)
    {
        static::getConnectionsManager()->setConnection($connection);
    }

    /**
     * Инициализация соединения.
     * @param array параметры соединения
     */
    public static function initDb(array $params)
    {
        static::getConnectionsManager()->initConnection($params);
    }

    /**
     * Получение соединения.
     * @param string имя соединения
     * @throws Exception
     * @return Connection
     */
    public static function getDb(string $name = null)
    {
        return static::getConnectionsManager()->getConnection($name);
    }

    /**
     * Установка последнего соединения.
     * @param string имя
     * @throws Exception
     */
    public static function setLastDb(string $name)
    {
        return static::getConnectionsManager()->setLastConnection($name);
    }
}
