<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/utils/FetchData.php';

use React\EventLoop\Factory;
use function React\Promise\all;
use React\Stream\WritableResourceStream;

$fetcher = new FetchData();

$promises = [
    $fetcher->call('https://jsonplaceholder.typicode.com/posts/1')->getPromise(),
    $fetcher->call('https://jsonplaceholder.typicode.com/posts/2')->getPromise(),
    $fetcher->call('https://jsonplaceholder.typicode.com/posts/3')->getPromise()
];

$loop = Factory::create();
$writable = new WritableResourceStream(STDOUT, $loop);

all($promises)->then(function ($posts) use ($writable) {
    foreach ($posts as $post) {
        $data = json_decode($post, true);
        $writable->write($data['title'] . PHP_EOL . PHP_EOL . $data['body'] . PHP_EOL . PHP_EOL);
    }
});

$loop->run();