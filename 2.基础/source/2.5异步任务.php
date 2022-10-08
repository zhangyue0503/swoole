<?php

$http = new Swoole\Http\Server('0.0.0.0', 9501);

$http->set([
   'worker_num' => 1,
   'task_worker_num'=>1,
]);

$http->on('Request', function ($request, $response) use($http) {
   echo "接收到了请求", PHP_EOL;
   $response->header('Content-Type', 'text/html; charset=utf-8');

   $http->task("发送邮件");
   $http->task("发送广播");
   $http->task("执行队列");

   // $http->task("发送邮件2");
   // $http->task("发送广播2");
   // $http->task("执行队列2");

   $response->end('<h1>Hello Swoole. #' . rand(1000, 9999) . '</h1>');

});

//处理异步任务(此回调函数在task进程中执行)
$http->on('Task', function ($serv, $task_id, $reactor_id, $data) {
   $sec = rand(11,15);
   echo "New AsyncTask[id={$task_id}] sleep sec: {$sec}".PHP_EOL;
   sleep($sec);
   // sleep(rand(1,5));
   //返回任务执行的结果
   $serv->finish("{$data} -> OK");
});

//处理异步任务的结果(此回调函数在worker进程中执行)
$http->on('Finish', function ($serv, $task_id, $data) {
   echo "AsyncTask[{$task_id}] Finish: {$data}".PHP_EOL;
});

echo "服务启动", PHP_EOL;
$http->start();


