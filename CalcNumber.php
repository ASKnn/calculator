<?php


class CalcNumber extends CalcItem
{
    public function operate(StackData $stack)
    {
        return $this->value;
    }
}
