<?php

// go(function(){
//    sleep(2);
//    echo "cid1:" . Co::getCid() , PHP_EOL;
// });
// go(function(){
//    sleep(1);
//    echo "cid2:" . Co::getCid() , PHP_EOL;
// });
//cid1:1
//cid2:2

// \Swoole\Coroutine\run(function(){
//   go(function(){
//       sleep(2);
//       echo "cid1:" . Co::getCid() , PHP_EOL;
//   });
//   go(function(){
//       sleep(1);
//       echo "cid2:" . Co::getCid() , PHP_EOL;
//   });
// });
//cid2:3
//cid1:2

// \Swoole\Coroutine\run(function () {
//    $time = microtime(true);

//    $barrier = \Swoole\Coroutine\Barrier::make();

//    foreach (range(1, 4) as $i) {
//        go(function () use ($barrier, $i) {
//            \Swoole\Coroutine\System::sleep($i);
//        });
//    }

//    \Swoole\Coroutine\Barrier::wait($barrier);

//    echo microtime(true) - $time, PHP_EOL;
// });
// 4.0022649765015


// $serv = new Swoole\Http\Server("0.0.0.0", 9501);


// $serv->on('request', function ($req, $resp) {
//     $time = microtime(true);
//     $wg = new \Swoole\Coroutine\WaitGroup();

//     $wg->add();
//     $wg->add();

//     $res = 1;

//     go(function () use ($wg, &$res) {
//         co::sleep(3);
//         $res += 1;
//         $wg->done();
//     });

//     go(function () use ($wg, &$res) {
//         co::sleep(4);
//         $res *= 10;
//         $wg->done();
//     });

//     $wg->wait();

//     $endTime = microtime(true) - $time;
//     $resp->end($res . " - " . $endTime);
// });
// $serv->start();

//20 - 4.002151966095
