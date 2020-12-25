<?php


class CalcMultiplication extends CalcOperator
{
    protected $precedence = 5;

    public function operate(StackData $stack)
    {
        return $stack->pop()->operate($stack) * $stack->pop()->operate($stack);
    }
}
