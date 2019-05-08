<?php
use React\EventLoop\Factory;

require __DIR__ . '/../vendor/autoload.php';

$loop = Factory::create();
$i = 0;
$loop->addPeriodicTimer(1, function() use(&$i) {
    echo ++$i . PHP_EOL;
});

$loop->addPeriodicTimer(3, function() {
    echo 'Event loop will be blocked for 2 seconds' . PHP_EOL;
    sleep(2);
});

$loop->run();