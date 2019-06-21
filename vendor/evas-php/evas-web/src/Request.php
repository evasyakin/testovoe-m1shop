<?php
/**
 * @package evas-php/evas-web
 */
namespace Evas\Web;

use Evas\Http\Request as HttpRequest;

/**
 * Класс запроса веб-приложения.
 * @author Egor Vasyakin <e.vasyakin@itevas.ru>
 * @since 1.0
 */
class Request extends HttpRequest
{
    /**
     * Конструктор.
     */
    public function __construct()
    {
        $this
            ->withMethod($_SERVER['REQUEST_METHOD'])
            ->withUri($_SERVER['REQUEST_URI'])
            ->withHeaders(getallheaders() ?? [])
            ->withUserIp($_SERVER['REMOTE_ADDR'])
            ->withPost($_POST)
            ->withQuery($_GET);
    }
}
