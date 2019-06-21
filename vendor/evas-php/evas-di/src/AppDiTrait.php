<?php
/**
 * @package evas-php/evas-di
 */
namespace Evas\Di;

use Evas\Di\Container;

/**
 * Расширение Di-контейнера приложения.
 * @author Egor Vasyakin <e.vasyakin@itevas.ru>
 * @since 1.1
 */
trait AppDiTrait
{
    /**
     * @var Container контейнер приложения
     */
    private static $_di;

    /**
     * Получение di-контейнера.
     * @param Container|null di-контейнер для установки/переустановки
     * @return Container
     */
    public static function di(Container $newDi = null)
    {
        if (null !== $newDi) {
            self::$_di = $newDi;
        }
        if (null === self::$_di) {
            self::$_di = new Container;
        }
        return self::$_di;
    }

    /**
     * Установка параметра в контейнер.
     * @param string|array|object имя параметра или массив/объект параметров
     * @param mixed|null значение параметра или null
     */
    public static function set($name, $value = null)
    {
        static::di()->set($name, $value);
    }

    /**
     * Удаление параметра из контейнера.
     * @param string|array имя параметра или массив имен параметров
     */
    public static function unset($name)
    {
        static::di()->unset($name);
    }

    /**
     * Проверка наличия параметра в контейнере.
     * @param string имя параметра
     * @return bool
     */
    public static function has(string $name): bool
    {
        return isset(static::di()->$name) ? true : false;
    }

    /**
     * Получение параметра или массива параметров контейнера.
     * @param string|array имя параметра или массив имен параметров
     * @return mixed|array of mixed
     */
    public static function get($name)
    {
        return static::di()->get($name);
    }

    /**
     * Вызов параметра-метода контейнера.
     * @param string имя параметра
     * @param array массив аргументов
     * @return mixed результат выполнения метода
     */
    public static function call(string $name, array $arguments = [])
    {
        $var = static::get($name);
        if ($var instanceof \Closure) {
            return call_user_func_array($var, $arguments);
        }
    }
}
