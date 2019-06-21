<?php
namespace base\helpers;

use base\App;

/**
 * Логгер.
 */
class Logger
{
    /**
     * @static string имя файла журнала по умолчанию
     */
    const DEFAULT_FILENAME = 'log.txt';

    /**
     * @var string имя файла журнала
     */
    public static $filename;

    /**
     * Установка имени файла журнала.
     * @param string
     */
    public static function setFilename(string $filename)
    {
        static::$filename = $filename;
    }

    /**
     * Получение имени файла журнала.
     * @return string
     */
    public static function getFilename(): string
    {
        if (empty(static::$filename)) {
            static::setFilename(App::getDir() . static::DEFAULT_FILENAME);
        }
        return static::$filename;
    }

    /**
     * Запись в лог.
     * @param mixed сообщение
     */
    public static function write($message)
    {
        if (is_object($message) || is_array($message)) {
            $message = json_encode($message);
        }
        $time = date('Y-m-d H:i:s');
        file_put_contents(static::getFilename(), "[$time] $message\n", FILE_APPEND);
    }
}
