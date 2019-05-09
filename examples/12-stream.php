<?php
require __DIR__ . '/../vendor/autoload.php';

use Psr\Http\Message\ServerRequestInterface;
use React\EventLoop\Factory;
use React\Filesystem\Filesystem;
use React\Http\Response;
use React\Http\Server;
use function React\Promise\Stream\unwrapReadable;

$loop = Factory::create();
$filesystem = Filesystem::create($loop);

$server = new Server(function () use ($filesystem) {

    $filePath = 'examples/files/stream-video.mp4';
    $file = $filesystem->file($filePath);

    return $file->exists()
        ->then(
            function () use ($file) {
                return new Response(200, ['Content-Type' => 'video/mp4'], unwrapReadable($file->open('r')));
            },
            function () {
                return new Response(404, ['Content-Type' => 'text/plain'], "This video doesn't exist on server.");
            }
        );
});

$socket = new \React\Socket\Server('127.0.0.1:8000', $loop);
$server->listen($socket);

$loop->run();