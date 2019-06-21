<?php
/**
 * @package evas-php/evas-router
 */
namespace Evas\Router;

use Evas\Http\RequestInterface;

/**
 * Интерфейс маршрута.
 * @author Egor Vasyakin <e.vasyakin@itevas.ru>
 * @since 1.0
 */
interface RouteInterface
{
    /**
     * Конструктор.
     * @param mixed обработчик
     * @param array разобранные параметры uri
     */
    public function __construct($handler, array $uriParams = []);

    /**
     * Установка объекта запроса.
     * @param RequestInterface
     * @return self
     */
    public function setRequest(RequestInterface $request);

    /**
     * Получение объекта запроса.
     * @return RequestInterface
     */
    public function getRequest();

    /**
     * Вызов обработчиков маршрутов.
     * @return bool
     */
    public function handle(): bool;
}
