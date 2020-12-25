<?php
declare(strict_types=1);
spl_autoload_register(function ($class) {
    if (is_file($class . '.php')) {
        include $class . '.php';
    }
});

$options = getopt("c:");

if (empty($options) || !is_string($options['c'])) {
    echo "Invalid parameter 'c'\n";
    return;
}

$calc = new Calculator($options['c']);
var_dump($calc->getResult());