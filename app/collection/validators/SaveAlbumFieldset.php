<?php
namespace collection\validators;

use base\custom\Fieldset;
use collection\validators\CollectionIdField;
use collection\validators\AlbumIdField;
use collection\validators\AlbumNameField;

/**
 * Валидатор сохранения альбома.
 */
class SaveAlbumFieldset extends Fieldset
{
    /**
     * Переопределяем конструктор.
     * @param array [имя поля => валидатор] или [имя поля => параметры валидатора]
     */
    public function __construct(array $params = null)
    {
        // устанавливаем поля
        $this->setFields([
            'id' => new AlbumIdField(['required' => false]),
            'collection_id' => new CollectionIdField,
            'name' => new AlbumNameField,
        ]);
        parent::__construct($params);
    }
}
