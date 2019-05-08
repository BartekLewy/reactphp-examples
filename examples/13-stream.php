<?php
require __DIR__ . '/../vendor/autoload.php';

$pool = new class
{

    /** @var SplObjectStorage */
    private $pool;

    public function __construct()
    {
        $this->pool = new SplObjectStorage();
    }

    public function add(\React\Socket\ConnectionInterface $connection)
    {
        $this->pool->attach($connection);
        $connection->write('Welcome on this fantastic socker server chat!');

        $connection->on('data', function($data) use ($connection) {
            $this->send($data, $connection);
        });

        $connection->on('close', function() use ($connection) {
            $this->pool->detach($connection);
            $this->send('Someone left a chat', $connection);
        });

        $this->send('New user joined the chat', $connection);
    }

    public function send($data, \React\Socket\ConnectionInterface $myConnection)
    {
        foreach ($this->pool as $connection) {
            if ($connection !== $myConnection) {
                $connection->write($data);
            }
        }
    }
};

$loop = \React\EventLoop\Factory::create();
$socket = new \React\Socket\Server('127.0.0.1:8000', $loop);

$socket->on('connection', function (\React\Socket\ConnectionInterface $connection) use ($pool) {
    $pool->add($connection);
});

$loop->run();