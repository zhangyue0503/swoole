<?php
//$http = new Swoole\Http\Server('0.0.0.0', 9501);
//
//$http->on('Request', function ($request, $response) {
//    echo "接收到了请求";
//    $response->header('Content-Type', 'text/html; charset=utf-8');
//    $response->end('<h1>Hello Swoole. #' . rand(1000, 9999) . '</h1>');
//});
//
//echo "服务启动";
//$http->start();

$http = new Swoole\Http\Server('0.0.0.0', 9501);

$http->on('Request', function ($request, $response) {
    echo "接收到了请求", PHP_EOL;
    $response->header('Content-Type', 'text/html; charset=utf-8');
    $response->end('<h1>Hello Swoole. #' . rand(1000, 9999) . '</h1>');
});

echo "服务启动", PHP_EOL;
$http->start();
