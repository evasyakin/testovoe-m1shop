<?php
/**
 * @package evas-php/evas-base
 */
namespace Evas\Base;

/*
 * Кастомизация базового php.
 */
class PhpCustomize
{
    /**
     * Проверка массива на ассоциативность.
     */
    public static function isAssoc(array $arr)
    {
        return array_keys($arr) !== range(0, count($arr) - 1);
    }

    /**
     * Проверка массива на ассоциативность. 2 вариант
     */
    public static function isAssoc2(array $arr)
    {
        return count(array_filter(array_keys($arr), 'is_string')) > 0;
    }
}
