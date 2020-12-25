<?php
declare(strict_types=1);

class Calculator
{
    protected $cleanRequest = '';

    public function __construct(string $request)
    {
        $this->cleanRequest = preg_replace("~[^0-9*+\-()^/]~", "", $request);
    }

    protected $variables = [];

    public function getResult() : float
    {
        $tokens = $this->tokenize($this->cleanRequest);
        $stack = $this->getOutput($tokens);
        return $this->calculate($stack);
    }

    protected function calculate(StackData $stackData) : float
    {
        while (($operator = $stackData->pop()) && $operator->isOperator()) {
            $value = $operator->operate($stackData);
            if (!is_null($value)) {
                $stackData->add(CalcItem::factory($value));
            }
        }
        return $operator ? $operator->render() : $this->show($stackData);
    }

    protected function getOutput(array $tokens) : StackData
    {
        $output = new StackData();
        $operators = new StackData();
        foreach ($tokens as $token) {
            $token = $this->extractVariables($token);
            $expression = CalcItem::factory($token);
            if ($expression->isOperator()) {
                $this->parseOperator($expression, $output, $operators);
            } elseif ($expression->isBrackets()) {
                $this->getBrackets($expression, $output, $operators);
            } else {
                $output->add($expression);
            }
        }
        while ($op = $operators->pop()) {
            if ($op->isBrackets()) {
                throw new \RuntimeException('Mismatched Parenthesis');
            }
            $output->add($op);
        }
        return $output;
    }

    protected function registerVariable($name, $value) : void
    {
        $this->variables[$name] = $value;
    }

    protected function extractVariables($token)
    {
        if ($token[0] === '$') {
            $key = substr($token, 1);
            return $this->variables[$key] ?? 0;
        }
        return $token;
    }

    protected function show(StackData $stackData) : string
    {
        $output = '';
        while ($el = $stackData->pop()) {
            $output .= $el->render();
        }
        if ($output) {
            return $output;
        }
        throw new RuntimeException('Could not render output');
    }

    protected function getBrackets(CalcItem $expression, StackData $output, StackData $operators) : void
    {
        if ($expression->isOpened()) {
            $operators->add($expression);
        } else {
            $clean = false;
            while ($end = $operators->pop()) {
                if ($end->isBrackets()) {
                    $clean = true;
                    break;
                }

                $output->add($end);
            }
            if (!$clean) {
                throw new RuntimeException('Mismatched Parenthesis');
            }
        }
    }

    protected function parseOperator(CalcItem $expression, StackData $output, StackData $operators) : void
    {
        $end = $operators->getLast();
        if (!$end) {
            $operators->add($expression);
        } elseif ($end->isOperator()) {
            do {
                if ($expression->isLeftAssoc() && $expression->getPrecedence() <= $end->getPrecedence()) {
                    $output->add($operators->pop());
                } elseif (!$expression->isLeftAssoc() && $expression->getPrecedence() < $end->getPrecedence()) {
                    $output->add($operators->pop());
                } else {
                    break;
                }
            } while (($end = $operators->getLast()) && $end->isOperator());
            $operators->add($expression);
        } else {
            $operators->add($expression);
        }
    }

    protected function tokenize(string $string) : array
    {
        $parts = preg_split(
            '~(\d+|\+|\^|-|\*|/|\(|\))~',
            $string,
            -1,
            PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE
        );

        return $parts;
    }

}