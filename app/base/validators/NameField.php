<?php
namespace base\validators;

use base\custom\Field;

/**
 * Общий валидатор имени.
 */
class NameField extends Field
{
    public $min = 0;
    public $max = 60;
}
