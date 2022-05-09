<?php

//创建WebSocket Server对象，监听0.0.0.0:9501端口
$ws = new Swoole\WebSocket\Server('0.0.0.0', 9501);

//监听WebSocket连接打开事件
$ws->on('Open', function ($ws, $request) {
    while(1){
        $time = date("Y-m-d H:i:s");
        $ws->push($request->fd, "hello, welcome {$time}\n");
        Swoole\Coroutine::sleep(10);
    }
});

//监听WebSocket消息事件
$ws->on('Message', function ($ws, $frame) {
    echo "Message: {$frame->data}\n";
    $ws->push($frame->fd, "server: {$frame->data}");
});

//监听WebSocket连接关闭事件
$ws->on('Close', function ($ws, $fd) {
    echo "client-{$fd} is closed\n";
});


$ws->start();
