<?php
/**
 * @package evas-php/evas-validate
 */
namespace Evas\Validate;

use \Exception;
use Evas\Validate\Field;

/**
 * Валидация набора полей.
 * @author Egor Vasyakin <e.vasyakin@itevas.ru>
 * @since 1.0
 */
class Fieldset
{
    /**
     * @var array [имя поля => валидатор]
     */
    public $fields = [];

    /**
     * @var array  [имя поля => ошибка]
     */
    public $errors = [];

    /**
     * @var string ошибка
     */
    public $error;

    /**
     * @var string класс исключения для выброса
     */
    public $exceptionClass = Exception::class;

    /**
     * @var int код ошибки для выброса исключения
     */
    public $exceptionCode = 400;

    /**
     * @var array [имя поля => значение]
     */
    public $values = [];

    /**
     * Конструктор.
     * @param array [имя поля => валидатор] или [имя поля => параметры валидатора]
     */
    public function __construct(array $params = null)
    {
        if ($params) $this->setFields($params);
    }

    /**
     * Установка валидаторов полей.
     * @param array [имя поля => валидатор] или [имя поля => параметры валидатора]
     * @return self
     */
    public function setFields(array $params)
    {
        foreach ($params as $name => $field) {
            $this->setField($name, $field);
        }
    }

    /**
     * Установка валидатора поля.
     * @param string имя поля
     * @param array|Field валидатор или параметры валидатора
     * @return self
     */
    public function setField(string $name, $field)
    {
        assert(is_array($field) || $field instanceof Field || $fields instanceof static);
        if (is_array($field)) {
            $field = new Field($field);
        }
        if ($field instanceof Field) {
            $field->name = $name;
            $this->fields[$name] = $field;
        }
        return $this;
    }

    /**
     * Проверка значений на валидность списка полей.
     * @param array|object значения [поле => значение]
     * @param bool поддержка множественых ошибок
     * @throws \Exception если 1 аргумент не того типа
     * @return bool
     */
    public function isValid($values, $multipleErrors = false, $errorsMap = false): bool
    {
        assert(is_array($values) || is_object($values));
        $this->errors = [];
        $this->error = '';
        $this->values = [];
        foreach ($this->fields as $name => $field) {
            $isset = isset($values[$name]);
            $value = $values[$name] ?? null;

            if ($field instanceof static) {
                $field->isValid($value, $multipleErrors, $errorsMap);
            } 
            else if ($field instanceof Field) {

                if (false === $field->isValid($value, $isset)) {
                    $this->setError($field->error, $name, $multipleErrors, $errorsMap);
                    if (false === $multipleErrors) {
                        return false;
                    }
                }
                if (empty($field->error) && !empty($field->equal)) {
                    $equalValue = $values[$field->equal] ?? null;
                    if ($equalValue !== $value) {
                        $this->setError(Field::ERROR_EQUAL . $field->name, $name, $multipleErrors, $errorsMap);
                        if (false === $multipleErrors) {
                            return false;
                        }
                    }
                }
                $this->values[$name] = $field->value;
            }
        }
        if (!empty($this->errors)) {
            return false;
        }
        return true;
    }

    /**
     * Установка ошибки/ошибок.
     * @param string текст ошибки
     * @param string имя поля
     * @param bool множественные ошибки
     * @param bool использовать маппинг ошибок
     */
    public function setError(string $message, string $fieldName, bool $multipleErrors = false, bool $errorsMap = false)
    {
        $this->error = $message;
        if (true === $multipleErrors) {
            if (true === $errorsMap) {
                $this->errors[$fieldName] = $message;
            } else {
                $this->errors[] = $message;
            }
        }
    }

    /**
     * Проверка значения на валидность полю с выбрасом исключения.
     * @param array|object значения [поле => значение]
     * @throws Exception
     */
    public function throwIfNotValid($values)
    {
        if (false === $this->isValid($values)) {
            $exceptionClass = $this->exceptionClass;
            throw new $exceptionClass($this->error, $this->exceptionCode);
        }
    }
}
