<?php
namespace base\custom;

use base\App;
use base\custom\AppController;

/**
 * Контроллер страниц сайта.
 */
class PagesController extends AppController
{
    /**
     * @static string путь к директории лайаутов.
     */
    const LAYOUTS_PATH = 'layouts/';

    /**
     * @static string путь к директории компонентов кабинета.
     */
    const CABINET_COMPONENTS_PATH = 'cabinet-components/';

    /**
     * Рендер лайаута.
     * @param string имя файла
     * @param array параметры для предачи
     */
    public function layout(string $filename, array $params = [])
    {
        $this->render(static::LAYOUTS_PATH . "$filename.php", $params);
    }

    /**
     * Получение содержимого файла.
     * @param string имя файла
     */
    public function component(string $filename)
    {
        $component = @file_get_contents(App::getDir() . '/view/' . static::CABINET_COMPONENTS_PATH . "$filename");
        return json_encode(str_replace(["\r","\n", "\t"], '', trim($component)));
    }
}
