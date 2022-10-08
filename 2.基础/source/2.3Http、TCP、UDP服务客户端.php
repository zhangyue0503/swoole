<?php

$client = new Swoole\Client(SWOOLE_SOCK_TCP);
if (!$client->connect('127.0.0.1', 9501, -1)) {
   exit("connect failed. Error: {$client->errCode}\n");
}
var_dump($client->isConnected()); // bool(true)
// var_dump($client->getSocket());
// var_dump($client->getsockname());
// //array(2) {
// //    ["port"]=>
// //  int(47998)
// //  ["host"]=>
// //  string(9) "127.0.0.1"
// //}

$client->send("hello world\n");
echo $client->recv();

$client->close();

// $client = new Swoole\Client(SWOOLE_SOCK_UDP);

// if (!$client->connect('127.0.0.1', 9501, -1)) {
//    exit("connect failed. Error: {$client->errCode}\n");
// }

// $client->sendto('127.0.0.1', 9501, "hello world\n");

// echo $client->recv();

// var_dump($client->getpeername());
// array(2) {
//    ["port"]=>
//  int(0)
//  ["host"]=>
//  string(7) "0.0.0.0"
// }


// $client->close();


