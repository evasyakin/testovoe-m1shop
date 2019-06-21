<?php
/**
 * @package evas-php/evas-validate
 */
namespace Evas\Validate;

use \Exception;

/**
 * Валидация поля.
 * @author Egor Vasyakin <e.vasyakin@itevas.ru>
 * @since 1.0
 */
class Field
{
    /**
     * @var string имя поля
     */
    public $name;

    /**
     * @var string псевдоним поля
     */
    public $label;

    /**
     * @var string пришедшее текущее значение в поле
     */
    public $value;

    /**
     * @var string тип поля
     */
    public $type = 'string';

    /**
     * @var bool проверять ли тип значения поля
     */
    public $typeChecked = false;

    /**
     * @var bool обязательность
     */
    public $required = true;

    /**
     * @var int минимальная длина строки или значение диапазона для чисел
     */
    public $min;

    /**
     * @var int максимальная длина строки или значение диапазона для чисел
     */
    public $max;

    /**
     * @var string регулярное выражение
     */
    public $pattern;

    /**
     * @var array совпадения по регулярке
     */
    public $matches;

    /**
     * @var string поле с совпадающим значением
     */
    public $equal;

    /**
     * @var mixed значение по умолчанию
     */
    public $default;

    /**
     * @var string сообщение ошибки
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
     * @var string кастомное сообщение при отсутствии, если обязательно
     */
    public $requiredError;

    /**
     * @var string кастомное сообщение при отсутствии, если обязательно
     */
    public $typeError;

    /**
     * @var string кастомное сообщение при ошибке длины
     */
    public $lengthError;

    /**
     * @var string кастомное сообщение при ошибке регулярки
     */
    public $patternError;

    /**
     * @var string кастомное сообщение при несовпадении значения в совпадающих полях
     */
    public $equalError;


    const ERROR_REQUIRED = 'error.required in';
    const ERROR_TYPE = 'error.type in';
    const ERROR_LENGTH = 'error.length in';
    const ERROR_PATTERN = 'error.pattern in';
    const ERROR_EQUAL = 'error.equal in';


    /**
     * Конструктор.
     * @param array|object параметры валидатора
     */
    public function __construct($params = null)
    {
        if ($params) {
            assert(is_array($params) || is_object($params));
            foreach ($params as $name => $value) {
                $this->$name = $value;
            }
        }
    }

    /**
     * Проверка значения на валидность полю.
     * @param mixed значение
     * @param bool пришло ли поле
     * @return bool
     */
    public function isValid($value, $isset = true): bool
    {
        $this->error = null;
        $this->value = $value;
        
        // если значение пустое
        if (empty($value)) {
            $value = $this->default;
            if (empty($value)) {
                // если обязательное поле пустое
                if ($this->required == true) {
                    return $this->setError(
                        $this->requiredError ?? $this->buildError(static::ERROR_REQUIRED)
                    );
                }
                // если необязательное поле не пришло
                if ($isset === false && $this->required == false) {
                    return true;
                }
            }
        }

        // если значение пустое
        if (null === $value) {
            $value = $this->default;
            if (null === $value) {
                // если обязательное поле пустое
                if ($this->required == true) {
                    return $this->setError($this->requiredError);
                }
                // если необязательное поле не пришло
                if ($isset === false && $this->required == false) {
                    return true;
                }
            }
        }

        // валидация типа поля
        if (false !== $this->typeChecked) {
            $typeCheck = 'is_' . $this->type;
            if (is_callable($typeCheck)) {
                if (! call_user_func($typeCheck, $value)) {
                    return $this->setError(
                        $this->typeError ?? $this->buildError(static::ERROR_TYPE)
                    ); 
                }
            }
        }

        // валидация длины строки или попадания числа в диапазон
        if (null !== $this->min || null !== $this->max) {
            if ('string' === $this->type) {
                $len = mb_strlen($value);
            } else {
                $len = $value;    
            }
            if (null !== $this->min && $len < $this->min || null !== $this->max && $len > $this->max) {
                return $this->setError(
                    $this->lengthError ?? $this->buildError(static::ERROR_LENGTH)
                );
            }
        }

        // валидация по регулярке
        if (null !== $this->pattern && !preg_match($this->pattern, $value, $this->matches)) {
            return $this->setError(
                $this->patternError ?? $this->buildError(static::ERROR_PATTERN)
            );
        }
        return true;
    }

    /**
     * Получение сборочной ошибки.
     * @param string константная ошибка
     * @return string
     */
    public function buildError(string $message): string
    {
        return "$message " . ($this->label ?? $this->name);
    }

    /**
     * Установка ошибки.
     * @param string сообщение ошибки
     * @return false
     */
    public function setError(string $message = null)
    {
        $this->error = $message;
        return false;
    }

    /**
     * Проверка значения на валидность полю с выбрасом исключения.
     * @param mixed значение
     * @param bool пришло ли поле
     * @throws Exception
     */
    public function throwIfNotValid($value, bool $isset = true)
    {
        if (false === $this->isValid($value, $isset)) {
            $exceptionClass = $this->exceptionClass;
            throw new $exceptionClass($this->error, $this->exceptionCode);
        }
    }
}
