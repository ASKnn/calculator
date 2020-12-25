<?php


abstract class CalcOperator extends CalcItem
{
    protected $precedence = 0;
    protected $leftAssoc = true;

    public function getPrecedence()
    {
        return $this->precedence;
    }

    public function isLeftAssoc()
    {
        return $this->leftAssoc;
    }

    public function isOperator()
    {
        return true;
    }

}
