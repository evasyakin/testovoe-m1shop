<?php
/**
 * @package evas-php/evas-router
 */
namespace Evas\Router;

use Evas\Router\BaseRoute;
use Evas\Router\RoutesList;

/**
 * Класс маршрутизации.
 * @author Egor Vasyakin <e.vasyakin@itevas.ru>
 * @since 1.0
 */
class Router
{
    /**
     * @var array алиасы шаблонов
     */
    protected $_patterns = [
        ':int' => '[0-9]{1,11}',
        ':any' => '.*',
    ];

    /**
     * @var array маршруты
     */
    protected $_routes = [
        'ALL' => [],
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'DELETE' => [],
        'PATCH' => [],
    ];

    /**
     * @var mixed обработчик по умолчанию
     */
    protected $_default;

    /**
     * @var string имя класса маршрута
     */
    protected $_routeClass = BaseRoute::class;

    /**
     * Добавление шаблона.
     * @param string алиас
     * @param string шаблон
     * @return self
     */
    public function pattern(string $alias, string $pattern)
    {
        $this->_patterns[$alias] = $pattern;
        return $this;
    }

    /**
     * Добавление шаблонов.
     * @param array шаблоны
     * @return self
     */
    public function patterns(array $patterns)
    {
        $this->_patterns = array_merge($this->_patterns, $patterns);
        return $this;
    }

    /**
     * Добавление маршрута.
     * @param string метод
     * @param string относительный path
     * @param mixed обработчик
     * @return self
     */
    public function route(string $method, string $path, $handler)
    {
        $method = strtoupper($method);
        $pattern = $this->preparePathPattern($path);
        $this->_routes[$method][$pattern] = $handler;
        return $this;
    }

    /**
     * Добавление маршрутов метода.
     * @param string метод
     * @param array маршруты
     * @return self
     */
    public function routesByMethod(string $method, array $routes)
    {
        foreach ($routes as $path => $handler) {
            $this->route($method, $path, $handler);
        }
        return $this;
    }

    /**
     * Добавление маршрутов.
     * @param array маршруты
     * @return self
     */
    public function routes(array $routes)
    {
        foreach ($routes as $method => $local) {
            $this->routesByMethod($method, $local);
        }
        return $this;
    }

    /**
     * Установка класса маршрута.
     * @param string имя класса
     * @return self
     */
    public function routeClass(string $className)
    {
        $this->_routeClass = $className;
        return $this;
    }

    /**
     * Установка обработчика по умолчанию
     * @param mixed
     * @return self
     */
    public function default($handler)
    {
        $this->_default = &$handler;
        return $this;
    }


    /**
     * Конструктор.
     * @param array|null маршруты
     */
    public function __construct(array $config = null)
    {
        if ($config) {
            if (!empty($config['routes'])) $this->routes($config['routes']);
            if (!empty($config['patterns'])) $this->setPatterns($config['patterns']);
            if (!empty($config['routeClass'])) $this->setRouteClass($config['routeClass']);
        }
    }

    /**
     * Подготовка пути к регулярному выражению
     * @param string путь
     * @return string подготовленный путь
     */
    public function preparePathPattern(string $path): string
    {
        $path = str_replace('/', '\/', $path);
        foreach ($this->_patterns as $alias => $pattern) {
            $path = str_replace($alias, $pattern, $path);
        }
        $path = str_replace('?', '\?', $path);
        return "/^$path$/";
    }



    /**
     * Маршрутизация запроса.
     * @param string uri
     * @param string метод
     * @param bool искать все совпадения
     * @return RouteInterface
     */
    public function handle(string $uri, string $method, bool $allMatches = false)
    {
        $routes = array_merge($this->_routes['ALL'], $this->_routes[$method]);
        if ($routes) foreach ($routes as $pattern => $handler) {
            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                if ($handler instanceof static) {
                    $handlerUri = array_shift($matches) ?? '';
                    return $handler->handle($handlerUri, $method, $allMatches);
                }
                $route = new $this->_routeClass($handler, $matches);
                if (false === $allMatches) {
                    return $route;
                } else {
                    $finded[] = new $route;
                }
            }
        }
        if (! empty($finded)) {
            return new RoutesList($finded);
        }
        return new $this->_routeClass($this->_default);
    }
}
