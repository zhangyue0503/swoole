<?php

// \Swoole\Coroutine\run(function(){
//    $channel = new \Swoole\Coroutine\Channel(1);

//    go(function() use ($channel){
//        for($i = 0; $i < 3; $i++) {
//            $channel->push(['rand' => rand(1000, 9999), 'index' => $i]);
//            echo "{$i}\n";
//        }
//    });

//    go(function() use($channel){
//        while(1){
//            $data = $channel->pop(2);
//            if ($data) {
//                var_dump($data);
//            } else {
//                echo $channel->errCode;
//                echo ($channel->errCode === SWOOLE_CHANNEL_TIMEOUT);
//                break;
//            }
//        }
//    });

// });

\Swoole\Coroutine\run(function(){
   $channel = new \Swoole\Coroutine\Channel(1);

   go(function() use ($channel){
       for($i = 0; $i < 3; $i++) {
           $channel->push(['rand' => rand(1000, 9999), 'index' => $i]);
           echo "{$i}\n";
       }
    //    echo 'bbb';
       $channel->close();
   });

   go(function() use($channel){
       while(1){
           co::sleep(1);
        //    echo 'aaa';
           $data = $channel->pop();
        //    var_dump($data);
           if($channel->errCode == SWOOLE_CHANNEL_CLOSED){
               break;
           }
           var_dump($data);
       }
   });
});


//
// \Swoole\Coroutine\run(function () {
//     $channel = new chan(2);
//     $chan2 = new chan(2); // 总控，有两个生产者，两个消费者，要知道何时关闭 $channel


//     go(function () use ($channel, $chan2) {
//         for ($i = 0; $i < 3; $i++) {
//             co::sleep(rand(1,2));
//             $channel->push(['rand' => rand(1000, 9999), 'index' => $i]);
//             echo "入 channel 队协程：" . co::getCid() . "，下标：{$i}\n";
//         }
//         echo "入 chan2 队协程：" . co::getCid();
//         $chan2->push(1);
//     });
//     go(function () use ($channel, $chan2) {
//         for ($i = 1; $i < 4; $i++) {
//             co::sleep(rand(1,2));
//             $channel->push(['rand' => rand(1000, 9999), 'index' => $i * 10]);
//             echo "入 channel 队协程：" . co::getCid() . "，下标：{$i}\n";
//         }
//         echo "入 chan2 队协程：" . co::getCid();
//         $chan2->push(1);
//     });

//     echo "================", PHP_EOL;
//     var_dump($channel->stats());
//     var_dump($channel->length());
//     var_dump($channel->isEmpty());
//     var_dump($channel->isFull());
//     var_dump($channel->capacity);
//     var_dump($channel->errCode);
//     echo "================", PHP_EOL;

//     go(function () use ($channel) {
//         while (1) {
//             co::sleep(rand(2,3));
//             if ($channel->errCode == SWOOLE_CHANNEL_CLOSED) {
//                 break;
//             }
//             $data = $channel->pop();
//             if($data == false){
//                 break;
//             }
//             echo "%%%%%\n";
//             echo " cid:", co::getCid(), "消费 channel ！\n";
//             var_dump($data);
//             echo "%%%%%\n";
//         }
//     });

//     go(function () use ($channel) {
//         while (1) {
//             co::sleep(rand(2,3));
//             if ($channel->errCode == SWOOLE_CHANNEL_CLOSED) {
//                 break;
//             }
//             $data = $channel->pop();
// //            if($data == false){
// //                break;
// //            }
//             echo "%%%%%\n";
//             echo " cid:", co::getCid(), "消费 channel ！\n";
//             var_dump($data);
//             echo "%%%%%\n";
//         }
//     });

//     for ($i = $chan2->capacity; $i > 0; $i--) {
//         $chan2->pop();
//         echo " 主线程消费 chan2: {$i} ！\n";
//     }
//     $channel->close();

// });
//================
//array(3) {
//    ["consumer_num"]=>
//  int(0)
//  ["producer_num"]=>
//  int(0)
//  ["queue_num"]=>
//  int(0)
//}
//int(0)
//bool(true)
//bool(false)
//int(2)
//int(0)
//================
//入 channel 队协程：2，下标：0
//入 channel 队协程：3，下标：1
//入 channel 队协程：3，下标：2
//%%%%%
// cid:5消费 channel ！
//array(2) {
//    ["rand"]=>
//  int(2792)
//  ["index"]=>
//  int(0)
//}
//%%%%%
//%%%%%
// cid:4消费 channel ！
//array(2) {
//    ["rand"]=>
//  int(7298)
//  ["index"]=>
//  int(10)
//}
//%%%%%
//入 channel 队协程：2，下标：1
//入 channel 队协程：2，下标：2
//入 chan2 队协程：2 主线程消费 chan2: 2 ！
//%%%%%
// cid:4消费 channel ！
//array(2) {
//    ["rand"]=>
//  int(3729)
//  ["index"]=>
//  int(20)
//}
//%%%%%
//入 channel 队协程：3，下标：3
//入 chan2 队协程：3 主线程消费 chan2: 1 ！
//%%%%%
// cid:5消费 channel ！
//array(2) {
//    ["rand"]=>
//  int(3590)
//  ["index"]=>
//  int(1)
//}
//%%%%%
//%%%%%
// cid:4消费 channel ！
//array(2) {
//    ["rand"]=>
//  int(2667)
//  ["index"]=>
//  int(2)
//}
//%%%%%
//%%%%%
// cid:5消费 channel ！
//array(2) {
//    ["rand"]=>
//  int(3430)
//  ["index"]=>
//  int(30)
//}
//%%%%%




//
// \Swoole\Coroutine\run(function(){
//   $wg = new \Swoole\Coroutine\WaitGroup();

//   $wg->add();
//   $wg->add();

//   go(function() use($wg){
//       echo "协程1，cid:" . Co::getCid() , " start", PHP_EOL;
//       sleep(1);
//       echo "协程1，cid:" . Co::getCid() , " end", PHP_EOL;
//     //   $wg->done();
//   });

//    go(function()use($wg){
//        echo "协程2，cid:" . Co::getCid() , " start", PHP_EOL;
//        sleep(2);
//        echo "协程2，cid:" . Co::getCid() , " end", PHP_EOL;
//     //    $wg->done();
//    });
// //    $wg->done();
// //    $wg->done();
// //    $wg->wait(); // wait1

//    echo "继续执行",PHP_EOL;

//    $wg->add();
//    go(function()use($wg){
//        echo "协程3，cid:" . Co::getCid() , " start", PHP_EOL;
//        sleep(3);
//        echo "协程3，cid:" . Co::getCid() , " end", PHP_EOL;
//        $wg->done();
//    });
//    $wg->wait();

// });

//协程1，cid:2 start
//协程2，cid:3 start
//协程1，cid:2 end
//协程2，cid:3 end
//继续执行
//协程3，cid:4 start
//协程3，cid:4 end

// 注释中间 wait
//协程1，cid:2 start
//协程2，cid:3 start
//继续执行
//协程3，cid:4 start
//协程1，cid:2 end
//协程2，cid:3 end
//协程3，cid:4 end
