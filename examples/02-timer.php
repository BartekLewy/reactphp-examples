<?php
use React\EventLoop\Factory;
use React\EventLoop\Timer\Timer;

require __DIR__ . '/../vendor/autoload.php';

$loop = Factory::create();
$loop->addTimer(1, function(Timer $timer) {
    echo 'Hello! Timer' . PHP_EOL;
});

$loop->addTimer(2, function(Timer $timer) use ($loop) {
    echo 'After 2 seconds!';
});

$loop->run();