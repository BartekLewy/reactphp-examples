<?php

require __DIR__ . '/../vendor/autoload.php';

$loop = \React\EventLoop\Factory::create();

$i = 0;

$stream = new \React\Stream\ReadableResourceStream(STDIN, $loop);
$stream->on('data', function ($data) use (&$i) {
    // here you can process data
    echo sprintf('Line %d: %s', ++$i, $data) . PHP_EOL;
});

$stream->on('end', function () {
    echo 'END OF PROCESSING' . PHP_EOL;
});

$loop->run();