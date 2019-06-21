<?php
namespace base\custom;

use base\custom\AppResponse;
use Evas\Mvc\Controller;

/**
 * Базовый класс контроллера приложения.
 */
class AppController extends Controller
{
    /**
     * Конструктор.
     */
    public function __construct()
    {   
        // устанавливаем объект ответа
        $this->setResponse(new AppResponse);
    }
}
