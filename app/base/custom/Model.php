<?php
namespace base\custom;

use base\App;
use Evas\Orm\ActiveRecord;

/**
 * Класс модели.
 */
class Model extends ActiveRecord
{
    const DEFAULT_LIMIT = 50;

    /**
     * Получение имени таблицы.
     * @return string
     */
    public static function tableName(): string
    {
        if (!empty(static::$tableName)) {
            return static::$tableName;
        }
        $className = get_called_class();
        $lastSlash = strrpos($className, '\\');
        $className = substr($className, $lastSlash + 1);
        return strtolower(preg_replace('/([a-z0-9]+)([A-Z]{1})/', '$1_$2', $className)) . 's';
    }

    /**
     * Получение соединения с базой данных.
     * @return Evas\Orm\Connection
     */
    public static function getDb()
    {
        return App::getDb();
    }

    /**
     * Поля таблицы.
     * @return array
     */
    public static function fields(): array
    {
        return [
            'id',
            'create_time',
        ];
    }

    /**
     * Получение времени создания записи в формате вывода.
     * @return string
     */
    public function getCreateTime()
    {
        return date('d.m.Y в H:i', strtotime($this->create_time));
    }

    /**
     * Переопределение создания записи.
     * @param array|object|null параметры записи 
     * @return self
     */
    public static function create($params = null)
    {
        if ($params) {
            if (is_object($params)) $params = (array) $params;
            assert(is_array($params));
            foreach ($params as $key => $value) {
                $params[$key] = addslashes($value);
            }
        }
        $enemy = parent::create($params);
        $enemy->create_time = date('Y-m-d H:i:s');
        return $enemy;
    }

    /**
     * Экстрактор полей модели.
     * @param array поля
     * @return object
     */
    public function extractFields(array $fields)
    {
        $shared = (object) [];
        foreach ($fields as &$field) {
            $shared->$field = $this->$field;
        }
        return $shared;
    }
}
