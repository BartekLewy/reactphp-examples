<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/utils/FetchData.php';

use React\EventLoop\Factory;
use React\EventLoop\TimerInterface;
use React\Stream\WritableResourceStream;

$loop = Factory::create();
$attempts = 0;

$writable = new WritableResourceStream(STDOUT, $loop);
$loop->addPeriodicTimer(2, function (TimerInterface $timer) use (&$attempts, $loop, $writable) {

    $attempts++;

    (new FetchData())
        ->call('https://jsonplaceholder.typicode.com/posts')
        ->getPromise()
        ->then(function ($value) use ($writable, $loop, $timer) {
            $writable->write($value);
            $loop->cancelTimer($timer);
        }, function ($reason) use (&$attempts, $timer, $loop, $writable) {

            $writable->write($reason);

            if ($attempts === 3) {
                $loop->cancelTimer($timer);
            }

        });
});

$loop->run();
