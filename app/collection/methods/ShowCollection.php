<?php
namespace collection\methods;

use collection\models\Collection;

/**
 * Получение коллекции для показа.
 */
class ShowCollection
{
    public static function run(int $id)
    {
        return Collection::findById($id)->extract();
    }
}
