<?php
namespace base\validators;

use base\custom\Field;

/**
 * Валидатор id.
 */
class IdField extends Field
{
    public $min = 0;
    public $max = 11;
    public $pattern = '/^\d{1,11}$/';
}
