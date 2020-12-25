<?php


abstract class CalcItem
{
    protected $value = '';

    public function __construct($value)
    {
        $this->value = $value;
    }

    public static function factory($value) {
        if ($value instanceof CalcItem) {
            return $value;
        } elseif (is_numeric($value)) {
            return new CalcNumber($value);
        } elseif ($value === '+') {
            return new CalcAddition($value);
        } elseif ($value === '-') {
            return new CalcSubtraction($value);
        } elseif ($value === '*') {
            return new CalcMultiplication($value);
        } elseif ($value === '/') {
            return new CalcDivision($value);
        } elseif ($value === '^') {
            return new CalcExponent($value);
        } elseif ($value ==='(' || $value === ')') {
            return new Brackets($value);
        }
        throw new RangeException("Error while search calc type");
    }

    abstract public function operate(StackData $stack);

    public function isOperator()
    {
        return false;
    }

    public function isBrackets()
    {
        return false;
    }

    public function render()
    {
        return $this->value;
    }
}
