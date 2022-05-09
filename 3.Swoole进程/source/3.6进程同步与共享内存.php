<?php

//$atomic = new Swoole\Atomic();
//
//(new \Swoole\Process(function (\Swoole\Process $worker) use ($atomic) {
//    while($atomic->get() < 5){
//        $atomic->add();
//        echo "Atomic Now: {$atomic->get()}, pid: {$worker->pid}", PHP_EOL;
//        sleep(1);
//    }
//    echo "Shutdown {$worker->pid}", PHP_EOL;
//
//}))->start();
//
//(new \Swoole\Process(function (\Swoole\Process $worker) use ($atomic) {
//    while($atomic->get() < 10){
//        $atomic->add();
//        echo "Atomic Now: {$atomic->get()}, pid: {$worker->pid}", PHP_EOL;
//        sleep(1);
//    }
//    echo "Shutdown {$worker->pid}", PHP_EOL;
//}))->start();
//
//\Swoole\Process::wait();
//\Swoole\Process::wait();

// [root@localhost source]# php 3.6进程同步与共享内存.php
// Atomic Now: 1, pid: 1469
// Atomic Now: 2, pid: 1468
// Atomic Now: 3, pid: 1468
// Atomic Now: 4, pid: 1469
// Atomic Now: 5, pid: 1468
// Atomic Now: 6, pid: 1469
// Shutdown 1468
// Atomic Now: 7, pid: 1469
// Atomic Now: 8, pid: 1469
// Atomic Now: 9, pid: 1469
// Atomic Now: 10, pid: 1469
// Shutdown 1469


//$atomic = new Swoole\Atomic();
//
////$atomic->cmpset(0, 2);
//
//(new \Swoole\Process(function (\Swoole\Process $worker) use ($atomic) {
//    $atomic->wait(3);
//    echo "Shutdown wait Process: {$worker->pid}", PHP_EOL;
//
//}))->start();
//
//(new \Swoole\Process(function (\Swoole\Process $worker) use ($atomic) {
////    sleep(2);
//    sleep(5);
//    $atomic->wakeup();
////    $atomic->cmpset(0, 1);
//    echo "Shutdown other Process: {$worker->pid}", PHP_EOL;
//}))->start();
//
//\Swoole\Process::wait();
//\Swoole\Process::wait();

//  [root@localhost source]# php 3.6进程同步与共享内存.php
//  Shutdown other Process: 1511
//  Shutdown wait Process: 1510


//$lock = new Swoole\Lock();
//
//(new \Swoole\Process(function (\Swoole\Process $worker) use ($lock) {
//    echo "Process: {$worker->pid} Wait", PHP_EOL;
//    $lock->lock();
//    echo "Process: {$worker->pid} Locked", microtime(true), PHP_EOL;
//    sleep(3);
//    $lock->unlock();
//    echo "Process: {$worker->pid} exit;", PHP_EOL;
//}))->start();
//
//(new \Swoole\Process(function (\Swoole\Process $worker) use ($lock) {
//    sleep(1);
//    echo "Process: {$worker->pid} Wait ", PHP_EOL;
//    $lock->lock();
//    echo "Process: {$worker->pid} Locked",microtime(true), PHP_EOL;
//    $lock->unlock();
//    echo "Process: {$worker->pid} exit;", PHP_EOL;
//}))->start();
//
//\Swoole\Process::wait();
//\Swoole\Process::wait();
//
//[root@localhost source]# php 3.6进程同步与共享内存.php
//Process: 1611 Wait
//Process: 1611 Locked1640572026.9681
//Process: 1612 Wait
//Process: 1611 exit;
//Process: 1612 Locked1640572029.9771
//Process: 1612 exit;


$table = new Swoole\Table(1024);
$table->column('worker_id', Swoole\Table::TYPE_INT);
$table->column('count', Swoole\Table::TYPE_INT);
$table->column('data', Swoole\Table::TYPE_STRING, 64);
$table->create();

$ppid = getmypid();
$table->set($ppid, ['worker_id'=>getmypid(), 'count'=>0, 'data'=>"这里是 " . $ppid]);


(new \Swoole\Process(function (\Swoole\Process $worker) use ($table) {
    $table->set($worker->pid, ['worker_id'=>$worker->pid, 'count'=>0, 'data'=>"这里是 {$worker->pid}"]);
    sleep(1);
    $table->incr($worker->pid, 'count');
    print_r($table->get($worker->pid));
}))->start();

(new \Swoole\Process(function (\Swoole\Process $worker) use ($table, $ppid) {
    $table->set($worker->pid, ['worker_id'=>$worker->pid, 'count'=>3, 'data'=>"这里是 {$worker->pid}"]);
    sleep(1);
    $table->decr($worker->pid, 'count');
    print_r($table->get($worker->pid));
    sleep(1);

    echo "{$worker->pid} 内部循环：", PHP_EOL;
    foreach($table as $t){
        print_r($t);
    }
    if($table->exist($ppid)){
        $table->del($ppid);
    }
}))->start();

\Swoole\Process::wait();
\Swoole\Process::wait();

echo "Talbe 数量：",$table->count(), PHP_EOL;
echo "主进程循环：", PHP_EOL;
foreach($table as $t){
    print_r($t);
}
echo "Table 状态：", PHP_EOL;
print_r($table->stats());


//  [root@localhost source]# php 3.6进程同步与共享内存.php
//  Array
//  (
//      [worker_id] => 1551
//      [count] => 1
//      [data] => 这里是 1551
//  )
//  Array
//  (
//      [worker_id] => 1552
//      [count] => 2
//      [data] => 这里是 1552
//  )
//  1552 内部循环：
//  Array
//  (
//      [worker_id] => 1550
//      [count] => 0
//      [data] => 这里是 1550
//  )
//  Array
//  (
//     [worker_id] => 1551
//      [count] => 1
//      [data] => 这里是 1551
//  )
//  Array
//  (
//      [worker_id] => 1552
//     [count] => 2
//     [data] => 这里是 1552
//  )
//  Talbe 数量：2
//  主进程循环：
//  Array
//  (
//      [worker_id] => 1551
//      [count] => 1
//      [data] => 这里是 1551
//  )
//  Array
//  (
//      [worker_id] => 1552
//      [count] => 2
//      [data] => 这里是 1552
//  )
//  Table 状态：
//  Array
//  (
//      [num] => 2
//      [conflict_count] => 0
//      [conflict_max_level] => 0
//      [insert_count] => 3
//      [update_count] => 2
//      [delete_count] => 1
//     [available_slice_num] => 204
//     [total_slice_num] => 204
//  )

