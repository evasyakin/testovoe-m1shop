<?php
namespace collection\models;

use \Exception;
use base\custom\Model;
use collection\models\Collection;

/**
 * Модель альбома.
 */
class Album extends Model
{
    /**
     * @static string ошибка альбом не найден
     */
    const ERROR_NOT_FOUND = 'Альбом не найден';

    /**
     * Поля таблицы.
     * @return array
     */
    public static function fields(): array
    {
        return array_merge(parent::fields(), [
            'collection_id', 'name', 'image', 'artist', 'year', 'duration', 
            'payed_date', 'payed_sum', 'store_key', 'deleted',
        ]);
    }

    /**
     * Переопределение создания записи.
     * @param array|object|null параметры записи 
     * @return self
     */
    public static function create($params = null)
    {
        if (! empty($params)) {
            $params = (object) $params;
            $collection_id = $params->collection_id;
            $collection = Collection::findById($collection_id);
            if (empty($collection)) throw new Exception(Collection::ERROR_NOT_FOUND, 404);
        }
        return parent::create($params);
    }

    /**
     * Поиск альбомов по id коллекции.
     */
    public static function findByCollectionId($id)
    {
        return static::find()
            ->where('collection_id = ?', [$id])
            ->query()
            ->classObjectAll(get_called_class());
    }

    /**
     * Получение коллекции альбома.
     * @return Collection | null
     */
    public function getCollection()
    {
        return Collection::findById($this->collection_id);
    }

    /**
     * Мягкое удаление альбома.
     */
    public function softDeleted()
    {
        $this->deleted = 1;
        $this->save();
    }

    /**
     * Экстрактор альбома.
     * @return array
     */
    public function extract()
    {
        return $this->extractFields([
            'id', 'collection_id', 'name', 'image', 'artist', 'year', 'duration', 
            'payed_date', 'payed_sum', 'store_key'
        ]);
    }
}
