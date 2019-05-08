<?php
use React\EventLoop\Factory;

require __DIR__ . '/../vendor/autoload.php';

$loop = Factory::create();
$loop->run();