<?php
use React\EventLoop\Factory;
use React\EventLoop\Timer\Timer;

require __DIR__ . '/../vendor/autoload.php';

$i = 1;

$loop = Factory::create();
$loop->addPeriodicTimer(1, function(Timer $timer) use ($loop, &$i) {
    if($i > 10) {
        $loop->cancelTimer($timer);
    }
    echo sprintf('Hello Again! Event loop here %d', $i) . PHP_EOL;
    $i++;
});

$loop->run();