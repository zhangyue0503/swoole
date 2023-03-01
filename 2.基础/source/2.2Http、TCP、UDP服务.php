<?php

// $http = new Swoole\Http\Server('0.0.0.0', 9501);

// $http->on('Request', function ($request, $response) {
//    echo "接收到了请求", PHP_EOL;

//    var_dump($request);
//    var_dump($_REQUEST);
//    var_dump($_SERVER);

//    $response->header('Content-Type', 'text/html; charset=utf-8');
//    $response->end('<h1>Hello Swoole. #' . rand(1000, 9999) . '</h1>');
// });

// echo "服务启动", PHP_EOL;
// $http->start();

$http = new Swoole\Http\Server('0.0.0.0', 9501);

$i = 1;

$http->set([
   'worker_num'=>5,
]);

$http->on('Request', function ($request, $response) {
   global $i;
   $response->end($i++);
});

$http->start();


// 创建Server对象，监听 9501 端口
//  $server = new Swoole\Server('0.0.0.0', 9501);

//  //监听连接进入事件
//  $server->on('Connect', function ($server, $fd) {
//     echo "Client: Connect.\n";
//  });

//  //监听数据接收事件
//  $server->on('Receive', function ($server, $fd, $reactor_id, $data) {
//     $server->send($fd, "Server TCP: {$data}");
//  });

//  //监听连接关闭事件
//  $server->on('Close', function ($server, $fd) {
//     echo "Client: Close.\n";
//  });

//  //启动服务器
//  $server->start();

// $server = new Swoole\Server('0.0.0.0', 9501, SWOOLE_PROCESS, SWOOLE_SOCK_UDP);

// //监听数据接收事件
// $server->on('Packet', function ($server, $data, $clientInfo) {
//    var_dump($clientInfo);
//    $server->sendto($clientInfo['address'], $clientInfo['port'], "Server UDP：{$data}");
// });

// //启动服务器
// $server->start();
