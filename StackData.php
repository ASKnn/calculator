<?php


class StackData
{
    protected $data = [];

    /**
     * @return CalcItem
     */
    public function pop()
    {
        return array_pop($this->data);
    }

    /**
     * @return CalcItem
     */
    public function getLast()
    {
        return end($this->data);
    }

    public function add(CalcItem $element)
    {
        $this->data[] = $element;
    }
}