<?php


class CalcSubtraction extends CalcOperator
{
    protected $precedence = 4;

    public function operate(StackData $stack)
    {
        $first = $stack->pop()->operate($stack);
        $second = $stack->pop()->operate($stack);
        return $second - $first;
    }
}