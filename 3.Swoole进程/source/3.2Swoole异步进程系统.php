<?php

// $http = new Swoole\Http\Server('0.0.0.0', 9502, SWOOLE_BASE);


$http = new Swoole\Http\Server('0.0.0.0', 9502, SWOOLE_PROCESS);

$http->set([
    'worker_num'=>2
]);

$http->on('Request', function ($request, $response) {
    var_dump(func_get_args());

    // \Co\run(function(){
    //     go(function(){
    //         sleep(20);
    //     });
    // });
    // \Co\run(function(){
    //     go(function(){
    //         sleep(20);
    //     });
    // });
    // \Co\run(function(){
    //     go(function(){
    //         sleep(20);
    //     });
    // });
    // \Co\run(function(){
    //     go(function(){
    //         sleep(20);
    //     });
    // });

    $response->end('开始测试');
});






$http->start();
