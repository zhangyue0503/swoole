<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

$http = new Swoole\Http\Server('0.0.0.0', 9501);

$http->set(array(
    'worker_num'    => 4,
));

$http->on('Request', function ($req, $res) use($app) {
    $_SERVER = [];
    if(isset($req->server)){
        foreach($req->server as $k => $v){
            $_SERVER[strtoupper($k)] = $v;
        }
    }
    $_GET = [];
    if(isset($req->get)){
        foreach ($req->get as $k => $v){
            $_GET[$k] = $v;
        }
    }
    $_POST = [];
    if(isset($req->post)){
        foreach ($req->post as $k => $v){
            $_POST[$k] = $v;
        }
    }
    //把返回放到一个缓冲区里
    ob_start();
    try {
        $kernel = $app->make(Kernel::class);

        $response = $kernel->handle(
            $request = Request::capture()
        )->send();

        $kernel->terminate($request, $response);
    }catch(\Exception $e){
        print_r($e->getMessage());
    }
    $ob = ob_get_contents();
    ob_end_clean();
    $res->end($ob);
});

echo "服务启动", PHP_EOL;
$http->start();
