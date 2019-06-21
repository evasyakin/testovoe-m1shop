<?php
/**
 * @package evas-php/evas-mvc
 */
namespace Evas\Mvc;

use Evas\Mvc\Controller;
use Evas\Router\BaseRoute;

/**
 * Класс маршрута с поддержкой контроллеров.
 * @author Egor Vasyakin <e.vasyakin@itevas.ru>
 * @since 1.0
 */
class Route extends BaseRoute
{
    /**
     */
    public $viewControllerClass = Controller::class;

    /**
     * Установка класса контроллера по умолчанию.
     * @param string
     */
    public function setViewControllerClass(string $viewControllerClass)
    {
        $this->viewControllerClass = $viewControllerClass;
    }

    /**
     * Получение нового контроллера по умолчанию
     * @param string класс контроллера, если нужен не стандартный
     * @return object
     */
    public function newController(string $controllerClass = null)
    {
        if (null === $controllerClass) $controllerClass = $this->viewControllerClass;
        return (new $controllerClass)
            ->setRequest($this->getRequest())
            ->setUriParams($this->getUriParams());
    }

    /**
     * Вызов обработчика маршрута.
     * @return bool
     */
    public function handle(): bool
    {
        if (
            (is_array($this->handler) && ( 
                true === $this->_handleClass($this->handler) || 
                true === $this->_handleList($this->handler) )) || 
            (is_string($this->handler) && true === $this->_handleFile($this->handler)) || 
            ($this->handler instanceof \Closure && true === $this->_handleClosure($this->handler))
        ) {
            return true;
        }
        return false;
    }

    /**
     * Вызов обработчика в виде имени файла.
     * @param string обработчик
     * @return bool
     */
    protected function _handleFile(string $handler): bool
    {
        return $this->newController()->render($handler);
    }

    /**
     * Вызов обработчика в виде замыкания.
     * @param string обработчик
     * @return bool
     */
    protected function _handleClosure(\Closure $handler): bool
    {
        if ($handler instanceof \Closure) {
            $view = $this->newController();
            $handler = $handler->bindTo($view);
            call_user_func_array($handler, $this->uriParams);
            return true;
        }
        return false;
    }

    /**
     * Вызов обработчика в виде имени класса.
     * @param string обработчик
     * @return bool
     */
    protected function _handleClass(array $handler): bool
    {
        if (count($handler) > 0 && is_string($handler[0])) {
            if (class_exists($handler[0], true)) {
                $controller = $this->newController($handler[0]);
                $method = count($handler) > 1 ? $handler[1] : $controller::DEFAULT_METHOD;
                if (method_exists($controller, $method)) {
                    call_user_func_array([$controller, $method], $this->getUriParams());
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Вызов обработчика в виде списка.
     * @param string обработчик
     * @return bool
     */
    protected function _handleList(array $handler): bool
    {
        foreach ($handler as &$singleHandler) {
            if (
                (is_array($singleHandler) && false === $this->_handleClass($singleHandler)) ||
                (is_string($singleHandler) && false === $this->_handleFile($singleHandler)) ||
                ($singleHandler instanceof \Closure && false === $this->_handleClosure($singleHandler))
            ) {
                return false;
            }
        }
        return true;
    } 
}
