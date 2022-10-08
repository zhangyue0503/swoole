<?php
// $serv = new Swoole\Server("0.0.0.0", 9501);

// //监听连接进入事件
// $serv->on('Connect', function ($serv, $fd) {
//    co::sleep(5);//此处sleep模拟connect比较慢的情况
//    echo "onConnect", PHP_EOL;
// });

// //监听数据接收事件
// $serv->on('Receive', function ($serv, $fd, $reactor_id, $data) {
//    echo "onReceive", PHP_EOL;
// });

// //监听连接关闭事件
// $serv->on('Close', function ($serv, $fd) {
//    echo "Client: Close.\n";
// });

// //启动服务器
// $serv->start();

//[root@localhost source]# php 3.3Swoole协程系统.php
//onReceive
//onConnect


// Swoole\Coroutine\run (function () {
//    $server = new Swoole\Coroutine\Http\Server('0.0.0.0', 9501, false);
//    $server->handle('/', function ($request, $response) {
//        $response->end("<h1>Index</h1>");
//    });

//    $server->handle('/showname', function ($request, $response) {
//        var_dump($request->header);
//        $response->end("<h1>Hello ".$request->post['name']."</h1>");
//    });

//    $server->handle('/test', function ($request, $response) {
//        $response->end("<h1>Test</h1>");
//    });
//    $server->handle('/stop', function ($request, $response) use ($server) {
//        $response->end("<h1>Stop</h1>");
//        $server->shutdown();
//    });



//    $server->start();
// });


// Swoole\Coroutine\run (function () {
//    $server = new Swoole\Coroutine\Server('0.0.0.0', 9501, false);
//    $server->handle(function(Swoole\Coroutine\Server\Connection $conn){
//        $data = $conn->recv();
//        echo $data, PHP_EOL;
//        $conn->send("协程 TCP ：" . $data);
//    });

//    $server->start();
// });

// 4.7使用
// Swoole\Coroutine\run (function () {
//    $server = new Swoole\Coroutine\Server('0.0.0.0', 9501, false);
//    $server->handle(function(Swoole\Coroutine\Server\Connection $conn){
//        $i = 2;
//        while($i){
//            $data = $conn->recv();
//            echo $data, PHP_EOL;
//            $conn->send("协程 TCP ：" . $data);
//            sleep(1);
//            $i--;
//        }
//     //    $conn->close();
//    });

//    $server->start();
// });

// 5.2使用
Swoole\Coroutine\run (function () {
    $server = new Swoole\Coroutine\Server('0.0.0.0', 9501, false);
    $server->set(array(
//        'open_eof_split' => true,
        'open_eof_check'=>true,
        'package_eof' => "\r\n",
    ));
    $server->handle(function(Swoole\Coroutine\Server\Connection $conn){
        while($data = $conn->recv()){
            echo $data," EOF ====== ", PHP_EOL;
        }
    });

    $server->start();
});

// Swoole\Coroutine\run(function () {
//    $socket = new Swoole\Coroutine\Socket(AF_INET, SOCK_DGRAM, 0);
//    $socket->bind('0.0.0.0', 9501);

//    while (true) {
//        $peer = null;
//        $data = $socket->recvfrom($peer);
//        echo "[Server] recvfrom[{$peer['address']}:{$peer['port']}] : $data\n";
//        $socket->sendto($peer['address'], $peer['port'], "Swoole: $data");
//    }
// });

// 4.7使用
// Swoole\Coroutine\run(function () {
//    $socket = new Swoole\Coroutine\Socket(AF_INET, SOCK_STREAM);
//    $socket->bind('0.0.0.0', 9501);
//    $socket->listen();

//    while(1){
//    $client = $socket->accept();
//    if ($client !== false) {
//        go(function () use ($client) {
//            while (1) {
//                $data = $client->recv();
//                if($data == 'exit'){
//                    echo "checkLiveness:";
//                    var_dump($client->checkLiveness());
//                    echo "isClosed:";
//                    var_dump($client->isClosed());
//                    $client->close();

//                    echo "断开连接", PHP_EOL;
//                    co::sleep(1);

//                    echo "checkLiveness:";
//                    var_dump($client->checkLiveness());
//                    echo "isClosed:";
//                    var_dump($client->isClosed());
//                    break;
//                }else if ($data) {
//                    $client->send("收到了客户端：[{$client->fd}] 的数据：" . $data);
//                    var_dump($client->getsockname());
//                    var_dump($client->getpeername());
//                }
//            }
//        });
//    }

//    }

// });

//
// Swoole\Coroutine\run(function () {
//    $server = new Swoole\Coroutine\Http\Server('0.0.0.0', 9501, false);
//    $server->handle('/websocket', function (Swoole\Http\Request $request, Swoole\Http\Response $ws) {
//        $ws->upgrade();
//        while (true) {
//            $frame = $ws->recv();
//            if ($frame === '') {
//                $ws->close();
//                break;
//            } else if ($frame === false) {
//                echo 'errorCode: ' . swoole_last_error() . "\n";
//                $ws->close();
//                break;
//            } else {
//                if ($frame->data == 'close' || get_class($frame) === Swoole\WebSocket\CloseFrame::class) {
//                    $ws->close();
//                    break;
//                }
//                $ws->push("Hello {$frame->data}!");
//                $ws->push("How are you, {$frame->data}?");
//            }
//        }
//    });

//    $server->handle('/', function (Swoole\Http\Request $request, Swoole\Http\Response $response) {
//        $response->end(<<<HTML
//    <h1>Swoole WebSocket Server</h1>
//    <script>
// var wsServer = 'ws://127.0.0.1:9501/websocket';
// var websocket = new WebSocket(wsServer);
// websocket.onopen = function (evt) {
//    console.log("Connected to WebSocket server.");
//    websocket.send('hello');
// };

// websocket.onclose = function (evt) {
//    console.log("Disconnected");
// };

// websocket.onmessage = function (evt) {
//    console.log('Retrieved data from server: ' + evt.data);
// };

// websocket.onerror = function (evt, e) {
//    console.log('Error occured: ' + evt.data);
// };
// </script>
// HTML
//        );
//    });

//    $server->start();
// });
