<?php

// for ($i = 0; $i < 2; $i++) {
//    $process = new \Swoole\Process(function () {
//        $t = rand(1, 5);
//        echo 'Child Process #' . getmypid() . 'start and sleep ' . $t . 's', PHP_EOL;
//        sleep($t);
//        echo 'Child Process #' . getmypid() . ' exit', PHP_EOL;
//    });
//    $process->start();
// }


// while(1) sleep(100);

// for ($n = 2; $n--;) {
//    $status = \Swoole\Process::wait(true);
//    echo "Recycled #{$status['pid']}, code={$status['code']}, signal={$status['signal']}" . PHP_EOL;
// }
echo 'Parent #' . getmypid() . ' exit' . PHP_EOL;
// while(1) sleep(100);
// $obj = new stdClass();
// $obj->parent = 1;
// var_dump($obj);

// (new \Swoole\Process(function () use (&$obj) {
//    $obj->child1 = 1;
//    var_dump($obj);
// }))->start();

// (new \Swoole\Process(function () use (&$obj) {
//    sleep(3);
//    $obj->child2 = 1;
//    var_dump($obj);
// }))->start();

// [root@localhost source]# php 3.3单进程管理Process.php
// object(stdClass)#1 (1) {
// ["parent"]=>
//   int(1)
// }
// object(stdClass)#1 (2) {
// ["parent"]=>
//   int(1)
//   ["child1"]=>
//   int(1)
// }
// object(stdClass)#1 (2) {
// ["parent"]=>
//   int(1)
//   ["child2"]=>
//   int(1)
// }

//(new \Swoole\Process(function () {
//    var_dump(func_get_args());
//}))->start();
//  [root@localhost source]# php 3.3单进程管理Process.php
//  array(1) {
//      [0]=>
//    object(Swoole\Process)#1 (6) {
//    ["pipe"]=>
//      int(4)
//      ["msgQueueId"]=>
//      NULL
//      ["msgQueueKey"]=>
//      NUL
//      ["pid"]=>
//      int(1956)
//      ["id"]=>
//      NULL
//     ["callback":"Swoole\Process":private]=>
//      object(Closure)#2 (0) {
//      }
//    }
//  }

// (new \Swoole\Process(function (\Swoole\Process $process) {
//    $process->name('Child Test1');
//    sleep(10);
// }))->start();

// (new \Swoole\Process(function (\Swoole\Process $process) {
//    $process->name('Child Test2');
//    sleep(10);
// }))->start();

// $process = new \Swoole\Process(function () {
//    sleep(10);
// });
// $process->start();
// $process->name('Child Test3');

//swoole_set_process_name("Parent Test");
// [root@localhost ~]# ps -ef | grep Test
// root      1942  1413  0 21:45 pts/0    00:00:00 Parent Test
// root      1943  1942  0 21:45 pts/0    00:00:00 Child Test1
// root      1944  1942  0 21:45 pts/0    00:00:00 Child Test2


// Swoole\Process::daemon();

// (new \Swoole\Process(function (\Swoole\Process $process) {
//     echo $process->exec('/usr/local/bin/php', ['-r', 'echo 1+1;']);
//     // 2
// }))->start();



// (new \Swoole\Process(function(\Swoole\Process $pro){
//    $pro->exit(9);
//    sleep(20);
// }))->start();
// ////  Array
// ////  (
// ////      [pid] => 2086
// ////      [code] => 9
// ////      [signal] => 0
// ////  )
// ////  PID=2086
// //
// $process = new \Swoole\Process(function(\Swoole\Process $pro){
//    sleep(20);
// });
// $process->start();
// sleep(5);
// Swoole\Process::kill($process->pid);
////  Array
////  (
////      [pid] => 2087
////      [code] => 0
////      [signal] => 15
////  )
////  PID=2087

Swoole\Process::setAffinity([0]);

$process = new \Swoole\Process(function(\Swoole\Process $pro){
    echo $pro->getPriority(PRIO_PROCESS), PHP_EOL;
});
$process->start();
$process->setPriority(PRIO_PROCESS, -10);



Swoole\Process::signal(SIGCHLD, function ($sig) {
    //必须为false，非阻塞模式
    while ($ret = Swoole\Process::wait(false)) {
        print_r($ret);
        echo "PID={$ret['pid']}\n";
    }
});



// echo 'Parent #' . getmypid() . ' exit' . PHP_EOL;
// // while(1) sleep(100);
Swoole\Timer::tick(2000, function () {});





// Swoole\Timer::tick(1000, function () {
//     // echo "hello\n";
// });

// \Swoole\Event::wait();

