<?php

require __DIR__ .'/../vendor/autoload.php';

use React\EventLoop\Factory;
use React\Stream\ReadableResourceStream;
use React\Stream\ThroughStream;
use React\Stream\WritableResourceStream;

$loop = Factory::create();

$readable = new ReadableResourceStream(STDIN, $loop);
$output = new WritableResourceStream(STDOUT, $loop);

$through = new ThroughStream('strtoupper');
$readable->pipe($through)->pipe($output);

$loop->run();