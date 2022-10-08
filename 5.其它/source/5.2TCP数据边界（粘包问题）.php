<?php
\Swoole\Coroutine\run(function () {
    $client = new \Swoole\Coroutine\Client(SWOOLE_SOCK_TCP);
    if (!$client->connect('127.0.0.1', 9501, 0.5)) {
        echo "connect failed. Error: {$client->errCode}\n";
    }

    $client->set(array(
//        'open_eof_split' => true,
        'open_eof_check'=>true,
        'package_eof' => "\r\n",
    ));

    for($i = 1;$i<=10;$i++){
        $client->send("hello world {$i}，\r\n");
    }
    // co::sleep(1);
    // $client->send("\r\n");$client->send("\r\n");
    for($i = 11;$i<=20;$i++){
        $client->send("hello world {$i}，\r\n");
    }
    // $client->send("\r\n");
    // co::sleep(1);
    for($i = 21;$i<=30;$i++){
        $client->send("hello world {$i}，");
        $client->send("\r\n");
    }
//    co::sleep(1);
});
