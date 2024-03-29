<?php
/**
 * @package evas-php/evas-orm
 */
namespace Evas\Orm;

use Evas\Orm\QueryBuilder;

/**
 * Сборщик JOIN.
 * @author Egor Vasyakin <e.vasyakin@itevas.ru>
 * @since 1.0
 */
class JoinBuilder
{
    /**
     * @var QueryBuilder
     */
    public $queryBuilder;

    /**
     * @var string тип склейки
     */
    public $type;

    /**
     * @var string склеиваемая таблица или запрос записей склеиваемой таблицы
     */
    public $from;

    /**
     * @var string псевдоним склеиваемой таблицы
     */
    public $as;

    /**
     * @var string условие склеивания
     */
    public $on;

    /**
     * @var array параметры для экранирования
     */
    public $params = [];

    /**
     * Конструктор.
     * @param QueryBuilder
     * @param string тип склейик INNER | LEFT | RIGHT | OUTER
     * @param string|null таблица склейки
     */
    public function __construct(QueryBuilder $queryBuilder, string $type = '', string $tbl = null)
    {
        $this->queryBuilder = $queryBuilder;
        $this->type = $type;
        $this->from = $tbl;
    }

    /**
     * Установка склеиваемой таблицы.
     * @param string склеиваемая таблица или запрос записей склеиваемой таблицы
     * @param array параметры для экранирования\
     * @return $this
     */
    public function from(string $from, array $params = [])
    {
        $this->from = $from;
        $this->params = array_merge($this->params, $params);
        return $this;
    }

    /**
     * Установка псевдонима для склеиваемой таблицы.
     * @param string псевдоним
     * @return $this
     */
    public function as(string $as)
    {
        $this->as = $as;
        return $this;
    }

    /**
     * Установка условия склеивания.
     * @param string условие
     * @param string параметры для экранирования
     * @return QueryBuilder
     */
    public function on(string $on, array $params = [])
    {
        $this->on = $on;
        $this->params = array_merge($this->params, $params);
        return $this->endJoin();
    }

    /**
     * Получение sql.
     * @return string
     */
    public function getSql(): string
    {
        $sql = "$this->type JOIN";
        if (!empty($this->as)) {
            $sql .= " ($this->from) AS $this->as";
        } else {
            $sql .= " $this->from";
        }
        $sql .= " ON $this->on";
        return $sql;
    }

    /**
     * Закрытие join и его установка в сборщик запроса.
     * @return QueryBuilder
     */
    public function endJoin()
    {
        return $this->queryBuilder->setJoin($this->getSql(), $this->params);
    }
}
