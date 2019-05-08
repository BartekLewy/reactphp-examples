<?php

use React\EventLoop\Factory;

require __DIR__ . '/../vendor/autoload.php';

$loop = Factory::create();

$timer = $loop->addPeriodicTimer(1, function () {
    echo 'Timer did really good job, trust me' . PHP_EOL;
});

$loop->addTimer(3, function () use ($loop) {
    echo 'Okey, stop' . PHP_EOL;
    $loop->stop();
});

$loop->run();