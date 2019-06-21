<?php
namespace base\config;

use Evas\Orm\Connection;

/**
 * Класс соединения с базой данных сервиса.
 */
class CdCollectionDb extends Connection
{
    public $driver = 'mysql';
    public $host = 'localhost';
    public $username = '***';
    public $password = '***';
    public $dbname = 'cd-collection-1';
}
