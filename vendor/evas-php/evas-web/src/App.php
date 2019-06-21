<?php
/**
 * @package evas-php/evas-web
 */
namespace Evas\Web;

use Evas\Base\App as BaseApp;
use Evas\Web\Request;
use Evas\Web\Response;
use Evas\Web\Store\Cookie;
use Evas\Web\Store\Session;

/**
 * Класс веб-приложения.
 * @author Egor Vasyakin <e.vasyakin@itevas.ru>
 * @since 1.0
 */
class App extends BaseApp
{
    /**
     * @var string базовый путь uri приложения
     */
    protected static $_path;

    /**
     * @var string хост приложения
     */
    protected static $_host;

    /**
     * @var string базовый uri приложения
     */
    protected static $_uri;
    /**
     * @var string имя класс запроса
     */
    protected static $_requestClass = Request::class;

    /**
     * @var string имя класс ответа
     */
    protected static $_responseClass = Response::class;

    /**
     * Установка базового пути uri приложения.
     * @param string
     */
    public static function setPath(string $path)
    {
        static::$_path = $path;
    }

    /**
     * Установка имени класса запроса.
     * @param string
     */
    public static function setRequestClass(string $requestClass)
    {
        static::$_requestClass = $requestClass;
    }

    /**
     * Установка имени класса ответа.
     * @param string
     */
    public static function setResponseClass(string $responseClass)
    {
        static::$_responseClass = $responseClass;
    }


    /**
     * Получение базового пути uri приложения.
     * @return string
     */
    public static function getPath(): string
    {
        if (null === static::$_path) {
            static::$_path = substr(str_replace($_SERVER['DOCUMENT_ROOT'], '', static::getDir()), 0, -1);
        }
        return static::$_path;
    }

    /**
     * Получение хоста приложения.
     * @return string
     */
    public static function getHost(): string
    {
        if (null === static::$_host) {
            static::$_host = $_SERVER['SERVER_NAME'];
        }
        return static::$_host;
    }

    /**
     * Получение базового uri ариложения.
     * @return string
     */
    public static function getUri(): string
    {
        if (null === static::$_uri) {
            $protocol = !empty($_SERVER['HTTPS']) ? 'https' : 'http';
            // static::$_uri = "$protocol://$host" . (empty($path) ? '/' : $path);
            static::$_uri = "$protocol://" . static::getHost() . static::getPath();
        }
        return static::$_uri;
    }

    /**
     * Получение запроса.
     * @return Request
     */
    public static function request()
    {
        static $request = null;
        if (null === $request) {
            $request = (new static::$_requestClass)
                ->withUri(str_replace(static::getPath(), '', $_SERVER['REQUEST_URI']));
        }
        return $request;
    }

    /**
     * Получение ответа.
     * @return Response
     */
    public static function response()
    {
        static $response = null;
        if (null === $response) {
            $response = (new static::$_responseClass);
        }
        return $response;
    }

        /**
     * Получение объекта cookie.
     * @return Cookie
     */
    public static function cookie()
    {
        static $cookie = null;
        if (null === $cookie) {
            $cookie = new Cookie;
            $cookie->setHost(static::getHost());
        }
        return $cookie;
    }

    /**
     * Получение объекта session.
     * @return Session
     */
    public static function session()
    {
        static $session = null;
        if (null === $session) {
            $session = new Session;
        }
        return $session;
    }
}
