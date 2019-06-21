<?php
namespace collection\models;

use base\custom\Model;
use collection\models\Album;

/**
 * Модель коллекции.
 */
class Collection extends Model
{
    /**
     * @static string ошибка коллекция не найдена
     */
    const ERROR_NOT_FOUND = 'Коллекция не найдена';

    /**
     * Поля таблицы.
     * @return array
     */
    public static function fields(): array
    {
        return array_merge(parent::fields(), [
            'name',
        ]);
    }

    /**
     * Получение альбомов коллекции.
     * @return Array of Album | null
     */
    public function getAlbums()
    {
        return Album::findByCollectionId($this->id);
    }

    /**
     * Экстрактор альбомов коллекции.
     * @return array of object | null
     */
    public function extractAlbums()
    {
        $albums = $this->getAlbums();
        foreach ($albums as &$album) {
            $album = $album->extract();
        }
        return $albums;
    }

    /**
     * Экстрактор коллекции.
     * @return array
     */
    public function extract()
    {
        return [
            'name' => $this->name,
            'albums' => $this->extractAlbums(),
        ];
    }

    /**
     * Экстрактор сохраненной коллекции.
     */
    public function extractSaved()
    {
        return [
            'name' => $this->name,
        ];
    }
}
