<?php


//\Swoole\Coroutine\run(function(){
//    go(function(){
//        co::sleep(2);
//        echo "cid:" . Co::getCid() , PHP_EOL;
//    });
//
//    go(function(){
//        \Swoole\Coroutine\System::sleep(2);
//        echo "cid:" . Co::getCid() , PHP_EOL;
//    });
//
//    go(function(){
//        echo "cid:" . Co::getCid() , PHP_EOL;
//        $ret = \Swoole\Coroutine\System::exec("ls -l ./");
//        var_dump($ret);
//    });
//});

//cid:4
//array(3) {
//    ["code"]=>
//  int(0)
//  ["signal"]=>
//  int(0)
//  ["output"]=>
//  string(222) "total 16
//-rw-r--r--. 1 root root 3509 Dec 20 21:50 4.1Swoole协程服务.php
//-rw-r--r--. 1 root root 6704 Dec 27 22:57 4.2协程应用与容器.php
//-rw-r--r--. 1 root root  416 Dec 28 20:05 4.3协程操作系统API.md.php
//"
//}
//cid:2
//cid:3


//$process = new \Swoole\Process(function(){
//    echo "Process";
//});
//$process->start();
//echo "进程 pid: ". $process->pid, PHP_EOL;
//
//\Swoole\Coroutine\run(function(){
//    $status = \Swoole\Coroutine\System::wait();
//    echo "wait 进程 pid: ".$status['pid'], PHP_EOL;
//    var_dump($status);
//});
//进程 pid: 1489
//Processwait 进程 pid: 1489
//array(3) {
//    ["pid"]=>
//  int(1489)
//  ["code"]=>
//  int(0)
//  ["signal"]=>
//  int(0)
//}

//$process1 = new \Swoole\Process(function(){
//});
//$process1->start();
//echo "进程1 pid: ". $process1->pid, PHP_EOL;
//
//$process2 = new \Swoole\Process(function(){
//    sleep(5);
//});
//$process2->start();
//echo "进程2 pid: ". $process2->pid, PHP_EOL;
//
//\Swoole\Coroutine\run(function() use ($process1){
//    $status = \Swoole\Coroutine\System::waitPid($process1->pid);
//    echo "waitPid 进程 pid: ".$status['pid'], PHP_EOL;
//    var_dump($status);
//
//    $status = \Swoole\Coroutine\System::wait();
//    echo "wait 进程 pid: ".$status['pid'], PHP_EOL;
//    var_dump($status);
//
//});
//进程1 pid: 1491
//进程2 pid: 1492
//waitPid 进程 pid: 1491
//array(3) {
//    ["pid"]=>
//  int(1491)
//  ["code"]=>
//  int(0)
//  ["signal"]=>
//  int(0)
//}
//wait 进程 pid: 1492
//array(3) {
//    ["pid"]=>
//  int(1492)
//  ["code"]=>
//  int(0)
//  ["signal"]=>
//  int(0)
//}

//$process = new \Swoole\Process(function () {
//    \Swoole\Coroutine\run(function () {
//        $bool = \Swoole\Coroutine\System::waitSignal(SIGUSR1);
//        var_dump($bool);
//    });
//});
//$process->start();
//sleep(1);
//$process::kill($process->pid, SIGUSR1);

//[root@localhost source]# php 4.3协程操作系统API.md.php
//[root@localhost source]# bool(true)


//\Swoole\Coroutine\run(function(){
//    $ip = Swoole\Coroutine\System::gethostbyname("www.baidu.com", AF_INET, 0.5);
//    echo $ip, PHP_EOL;
//
//    $ip = Swoole\Coroutine\System::dnsLookup("www.baidu.com");
//    echo $ip, PHP_EOL;
//
//    $ips = Swoole\Coroutine\System::getaddrinfo("www.baidu.com");
//    var_dump($ips);
//});
//112.80.248.75
//112.80.248.76
//array(2) {
//    [0]=>
//  string(13) "112.80.248.75"
//    [1]=>
//  string(13) "112.80.248.76"
//}

//$file = __DIR__ . "/test.data";
//$fp = fopen($file, "a+");
//Swoole\Coroutine\run(function () use ($fp, $file)
//{
//    $r = Swoole\Coroutine\System::fwrite($fp, "hello world\n" . PHP_EOL, 5);
//    var_dump($r);
//
//    var_dump(\Swoole\Coroutine\System::readFile($file));
//});
//int(5)
//string(5) "hello"

//Swoole\Coroutine\run(function () use ($fp, $file)
//{
//    \Swoole\Coroutine\System::writeFile($file, "happy new year\n", FILE_APPEND);
//
//    $r = Swoole\Coroutine\System::fread($fp);
//    var_dump($r);
//
//
//    while($r = Swoole\Coroutine\System::fgets($fp)){
//        var_dump($r);
//    }
//
//});
//string(15) "happy new year
//"
//string(20) "hellohappy new year
//"

Swoole\Coroutine\run(function () {
    var_dump(Swoole\Coroutine\System::statvfs('/'));
});
//array(11) {
//  ["bsize"]=>
//  int(4096)
//  ["frsize"]=>
//  int(4096)
//  ["blocks"]=>
//  int(4299264)
//  ["bfree"]=>
//  int(2909435)
//  ["bavail"]=>
//  int(2909435)
//  ["files"]=>
//  int(8603648)
//  ["ffree"]=>
//  int(8515964)
//  ["favail"]=>
//  int(8515964)
//  ["fsid"]=>
//  int(64768)
//  ["flag"]=>
//  int(4096)
//  ["namemax"]=>
//  int(255)
//}
