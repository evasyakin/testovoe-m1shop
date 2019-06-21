<?php
namespace base\custom;

use base\custom\AppController;
use profile\models\AuthUser;

/**
 * Контроллера Api V1.
 */
class ApiV1Controller extends AppController
{
    /**
     * Обработчик по умолчанию
     * @param string действие
     * @return object
     */
    public function handle(string $action)
    {
        if (method_exists($this, $action)) {
            call_user_func([$this, $action]);
        } else {
            $this->response->sendError(404, 'Обработчик запроса не найден');
        }
    }
}
