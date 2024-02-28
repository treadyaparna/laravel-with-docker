<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ConditionalNullableRule implements Rule
{
    protected $conditionField;
    protected $conditionValues;

    public function __construct($conditionField, $conditionValues)
    {
        $this->conditionField = $conditionField;
        $this->conditionValues = $conditionValues;
    }

    public function passes($attribute, $value)
    {
        $conditionValue = request()->input($this->conditionField);
        $conditionCheck = in_array($conditionValue, $this->conditionValues);
        return $conditionCheck ? ($value === null || $value === '') : ($value !== null && $value !== '');
    }

    public function message()
    {
        return 'Give proper data in :attribute field.';
    }
}
