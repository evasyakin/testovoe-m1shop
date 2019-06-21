<?php
/**
 * @package evas-php/evas-orm
 */
namespace Evas\Orm;

/**
 * Конфиг базы данных.
 * @author Egor Vasyakin <e.vasyakin@itevas.ru>
 * @since 1.1
 */
class ConnectionConfig
{
    const DRIVER = '';
    const HOST = 'localhost';
    const USERNAME = '';
    const PASSWORD = '';
    const DBNAME = '';
    const CHARSET = 'utf8';
    const OPTIONS = [];

    /**
     * Получение конфига в виде ассоциативного массива.
     * @return array параметры соединения
     */
    public static function get()
    {
        return [
            'driver' => static::DRIVER,
            'host' => static::HOST,
            'username' => static::USERNAME,
            'password' => static::PASSWORD,
            'dbname' => static::DBNAME,
            'options' => static::OPTIONS,
        ];
    }
}
