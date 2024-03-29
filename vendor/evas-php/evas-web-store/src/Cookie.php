<?php
/**
 * @package evas-php/evas-store
 */
namespace Evas\Web\Store;

use Evas\Web\Store\Storage;

/**
 * Класс для cookie.
 * @author Egor Vasyakin <e.vasyakin@itevas.ru>
 * @since 1.0
 */
class Cookie extends Storage
{
    /**
     * @var string домен для cookie
     */
    public $host;

    /**
     * @var string путь для cookie
     */
    public $path = '/';

    /**
     * Конструкторю
     */
    public function __construct()
    {
        $this->_params = &$_COOKIE;
    }

     /**
     * Удаление параметра.
     * @param string имя параметра
     */
    public function __unset(string $name)
    {
        // установка куки
        $this->setCookie($name, 'del', -100);
        // удаление параметра
        parent::__unset($name);
    }

    /**
     * Установка параметра или параметров.
     * @param string|array имя параметра или параметры
     * @param string|null значение параметра
     * @param int время жизни относительно текущего времени
     */
    public function set($name, $value = null, int $alive = 0)
    {
        assert(is_string($name) || is_array($name) || is_object($name));
        if (is_string($name)) {
            // установка куки
            // setcookie($name, $value, time()+ $alive, $this->path, $this->host, false, true);
            $this->setCookie($name, $value, $alive);
            // установка параметра
            $this->__set($name, $value);
        } else if (is_array($name) || is_object($name)) {
            // итеративная установка параметров
            foreach ($name as $subname => $value) {
                $this->set($subname, $value, $alive);
            }
        }
    }

    /**
     * Очистка параметров.
     */
    public function clean()
    {
        foreach ($this->_params as $name => $value) {
            $this->__unset($name);
        }
        parent::clean();
    }

    /**
     * Установка хоста.
     * @param string
     * @return self
     */
    public function setHost(string $host)
    {
        $this->host = $host;
        return $this;
    } 

    /**
     * Установка пути.
     * @param string
     * @return self
     */
    public function setPath(string $path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * Установка cookie-заголовка.
     * @param string имя
     * @param string значение
     * @param int время жизни
     */
    public function setCookie(string $name, string $value, int $alive = 0)
    {
        setcookie($name, $value, time()+ $alive, $this->path, $this->host, false, true);
    }
}
