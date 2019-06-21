<?php
/**
 * @package evas-php/evas-web
 */
namespace Evas\Web;

use Evas\Http\Response as HttpResponse;

/**
 * Класс ответа веб-приложения.
 * @author Egor Vasyakin <e.vasyakin@itevas.ru>
 * @since 1.0
 */
class Response extends HttpResponse
{
    /**
     * Отправка.
     * @param int|null код статуса
     * @param string|null тело
     * @param array|null заголовки
     */
    public function send(int $code = null, string $body = null, array $headers = null)
    {
        parent::send($code, $body, $headers);
        $this->applyHeaders();
        echo $this->body;
    }

    /**
     * Применение установленных заголовков.
     * @return self
     */
    public function applyHeaders()
    {
        header("HTTP/1.1 $this->statusCode $this->statusText");
        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }
        return $this;
    }
}
