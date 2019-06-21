<?php
namespace base\custom;

use \Exception;
use Evas\Web\Response;

/**
 * Класс ответа Api V1.
 */
class AppResponse extends Response
{
    /**
     * Отправка ошибки.
     * @param int код ответа
     * @param string сообщение
     * @param array|null заголовки
     */
    public function sendError(int $code, string $error, array $headers = null)
    {
        if ($code === 0) $code = 500;
        try {
            $this->send($code, $error, $headers);
        } catch (Exception $e) {
            $this->send(500, $error, $headers);
        }
        exit();
    }
}
