<?php
/**
 * @package evas-php/evas-base
 */
namespace Evas\Base;

/**
 * Базовый класс приложения.
 * @author Egor Vasyakin <e.vasyakin@itevas.ru>
 * @since 1.0
 */
class App
{
    /**
     * @var string директория приложения
     */
    protected static $_dir;

    /**
     * Установка базовой директории приложения.
     * @param string
     */
    public static function setDir(string $dir)
    {
        static::$_dir = $dir;
    }

    /**
     * Получение базовой директории приложения.
     * @return string
     */
    public static function getDir(): string
    {
        if (null === static::$_dir) {
            static::$_dir = dirname($_SERVER['SCRIPT_FILENAME']) . '/';
        }
        return static::$_dir;
    }
}
