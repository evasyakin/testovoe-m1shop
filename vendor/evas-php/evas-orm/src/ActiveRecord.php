<?php
/**
 * @package evas-php/evas-orm
 */
namespace Evas\Orm;

/**
 * Простая реализация ActiveRecord.
 * @author Egor Vasyakin <e.vasyakin@itevas.ru>
 * @since 1.0
 */
abstract class ActiveRecord
{
    /**
     * @var array значения полей записи
     */
    protected $values = [];

    /**
     * @var array дополнительные значения записи
     */
    protected $additionalValues = [];

    /**
     * @var array измененные поля записи
     */
    protected $updated = [];

    /**
     * Получение имени таблицы.
     * @return string
     */
    abstract public static function tableName(): string;

    /**
     * Получение соединения с базой данных.
     * @return Connection
     */
    abstract public static function getDb();

    /**
     * Первичный ключ.
     * @return string
     */
    public static function primaryKey(): string
    {
        return 'id';
    }

    /**
     * Получение id последней записи.
     * @return string
     */
    public static function lastInsertId(): string
    {
        return static::getDb()->lastInsertId(static::tableName()); 
    }

    /**
     * Поля таблицы.
     * @return array
     */
    public static function fields(): array
    {
        return [];
    }

    /**
     * Дефолтные значения новой записи.
     * @return array
     */
    public static function defaultValues(): array
    {
        return [];
    }

    /**
     * Создание записи с сохранением.
     * @param array|object парметры записи
     * @return object extends ActiveRecord
     */
    public static function create($params = null)
    {
        // return (new static($params))->save();
        $object = new static;
        if ($params) {
            if (is_object($params)) $params = (array) $params;
            assert(is_array($params));
            $params = array_merge(static::defaultValues(), $params);
        } else {
            $params = static::defaultValues();   
        }
        if ($params) foreach ($params as $name => $value) {
            $object->$name = $value;
        }
        // $object->updated = $object->fields();
        // $primaryIndex = array_search(static::primaryKey(), $object->updated);
        // if ($primaryIndex !== false) unset($object->updated[$primaryIndex]);
        return $object;
    }

    /**
     * Создание объекта с записью.
     * @param array|object парметры записи
     * @return object extends ActiveRecord
     */
    public static function insert($params = null)
    {
        return static::create($params)->save();
    }

    /**
     * Конструктор.
     * @param array параметры записи
     */
    public function __construct(array $params = null)
    {
        if ($params) foreach ($params as $name => $value) {
            $this->$name = $value;
        }
        $this->updated = [];
    }

    /**
     * Установка значения.
     * @param string имя
     * @param mixed значение
     */
    public function __set(string $name, $value)
    {
        if (in_array($name, static::fields())) {
            $this->values[$name] = $value;
            $this->updated[] = $name;
        } else {
            $this->additionalValues[$name] = $value;
        }
    }

    /**
     * Получение значения.
     * @param string имя
     */
    public function __get(string $name)
    {
        if (in_array($name, static::fields())) {
            return $this->values[$name] ?? null;
        } else {
            return $this->additionalValues[$name] ?? null;
        }
    }

    /**
     * Проверка наличия значения.
     * @param string имя
     * @return bool
     */
    public function __isset(string $name)
    {
        if (in_array($name, static::fields())) {
            return isset($this->values[$name]);
        } else {
            return isset($this->additionalValues[$name]);
        }
    }

    /**
     * Удаление значения.
     * @param string имя
     */
    public function __unset(string $name)
    {
        if (in_array($name, static::fields())) {
            unset($this->values[$name]);
        } else {
            unset($this->additionalValues[$name]);
        }
    }

    /**
     * Сохранение записи.
     * @param array|null параметры для сохранения
     * @return self
     */
    public function save(array $names = null)
    {
        if (! $names) $names = $this->updated;
        if (! $names) return $this;
        $primaryKey = static::primaryKey();
        $primaryValue = $this->$primaryKey;
        $values = [];
        foreach ($names as $name) {
            $values[$name] = $this->__get($name);
        }
        if (null !== $primaryValue) {
            static::getDb()->update(static::tableName(), $values)
                ->where("$primaryKey = ?", [$primaryValue])
                ->one();
        } else {
            static::getDb()->insert(static::tableName(), $values);
            $this->$primaryKey = static::lastInsertId();
        }
        return $this;
    }

    /**
     * Удаление записи.
     * @return QueryResult
     */
    public function delete()
    {
        $primaryKey = static::primaryKey();
        $primaryValue = $this->$primaryKey;
        return static::getDb()->delete(static::tableName())
            ->where("$primaryKey = ?", [$primaryValue])
            ->one();
    }


    /**
     * Поиск записи.
     * @param string запрашиваемые поля
     * @return QueryBuilder
     */
    public static function find(string $fields = '*')
    {
        return static::getDb()->select(static::tableName(), $fields);
    }

    /**
     * Поиск записи по PRIMARY_KEY.
     * @param string|int значение
     * @return self
     */
    public static function findByPrimary($value)
    {
        $primaryKey = static::primaryKey();
        return static::getDb()->select(static::tableName())
            ->where("$primaryKey = ?", [$value])
            ->one()
            ->classObject(get_called_class());
    }

    /**
     * Поиск записи по id.
     * @param string|int id
     * @return self
     */
    public static function findById($id)
    {
        return static::getDb()->select(static::tableName())
            ->where('id = ?', [$id])
            ->one()
            ->classObject(get_called_class());
    }

    /**
     * Поиск записей по sql.
     * @param string sql
     * @param array|null параметры запроса
     * @return QueryResult
     */
    public static function findBySql(string $sql, array $params = null)
    {
        return static::getDb()->query($sql, $params);
    }
}
