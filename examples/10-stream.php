<?php

require __DIR__ . '/../vendor/autoload.php';

use React\EventLoop\Factory;
use React\Stream\ReadableResourceStream;
use React\Stream\WritableResourceStream;

$loop = Factory::create();

$i = 0;

$readable = new ReadableResourceStream(STDIN, $loop);
$writable = new WritableResourceStream(STDOUT, $loop);
$readable->on('data', function ($data) use (&$i, $writable) {
    $writable->write(sprintf('Line %d: %s', ++$i, $data));
});

$readable->on('end', function () use ($writable) {
    $writable->write('END OF PROCESSING');
});

$loop->run();