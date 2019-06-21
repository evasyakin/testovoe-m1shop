<?php
/**
 * @package evas-php/evas-router
 */
namespace Evas\Router;

use Evas\Http\RequestInterface;
use Evas\Router\RouteInterface;

/**
 * Базовый класс маршрута.
 * @author Egor Vasyakin <e.vasyakin@itevas.ru>
 * @since 1.0
 */
class BaseRoute implements RouteInterface
{
    /**
     * @var mixed обработчик
     */
    public $handler;

    /**
     * @var array параметры uri
     */
    public $uriParams = [];

    /**
     * @var RequestInterface объект запроса
     */
    public $request;

    /**
     * Конструктор.
     * @param mixed обработчик
     * @param array разобранные параметры uri
     */
    public function __construct($handler, array $uriParams = [])
    {
        $this->handler = &$handler;
        $this->uriParams = &$uriParams;
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
     * Получение параметров uri.
     * @return array
     */
    public function getUriParams(): array
    {
        return $this->uriParams;
    }

    /**
     * Вызов обработчика маршрута.
     * @return bool
     */
    public function handle(): bool
    {
        die ("<b>BaseRoute notice:</b> Сделайте свой класс маршрута, который унаследует класс BaseRoute и опишите в нём обработку маршрута в методе hanlde(). <br>\n Затем установите свой класс маршрута в маршрутизатор через setRouteClass() или routeClass параметр конфига");
    }
}
