<?php
/**
 * @package evas-php/evas-router
 */
namespace Evas\Router;

use Evas\Http\RequestInterface;
use Evas\Router\RouteInterface;

/**
 * Класс списка маршрутов.
 * @author Egor Vasyakin <e.vasyakin@itevas.ru>
 */
class RoutesList implements RouteInterface
{
    /**
     * @var array of Route
     */
    public $routes = [];

    /**
     * @var RequestInterface
     */
    public $request;

    /**
     * Конструктор.
     * @param array of Route
     */
    public function __construct(array &$routes)
    {
        $this->routes = &$routes;
    }

    /**
     * Установка объекта запроса.
     * @param RequestInterface
     * @return self
     */
    public function setRequest(RequestInterface $request)
    {
        $this->request = &$request;
        return $this;
    }

    /**
     * Получение объекта запроса.
     * @return RequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Вызов обработчиков маршрутов.
     * @return bool
     */
    public function handle(): bool
    {
        foreach ($this->routes as &$route) {
            if (!$route instanceof RouteInterface) {
                continue; 
            }
            $route->setRequest($this->request);
            if (false === $route->handle()) {
                return false;
            }
        }
        return true;
    }
}
