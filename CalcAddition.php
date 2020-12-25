<?php


class CalcAddition extends CalcOperator
{
    protected $precedence = 4;

    public function operate(StackData $stack)
    {
        return $stack->pop()->operate($stack) + $stack->pop()->operate($stack);
    }

}
