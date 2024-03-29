<?php
/**
 * @package evas-php/evas-store
 */
namespace Evas\Web\Store;

use Evas\Web\Store\Storage;

/**
 * Класс для session.
 * @author Egor Vasyakin <e.vasyakin@itevas.ru>
 * @since 1.0
 */
class Session extends Storage
{
    /**
     * @var string id сессии
     */
    protected $_id;

    /**
     * Конструктор.
     */
    public function __construct() {
        session_start();
        $this->_id = session_id();
        $this->_params = &$_SESSION;
    }

    /**
     * Закрытие всех сессий.
     */
    public static function destroyAll()
    {
        session_destroy();
    }

    /**
     * Установка параметра или параметров.
     * @param string|array имя параметра или параметры
     * @param string|null значение параметра
     */
    public function set($name, $value = null)
    {
        assert(is_string($name) || is_array($name) || is_object($name));
        if (is_string($name)) {
            // установка параметра
            $this->__set($name, $value);
        } else if (is_array($name) || is_object($name)) {
            // итеративная установка параметров
            foreach ($name as $subname => $value) {
                $this->set($subname, $value);
            }
        }
    }
}
