<?php

use Tomaj\Hermes\Driver\ZeroMqDriver;
use Tomaj\Hermes\Dispatcher;
use Tomaj\Hermes\Message;

require_once __DIR__ . '/../../vendor/autoload.php';

// Prepare ZMQ client
$context = new ZMQContext(1);
echo "Connecting to hello world server…\n";
$requester = new ZMQSocket($context, ZMQ::SOCKET_REQ);
$requester->connect("tcp://localhost:5555");

$driver = new ZeroMqDriver($requester);

$dispatcher = new Dispatcher($driver);

$counter = 1;
while (true) {
    $dispatcher->emit(new Message('type1', ['message' => $counter]));
    echo "Emited message $counter\n";
    $counter++;
    sleep(1);
}
