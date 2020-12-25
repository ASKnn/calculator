<?php


class CalcExponent extends CalcOperator
{
    protected $precedence = 6;

    public function operate(StackData $stack)
    {
        $first = $stack->pop()->operate($stack);
        $second = $stack->pop()->operate($stack);
        return $first ** $second;
    }
}