<?php


class Brackets extends CalcItem {

    protected $precedence = 7;

    public function operate(StackData $stack)
    {
        return true;
    }

    public function isOpened()
    {
        return $this->value === '(';
    }

    public function getPrecedence()
    {
        return $this->precedence;
    }

    public function isBrackets()
    {
        return true;
    }
}
