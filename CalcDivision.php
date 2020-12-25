<?php


class CalcDivision extends CalcOperator
{
    protected $precedence = 5;

    public function operate(StackData $stack)
    {
        $first = $stack->pop()->operate($stack);
        $second = $stack->pop()->operate($stack);
        return $first / $second;
    }
}
