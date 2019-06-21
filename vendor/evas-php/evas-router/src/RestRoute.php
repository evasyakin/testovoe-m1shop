<?php
/**
 * @package evas-php/evas-router
 */
namespace Evas\Router;

use Evas\Router\RestRouter;

/**
 * Класс маршрута с поддержкой REST.
 * @author Egor Vasyakin <e.vasyakin@itevas.ru>
 * @since 1.0
 */
class RestRoute
{
    /**
     * @var RestRouter
     */
    public $router;

    /**
     * @var string путь
     */
    public $path;

    /**
     * Конструктор.
     * @param RestRouter
     * @param string путь
     */
    public function __construct(RestRouter &$router, string $path)
    {
        $this->router = &$router;
        $this->path = $path;
    }

    /**
     * Установка маршрута/маршрутов GET.
     * @param mixed обработчик пути
     * @return self
     */
    public function get($handler = null)
    {
        return $this->_setRestRoute('GET', $handler);
    }

    /**
     * Установка маршрута/маршрутов POST.
     * @param mixed обработчик пути
     * @return self
     */
    public function post($handler = null)
    {
        return $this->_setRestRoute('POST', $handler);
    }

    /**
     * Установка маршрута/маршрутов PUT.
     * @param mixed обработчик пути
     * @return self
     */
    public function put($handler = null)
    {
        return $this->_setRestRoute('PUT', $handler);
    }

    /**
     * Установка маршрута/маршрутов DELETE.
     * @param mixed обработчик пути
     * @return self
     */
    public function delete($handler = null)
    {
        return $this->_setRestRoute('DELETE', $handler);
    }

    /**
     * Установка маршрута/маршрутов PATCH.
     * @param mixed обработчик пути
     * @return self
     */
    public function patch($handler = null)
    {
        return $this->_setRestRoute('PATCH', $handler);
    }

    /**
     * Установка маршрута/маршрутов.
     * @param string метод
     * @param mixed обработчик пути
     * @return self
     */
    private function _setRestRoute(string $method, $handler = null)
    {
        $this->router->route($method, $this->path, $handler);
        return $this;
    }
}
