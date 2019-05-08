<?php

require __DIR__ . '/../vendor/autoload.php';

$loop = \React\EventLoop\Factory::create();

$i = 0;

$readable = new \React\Stream\ReadableResourceStream(STDIN, $loop);
$writable = new \React\Stream\WritableResourceStream(STDOUT, $loop);
$readable->on('data', function ($data) use (&$i, $writable) {
    $writable->write(sprintf('Line %d: %s', ++$i, $data));
});

$readable->on('end', function () use ($writable) {
    $writable->write('END OF PROCESSING');
});

$loop->run();