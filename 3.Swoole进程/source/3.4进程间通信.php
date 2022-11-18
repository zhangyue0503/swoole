<?php


// $workers = [];
// for ($i = 1; $i < 3; $i++) {
//    $process = new Swoole\Process(function (Swoole\Process $worker) {
//     //    var_dump($worker);
//        $data = $worker->read();
//        echo "Child {$worker->pid}：来自 Master 的数据 - \"{$data}\"。", PHP_EOL;
//        $worker->write("发送给领导，来自 {$worker->pid} 的数据，通过管道 {$worker->pipe} ！");
//    });
//    $process->start();
//    $workers[$process->pid] = $process;
// }

// foreach ($workers as $pid => $process) {
//    $process->write("{$pid}，你好！");
//    $data = $process->read();
//    echo "Master：来自子进程 {$pid} 的数据 - \"{$data}\"", PHP_EOL;
// }

// [root@localhost source]# php 3.4进程间通信.php
// Child 2076：来自 Master 的数据 - "2076，你好！"。
// Master：来自子进程 2076 的数据 - "发送给领导，来自 2076 的数据，通过管道 4 ！"
// Child 2077：来自 Master 的数据 - "2077，你好！"。
// Master：来自子进程 2077 的数据 - "发送给领导，来自 2077 的数据，通过管道 6 ！"

// $process1 = new Swoole\Process(function (Swoole\Process $worker) {
//    while(1){
//        $data = $worker->read();
//        if($data){
//            echo "Child {$worker->pid}：接收到的数据 - \"{$data}\"。", PHP_EOL;
//        }
//    }
// });
// $process1->start();

// $messages = [
//    "Hello World!",
//    "Hello Cat!",
//    "Hello King",
//    "Hello Leon",
//    "Hello Rose"
// ];
// $process2 = new Swoole\Process(function (Swoole\Process $worker) use($process1, $messages) {
//    foreach($messages as $msg){
//        sleep(1);
//        $process1->write("来自 {$worker->pid} {$msg} ！");
//    }
//    sleep(1);
//    $worker->kill($process1->pid, SIGKILL);
// });
// $process2->start();
// \Swoole\Process::wait(true);
// \Swoole\Process::wait(true);


//  [root@localhost source]# php 3.4进程间通信.php
//  Child 2102：接收到的数据 - "来自 2103 Hello World! ！"。
//  Child 2102：接收到的数据 - "来自 2103 Hello Cat! ！"。
//  Child 2102：接收到的数据 - "来自 2103 Hello King ！"。
//  Child 2102：接收到的数据 - "来自 2103 Hello Leon ！"。
//  Child 2102：接收到的数据 - "来自 2103 Hello Rose ！"。


// $workers = [];
// for ($i = 1; $i < 3; $i++) {
//    $process = new Swoole\Process(function (Swoole\Process $worker) {
//        $socket = $worker->exportSocket();
//        $data = $socket->recv();
//        echo "Child {$worker->pid}：来自 Master 的数据 - \"{$data}\"。", PHP_EOL;
//        $socket->send("发送给领导，来自 {$worker->pid} 的数据，通过管道 {$worker->pipe} ！");
//    }, false, SOCK_DGRAM, true);
//    $process->start();
//    $workers[$process->pid] = $process;
// }
// foreach ($workers as $pid => $process) {
//    \Swoole\Coroutine\run(function () use ($pid, $process) {
//        $socket = $process->exportSocket();
//        $socket->send("{$pid}，你好！");
//        $data = $socket->recv();
//        echo "Master：来自子进程 {$pid} 的数据 - \"{$data}\"", PHP_EOL;
//    });
// }
//foreach ($workers as $pid => $worker) {
//    \Swoole\Process::wait();
//}

//  [root@localhost source]# php 3.4进程间通信.php
//  Child 2062：来自 Master 的数据 - "2062，你好！"。
//  Master：来自子进程 2062 的数据 - "发送给领导，来自 2062 的数据，通过管道 4 ！"
//  Child 2063：来自 Master 的数据 - "2063，你好！"。
//  Master：来自子进程 2063 的数据 - "发送给领导，来自 2063 的数据，通过管道 6 ！"

 for ($i = 1; $i < 3; $i++) {
     $process = new Swoole\Process(function (Swoole\Process $worker) {
         var_dump($worker);
         while($msg = $worker->pop()) {
             if ($msg === false) {
                 break;
             }
             echo "Child {$worker->pid}：来自 Master 的数据 - \"{$msg}\"。", PHP_EOL;
             sleep(1);
         }
     });
     // $process->useQueue(1, 2);
    $process->useQueue(1, 2);
 //    $process->useQueue(1, 1 | \Swoole\Process::IPC_NOWAIT);
     $process->start();
 }
// $messages = [
//     "Hello World!",
//     "Hello Cat!",
//     "Hello King",
//     "Hello Leon",
//     "Hello Rose"
// ];

// foreach ($messages as $msg){
//     $process->push($msg);
// }

// \Swoole\Process::wait(true);
// \Swoole\Process::wait(true);

// $process1 = new Swoole\Process(function (Swoole\Process $worker) {
//    while($msg = $worker->pop()) {
//            if ($msg === false) {
//                break;
//            }
//            echo "Child {$worker->pid}：来自 Master 的数据 - \"{$msg}\"。", PHP_EOL;
//            sleep(1);
//        }
// });
// $process1->useQueue(1, 1);
// $process1->start();

// $process2 = new Swoole\Process(function (Swoole\Process $worker) {
//    while($msg = $worker->pop()) {
//            if ($msg === false) {
//                break;
//            }
//            echo "Child {$worker->pid}：来自 Master 的数据 - \"{$msg}\"。", PHP_EOL;
//            sleep(1);
//        }
// });
// $process2->useQueue(2, 1);
// $process2->start();

// foreach ($messages as $msg){
//    $process1->push($msg);
// }

// foreach ($messages as $msg){
//    $process2->push($msg);
// }

//  [root@localhost source]# php 3.4进程间通信.php
//  Child 2071：来自 Master 的数据 - "Hello World!"。
//  Child 2070：来自 Master 的数据 - "Hello Cat!"。
//  Child 2071：来自 Master 的数据 - "Hello King"。
//  Child 2070：来自 Master 的数据 - "Hello Leon"。
//  Child 2071：来自 Master 的数据 - "Hello Rose"。


$ppid = getmypid();
$workers = [];
for ($i = 1; $i < 3; $i++) {
   $process = new Swoole\Process(function (Swoole\Process $worker) use ($ppid, $i) {
       sleep($i*3);
       echo "PID:{$worker->pid} kill -USR2 Master {$ppid}.", PHP_EOL;
       $worker->kill($ppid, SIGUSR2);
   });

   $process->start();
   $workers[$process->pid] = $process;
}

Swoole\Process::signal(SIGUSR2, function () use ($workers) {
   echo "收到子进程 USR2 信号，结束所有子进程！", PHP_EOL;
   foreach ($workers as $pid => $w) {
       Swoole\Process::kill($pid, SIGKILL);
   }
});

Swoole\Process::signal(SIGCHLD, function ($sig) {
    //必须为false，非阻塞模式
    while ($ret = Swoole\Process::wait(false)) {
        echo "PID={$ret['pid']}\n";
    }
});
Swoole\Timer::tick(2000, function () {});



//  [root@localhost source]# php 3.4进程间通信.php
//  PID:2044 kill -USR2 Master 2043.
//  收到子进程 USR2 信号，结束所有子进程！
//  PID=2044
//  PID=2045
