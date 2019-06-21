<?php
namespace collection\validators;

use base\custom\Fieldset;
use collection\validators\CollectionIdField;
use collection\validators\CollectionNameField;

/**
 * Валидатор сохранения альбома.
 */
class SaveCollectionFieldset extends Fieldset
{
    /**
     * Переопределяем конструктор.
     * @param array [имя поля => валидатор] или [имя поля => параметры валидатора]
     */
    public function __construct(array $params = null)
    {
        // устанавливаем поля
        $this->setFields([
            'id' => new CollectionIdField(['required' => false]),
            'name' => new CollectionNameField,
        ]);
        parent::__construct($params);
    }
}
