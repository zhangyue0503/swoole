<?php


// $cid = Swoole\Coroutine::create(function(){
//       sleep(10);
//    Swoole\Coroutine::sleep(10);
//    echo "协程1，cid:" . Swoole\Coroutine::getCid() , PHP_EOL;
// });
// go(function(){
//    echo "协程2，cid:" . Co::getCid() , PHP_EOL;

//    $ccid = go(function(){
//        co::sleep(10);
//        echo "协程2-1，cid:" . co::getCid() . "，pcid:" . co::getPcid(), PHP_EOL;
//    });
//    echo "协程2-1，pcid:" . Co::getPcid($ccid), PHP_EOL;
// });

// echo $cid, PHP_EOL;


//[root@localhost source]# php 4.2协程应用与容器.php
//协程2，cid:2
//协程2-1，pcid:2
//1
//协程1，cid:1
//协程2-1，cid:3，pcid:2

// $cid1 = go(function(){
//    echo "协程1，cid:" . Co::getCid() , " start", PHP_EOL;
//    co::yield();
//    echo "协程1，cid:" . Co::getCid() , " end", PHP_EOL;
// });

// go(function() use($cid1){
//    echo "协程2，cid:" . Co::getCid() , " start", PHP_EOL;
//    co::sleep(5);
//    co::resume($cid1);
//    echo "协程2，cid:" . Co::getCid() , " end", PHP_EOL;
// });
// [root@localhost source]# php 4.2协程应用与容器.php
// 协程1，cid:1 start
// 协程2，cid:2 start
// 协程1，cid:1 end
// 协程2，cid:2 end

// go(function(){
//    defer(function(){
//        echo "一定会进来！", PHP_EOL;
//    });
//    defer(function(){
//        echo "一定会进来2！", PHP_EOL;
//    });
//    throw new Exception("发生异常了");
// });
//[root@localhost source]# php 4.2协程应用与容器.php
//一定会进来2！
//一定会进来！
//PHP Fatal error:  Uncaught Exception: 发生异常了 in /home/www/4.Swoole协程/source/4.2协程应用与容器.php:52
//Stack trace:
//#0 [internal function]: {closure}()
//#1 {main}
//  thrown in /home/www/4.Swoole协程/source/4.2协程应用与容器.php on line 52


// function test1(){
//    test2();
// }
// function test2(){
//    while(1) {
//        co::sleep(1);
//        break;
//    }
// }

// go(function(){
//    $cid = go(function(){test1();});
//    var_dump(co::getBackTrace($cid));
// });
//[root@localhost source]# php 4.2协程应用与容器.php
//array(4) {
//    [0]=>
//  array(6) {
//        ["file"]=>
//    string(60) "/home/www/4.Swoole协程/source/4.2协程应用与容器.php"
//        ["line"]=>
//    int(59)
//    ["function"]=>
//    string(5) "sleep"
//        ["class"]=>
//    string(16) "Swoole\Coroutine"
//        ["type"]=>
//    string(2) "::"
//        ["args"]=>
//    array(1) {
//            [0]=>
//      int(1)
//    }
//  }
//  [1]=>
//  array(4) {
//        ["file"]=>
//    string(60) "/home/www/4.Swoole协程/source/4.2协程应用与容器.php"
//        ["line"]=>
//    int(55)
//    ["function"]=>
//    string(5) "test2"
//        ["args"]=>
//    array(0) {
//        }
//  }
//  [2]=>
//  array(4) {
//        ["file"]=>
//    string(60) "/home/www/4.Swoole协程/source/4.2协程应用与容器.php"
//        ["line"]=>
//    int(65)
//    ["function"]=>
//    string(5) "test1"
//        ["args"]=>
//    array(0) {
//        }
//  }
//  [3]=>
//  array(2) {
//        ["function"]=>
//    string(9) "{closure}"
//        ["args"]=>
//    array(0) {
//        }
//  }
//}

// $cid = go(function(){
//    co::sleep(2.2);
//    echo co::getElapsed(), PHP_EOL;
// });
// echo co::getElapsed($cid), PHP_EOL;
//0
//2204

// var_dump(\Swoole\Coroutine::exists($cid)); // bool(true)
// var_dump(iterator_to_array(\Swoole\Coroutine::list()));
// var_dump(iterator_to_array(\Swoole\Coroutine::listCoroutines()));
//array(1) {
//    [0]=>
//  int(1)
//}
// var_dump(Swoole\Coroutine::stats());
//array(9) {
//    ["event_num"]=>
//  int(0)
//  ["signal_listener_num"]=>
//  int(0)
//  ["aio_task_num"]=>
//  int(0)
//  ["aio_worker_num"]=>
//  int(0)
//  ["aio_queue_size"]=>
//  int(0)
//  ["c_stack_size"]=>
//  int(2097152)
//  ["coroutine_num"]=>
//  int(1)
//  ["coroutine_peak_num"]=>
//  int(1)
//  ["coroutine_last_cid"]=>
//  int(1)
//}

// Swoole\Coroutine\run(function(){
//    $cid = go(function(){
//        echo co::getCid() , " 开始", PHP_EOL;
//        co::sleep(10);
//        var_dump(co::isCanceled());
//        echo co::getCid() , " 结束", PHP_EOL;

//    });
//    co::cancel($cid);
// });
// [root@localhost source]# php 4.2协程应用与容器.php
// 2 开始
// bool(true)
// 2 结束


// $start_time = microtime(true);
// Swoole\Coroutine\run(function () {
// //    Swoole\Coroutine::join([
//        go(function () {
//            sleep(3);
//            echo 1, PHP_EOL;
//        });
//        go(function () {
//            sleep(4);
//            echo 2, PHP_EOL;
//        });
// //    ], 1);
// });
// echo microtime(true) - $start_time, PHP_EOL;
//[root@localhost source]# php 4.2协程应用与容器.php
//1
//2
//4.0021550655365

// $start_time = microtime(true);
// Swoole\Coroutine\run(function () {
//    $results = Swoole\Coroutine\batch([
//        'func1'=>function(){sleep(1);return 'func1 ok';},
//        'func2'=>function(){sleep(2);return 'func2 ok';},
//        'func3'=>function(){sleep(3);return 'func3 ok';}
//    ],5);
//    var_dump($results);
// });
// echo microtime(true) - $start_time, PHP_EOL;
//[root@localhost source]# php 4.2协程应用与容器.php
//array(3) {
//    ["func1"]=>
//  string(8) "func1 ok"
//    ["func2"]=>
//  string(8) "func2 ok"
//    ["func3"]=>
//  string(8) "func3 ok"
//}
//3.002023935318


// $sch = new Swoole\Coroutine\Scheduler;
// $sch->set(['max_coroutine' => 2]);
// for($i=0;$i<3;$i++){
//    $sch->add(function () {
//        co::sleep(5);
//        echo co::getCid(), PHP_EOL;
//    });
// }
// $sch->start();
//PHP Warning:  Swoole\Coroutine\Scheduler::start(): exceed max number of coroutine 2 in /home/www/4.Swoole协程/source/4.2协程应用与容器.php on line 199

// $sch = new Swoole\Coroutine\Scheduler;
// $sch->set(['max_coroutine' => 3]);
// for($i=0;$i<3;$i++){
//    $sch->add(function () {
//        co::sleep(5);
//        echo co::getCid(), PHP_EOL;
//    });
// }
// $sch->start();
//[root@localhost source]# php 4.2协程应用与容器.php
//1
//3
//2

// $sch = new Swoole\Coroutine\Scheduler;
// $sch->parallel(10, function () {
//    co::sleep(5);
//    echo co::getCid(), PHP_EOL;
// });
// $sch->start();
//[root@localhost source]# php 4.2协程应用与容器.php
//1
//10
//9
//8
//7
//6
//5
//4
//3
//2
$ret = Swoole\Coroutine\run(function () {
   Swoole\Coroutine\run(function () {

   });
    go(function () {
        sleep(4);
        echo 1, PHP_EOL;
    });
});
echo $ret, PHP_EOL;
Swoole\Coroutine\run(function () {
    go(function () {
        echo 2, PHP_EOL;
    });
});
// [root@localhost source]# php 4.2协程应用与容器.php
// 1
// 1
// 2
