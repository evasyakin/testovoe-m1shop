<?php
/**
 * @package evas-php/evas-orm
 */
namespace Evas\Orm;

use \Exception;
use Evas\Orm\Connection;

/**
 * Менеджер соединений.
 * @author Egor Vasyakin <e.vasyakin@itevas.ru>
 * @since 1.1
 */
class ConnectionsManager
{
    /**
     * @var array массив соединений с базами данных
     */
    public $connections = [];

    /**
     * @var Connection последнее выбранное соединение
     */
    public $lastConnection;

    /**
     * Установка соединения.
     * @param Connection
     */
    public function setConnection(Connection $connection)
    {
        $this->connections[] = &$connection;
        $this->lastConnection = $connection;
    }

    /**
     * Инициализация соединения.
     * @param array параметры соединения
     */
    public function initConnection(array $params)
    {
        $this->setConnection(new Connection($params));
    }

    /**
     * Получение соединения.
     * @param string имя соединения
     * @throws Exception
     * @return Connection
     */
    public function getConnection(string $name = null)
    {
        if (null === $name) {
            if (empty($this->lastConnection)) {
                throw new Exception('ConnectionsManager exception: Not found lastConnection');
            }
            return $this->lastConnection;
        } else {
            $connection = $this->_findConnection($name);
            if ($connection) {
                $this->lastConnection = &$connection;
                return $connection;
            }
        }
    }

    /**
     * Поиск соединения по имени.
     * @param string имя
     * @throws Exception
     * @return Connection
     */
    private function _findConnection(string $name)
    {
        foreach ($this->connections as &$connection) {
            if ($connection->dbname == $name) {
                return $connection;
            }
        }
        throw new Exception("ConnectionsManager exception: Not found connection with name \"$name\"");
    }

    /**
     * Установка последнего соединения.
     * @param string имя
     * @throws Exception
     */
    public function setLastConnection(string $name)
    {
        $connection = $this->_findConnection($name);
        if ($connection) {
            $this->lastConnection = &$connection;
        }
    }
}
