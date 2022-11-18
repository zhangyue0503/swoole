<?php


$workNum = 5;

// $pool = new \Swoole\Process\Pool($workNum);

// $pool->on('WorkerStart', function(\Swoole\Process\Pool $pool, $workerId){
//    echo "工作进程：{$workerId}, pid: " . posix_getpid() . " 开始运行！", PHP_EOL;
//    while(1);
// });

// $pool->on("WorkerStop", function(\Swoole\Process\Pool $pool, $workerId){
//    echo "工作进程：{$workerId}, pid: " . posix_getpid() . " 结束运行！", PHP_EOL;
// });

// $pool->start();


// $pool = new \Swoole\Process\Pool($workNum, SWOOLE_IPC_UNIXSOCK);

// $pool->on('WorkerStart', function(\Swoole\Process\Pool $pool, $workerId){
//    $proc1 = $pool->getProcess(0);
//    while(1){
//        sleep(1);
//        if($workerId == 0){
//            echo $proc1->read(), PHP_EOL;
//        }else{
//            $proc1->write("hello proc1, this is proc" . ($workerId + 1));
//        }
//    }
// });

// $pool->on("Message", function(Swoole\Process\Pool $pool, $data){
// });

// $pool->start();


 $pool = new \Swoole\Process\Pool($workNum, SWOOLE_IPC_MSGQUEUE, 1);

 $pool->on('WorkerStart', function(\Swoole\Process\Pool $pool, $workerId){
    $process = $pool->getProcess();
    $process->useQueue(1, 2 | \Swoole\Process::IPC_NOWAIT);
    while(1){
        sleep(1);
        if($workerId == 0){
            foreach(range(1,4) as $v){
                $process->push("[{$v}]消息来了" . time());
            }
        }else{
            $data = $process->pop();
            if($data){
                echo $process->pop(), ' workerid:', $workerId, PHP_EOL;
            }
        }
    }
 });

// $pool->on("Message", function(Swoole\Process\Pool $pool, $data){
//    var_dump($pool);
//    var_dump($data);
// });

// $pool->start();


// $pool = new \Swoole\Process\Pool($workNum, SWOOLE_IPC_MSGQUEUE, 1);

// $pool->on("Message", function(Swoole\Process\Pool $pool, $data){
//    var_dump($pool);
//    $process = $pool->getProcess();
//    echo $process->pid, PHP_EOL;
//    var_dump($data);
// });

// $pool->start();

//object(Swoole\Process\Pool)#1 (2) {
//["master_pid"]=>
//  int(7114)
//  ["workers"]=>
//  array(1) {
//    [4]=>
//    object(Swoole\Process)#3 (6) {
//    ["pipe"]=>
//      NULL
//      ["msgQueueId"]=>
//      NULL
//      ["msgQueueKey"]=>
//      NULL
//      ["pid"]=>
//      int(7119)
//      ["id"]=>
//      int(4)
//      ["callback":"Swoole\Process":private]=>
//      NULL
//    }
//  }
//}
//7119
//string(27) "消息来了1640313653.9647"
// ………………

// $pool = new \Swoole\Process\Pool($workNum, SWOOLE_IPC_SOCKET);

// $pool->listen('0.0.0.0', 8089);

// $pool->on("Message", function(Swoole\Process\Pool $pool, $data){
//    var_dump($data);
//    $pool->write("你发来的数据是：\"{$data}\"");
// });

// $pool->start();

// [root@localhost source]# php 3.5进程池与进程管理器.php
// string(33) "客户端发消息1640318342.8369"
// string(33) "客户端发消息1640318344.8386"
// string(33) "客户端发消息1640318346.8397"

$pool = new \Swoole\Process\Pool($workNum, SWOOLE_IPC_UNIXSOCK);

$pool->on('WorkerStart', function(\Swoole\Process\Pool $pool, $workerId){
//    if($workerId == 0){
       echo "Shutdown Worker:{$workerId}, pid:" . posix_getpid(), PHP_EOL;
       var_dump($pool->shutdown());
//    }
});

$pool->on('Message', function(\Swoole\Process\Pool $pool, $workerId){
});

$pool->start();

// [root@localhost source]# php 3.5进程池与进程管理器.php
// Shutdown Worker:0, pid:7247

// [root@localhost source]# ps -ef | grep php
//    root      7246  4402  0 23:13 pts/1    00:00:00 php 3.5?程池与?程管理器.php
//    root      7248  7246  0 23:13 pts/1    00:00:00 php 3.5?程池与?程管理器.php
//    root      7249  7246  0 23:13 pts/1    00:00:00 php 3.5?程池与?程管理器.php
//    root      7250  7246  0 23:13 pts/1    00:00:00 php 3.5?程池与?程管理器.php
//    root      7251  7246  0 23:13 pts/1    00:00:00 php 3.5?程池与?程管理器.php

// $pool = new \Swoole\Process\Pool(2);

// $pool->on('WorkerStart', function (\Swoole\Process\Pool $pool, $workerId) {

//    $i = 0;
//    while (1) {
//        sleep(1);
//        $i++;
//        if ($i == 5) {
//            echo "Detach Worker:{$workerId}, pid:" . posix_getpid(), PHP_EOL;
//            $pool->detach();
//        } else if ($i == 10) {
//            break;
//        }
//    }

// });

// $pool->on("WorkerStop", function (\Swoole\Process\Pool $pool, $workerId) {
//    echo "工作进程：{$workerId}, pid: " . posix_getpid() . " 结束运行！", PHP_EOL;
// });


// $pool->start();

// [root@localhost source]# php 3.5进程池与进程管理器.php
// Detach Worker:1, pid:16336
// Detach Worker:0, pid:16335
// 工作进程：0, pid: 16335 结束运行！
// 工作进程：1, pid: 16336 结束运行！
// [2021-12-23 23:33:42 @16334.0]	WARNING	ProcessPool::wait(): [Manager]unknown worker[pid=16335]
// [2021-12-23 23:33:42 @16334.0]	WARNING	ProcessPool::wait(): [Manager]unknown worker[pid=16336]
// Detach Worker:1, pid:16337
// Detach Worker:0, pid:16338


// $pm = new \Swoole\Process\Manager();

// for ($i = 0; $i < 2; $i++) {
//     $pm->add(function (\Swoole\Process\Pool $pool, $workerId) {
//         echo "工作进程：{$workerId}, pid: " . posix_getpid() . " 开始运行！", PHP_EOL;
//         while (1) ;
//     });
// }

// $pm->start();
