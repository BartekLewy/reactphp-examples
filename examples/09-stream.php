<?php

require __DIR__ . '/../vendor/autoload.php';

$loop = \React\EventLoop\Factory::create();

$stream = new \React\Stream\WritableResourceStream(STDOUT, $loop, 1);
$stream->write('hello');

$loop->run();