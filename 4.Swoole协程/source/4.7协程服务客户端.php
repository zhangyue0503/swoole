<?php

// \Swoole\Coroutine\run(function () {
//    $client = new \Swoole\Coroutine\Client(SWOOLE_SOCK_TCP);
//    if (!$client->connect('127.0.0.1', 9501, 0.5)) {
//        echo "connect failed. Error: {$client->errCode}\n";
//    }
//    $client->send("hello world\n");

//    var_dump($client->isConnected()); // bool(true)

//    while (true) {
//        $data = $client->recv();
//        if (strlen($data) > 0) {
//            echo $data;
//            $client->send(time() . PHP_EOL);
//        } else {
//            var_dump($data);
    
//            if ($data === '') {
//                // 全等于空 直接关闭连接
//                $client->close();
//                var_dump($client->isConnected()); // bool(true)
//                break;
//            } else {
//                if ($data === false) {
//                    // 可以自行根据业务逻辑和错误码进行处理，例如：
//                    // 如果超时时则不关闭连接，其他情况直接关闭连接
          
//                    if ($client->errCode !== SOCKET_ETIMEDOUT) {
//                        $client->close();
                       
//                        break;
//                    }
//                } else {
//                    $client->close();
//                    break;
//                }
//            }
//        }
//        \Co::sleep(1);
//    }
// });

// bool(true)
// 协程 TCP ：hello world
// 协程 TCP ：1640837327
// string(0) ""
// bool(false)

// \Swoole\Coroutine\run(function () {
//    go(function(){
//        $cli = new Swoole\Coroutine\Http\Client('www.baidu.com', 80);
//        $cli->get('/s?wd=php');
//        echo $cli->statusCode, '===', $cli->errCode, PHP_EOL;
//        preg_match("/<title>(.*)?<\/title>/i", $cli->body, $match);
//        var_dump($match);
//        var_dump($cli->getHeaders());
//        $cli->close();
//    });
// ////    200===0
// ////    array(2) {
// ////            [0]=>
// ////      string(31) "<title>php_百度搜索</title>"
// ////            [1]=>
// ////      string(16) "php_百度搜索"
// ////    }
// ////    array(17) {
// ////            ["bdpagetype"]=>
// ////      string(1) "3"
// ////            ["bdqid"]=>
// ////      string(18) "0xdec6e00b000009a8"
// ////            ["cache-control"]=>
// ////      string(7) "private"
// ////            ["ckpacknum"]=>
// ////      string(1) "2"
// ////      string(9) "b000009a8"
// ////            ["ckrndstr"]=>
// ////            ["connection"]=>
// ////      string(10) "keep-alive"
// ////            ["content-encoding"]=>
// ////      string(4) "gzip"
// ////            ["content-type"]=>
// ////      string(23) "text/html;charset=utf-8"
// ////            ["date"]=>
// ////      string(29) "Fri, 31 Dec 2021 00:57:32 GMT"
// ////            ["p3p"]=>
// ////      string(34) "CP=" OTI DSP COR IVA OUR IND COM ""
// ////            ["server"]=>
// ////      string(7) "BWS/1.1"
// ////            ["set-cookie"]=>
// ////      string(115) "H_PS_PSSID=34444_35105_35628_35489_34584_35491_35695_35234_35644_35318_26350_35620_22159; path=/; domain=.baidu.com"
// ////            ["traceid"]=>
// ////      string(40) "1640912252031691930616052764259657976232"
// ////            ["vary"]=>
// ////      string(15) "Accept-Encoding"
// ////            ["x-frame-options"]=>
// ////      string(10) "sameorigin"
// ////            ["x-ua-compatible"]=>
// ////      string(16) "IE=Edge,chrome=1"
// ////            ["transfer-encoding"]=>
// ////      string(7) "chunked"
// ////    }
// //
//    go(function(){
//        $cli = new Swoole\Coroutine\Http\Client('127.0.0.1', 9501);
//        $cli->setHeaders(['X-Requested-With'=>'xmlhttprequest','Content-type'=>'application/x-www-form-urlencoded']);
//        $cli->post('/showname', ['name'=>'Zyblog']);
//        echo $cli->statusCode, '===', $cli->errCode, PHP_EOL;
//        echo $cli->body, PHP_EOL;
//        $cli->close();
//    });
// ////    200===0
// ////    <h1>Hello Zyblog</h1>
// //
// });

// \Swoole\Coroutine\run(function(){
//    echo \Swoole\Coroutine\FastCGI\Client::call(
//        '127.0.0.1:9000', // FPM监听地址, 也可以是形如 unix:/tmp/php-cgi.sock 的unixsocket地址
//        '/Users/zhangyue/4.71fpm.php', // 想要执行的入口文件
//        ['name' => 'ZyBlog'] // 附带的POST信息
//    );
// });
// Hello ZyBlog

\Swoole\Coroutine\run(function(){
    $socket = new Swoole\Coroutine\Socket(AF_INET, SOCK_STREAM, 0);
    $socket->connect('127.0.0.1', '9501');
    $socket->send("客户端发来信息啦！");
    $data = $socket->recv();
    echo $data, PHP_EOL;
    var_dump($socket->getsockname());
    var_dump($socket->getpeername());

    co::sleep(2);

    $socket->send("客户端发来第二条信息啦！");
    $data = $socket->recv();
    echo $data, PHP_EOL;

    co::sleep(2);

    var_dump($socket->isClosed());
    var_dump($socket->checkLiveness());

    $socket->send("exit");

    co::sleep(1);

    echo $socket->send("客户端发来第三条信息啦！"), PHP_EOL;
    $data = $socket->recv();
    echo $data, PHP_EOL;

    var_dump($socket->isClosed());
    var_dump($socket->checkLiveness());

});
// [root@localhost source]# php 4.7协程TCP、UDP、HTTP客户端.php
// 收到了客户端：[6] 的数据：客户端发来信息啦！
// array(2) {
//   ["address"]=>
//   string(9) "127.0.0.1"
//   ["port"]=>
//   int(41458)
// }
// array(2) {
//   ["address"]=>
//   string(9) "127.0.0.1"
//   ["port"]=>
//   int(9501)
// }
// 收到了客户端：[6] 的数据：客户端发来第二条信息啦！
// bool(false)
// bool(true)
// 36
//
// bool(false)
// bool(false)

// 服务端输出
// [root@localhost source]# php 4.1Swoole协程服务.php
// array(2) {
//   ["address"]=>
//   string(9) "127.0.0.1"
//   ["port"]=>
//   int(9501)
// }
// array(2) {
//   ["address"]=>
//   string(9) "127.0.0.1"
//   ["port"]=>
//   int(41458)
// }
// array(2) {
//   ["address"]=>
//   string(9) "127.0.0.1"
//   ["port"]=>
//   int(9501)
// }
// array(2) {
//   ["address"]=>
//   string(9) "127.0.0.1"
//   ["port"]=>
//   int(41458)
// }
// checkLiveness:bool(true)
// isClosed:bool(false)
// 断开连接
// checkLiveness:bool(false)
// isClosed:bool(true)
