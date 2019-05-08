<?php

use React\EventLoop\Factory;

require __DIR__ . '/../vendor/autoload.php';

$loop = Factory::create();
$loop->addPeriodicTimer(1, function () {
    echo 'Hello!' . PHP_EOL;
});

$loop->run();