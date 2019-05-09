<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/utils/Pool.php';

use React\EventLoop\Factory;
use React\Socket\ConnectionInterface;
use React\Socket\Server;

$loop = Factory::create();
$socket = new Server('127.0.0.1:8000', $loop);
$pool = new Pool();

$socket->on('connection', function (ConnectionInterface $connection) use ($pool) {
    $pool->add($connection);
});

$loop->run();