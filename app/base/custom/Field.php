<?php
namespace base\custom;

use Evas\Validate\Field as ValidateField;

/**
 * Класс валидатора поля.
 */
class Field extends ValidateField
{
    const ERROR_REQUIRED = 'Отсутствует обязательное поле';
    const ERROR_TYPE = 'Ошибка типа поля';
    const ERROR_LENGTH = 'Неверная длина поля';
    const ERROR_PATTERN = 'Проверьте правильность поля';
    const ERROR_EQUAL = 'Не совпадает поле';
}
