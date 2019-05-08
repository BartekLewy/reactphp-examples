<?php

require __DIR__ .'/../vendor/autoload.php';

$loop = \React\EventLoop\Factory::create();

$readable = new \React\Stream\ReadableResourceStream(STDIN, $loop);
$output = new \React\Stream\WritableResourceStream(STDOUT, $loop);

$through = new \React\Stream\ThroughStream('strtoupper');
$readable->pipe($through)->pipe($output);

$loop->run();