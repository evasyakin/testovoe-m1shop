<?php
/**
 * @package evas-php/evas-web
 */
namespace Evas\Mvc;

use Evas\Http\RequestInterface;
use Evas\Http\ResponseInterface;
use Evas\Base\App;

/**
 * Контроллер для обработки запросов.
 * @author Egor Vasyakin <e.vasyakin@itevas.ru>
 * @since 1.0
 */
class Controller
{
    /**
     * @static string дефолтный метод
     */
    const DEFAULT_METHOD = 'handle';

    /**
     * @static string директория файлов отображения
     */
    const VIEW_PATH = 'view/';

    /**
     * @var Request
     */
    public $request;

    /**
     * @var Response
     */
    public $response;

    /**
     * @var array параметры uri
     */
    public $uriParams = [];

    /**
     * Устанока объекта запроса.
     * @param Request
     * @return self
     */
    public function setRequest(RequestInterface $request)
    {
        $this->request = &$request;
        return $this;
    }

    /**
     * Установка uri параметров запроса.
     * @param array
     * @return self
     */
    public function setUriParams(array $uriParams = [])
    {
        $this->uriParams = &$uriParams;
        return $this;
    }

    /**
     * Установка объекта ответа.
     * @param Response
     * @return self
     */
    public function setResponse(ResponseInterface $response)
    {
        $this->response = &$response;
        return $this;
    }

    /**
     * Рендер файла.
     * @param string имя файла
     * @param array параметры
     * @return bool удалось ли считать файл
     */
    public function render(string $filename, array $params = []): bool
    {
        $filename = App::getDir() . static::VIEW_PATH . $filename;
        if (!is_readable($filename) || !is_file($filename)) {
            return false;
        }
        extract($params);
        include $filename;
        return true;
    }
}
