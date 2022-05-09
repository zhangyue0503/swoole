<?php


//$tickA = \Swoole\Timer::tick(1000, function($timer_id, $param1){
//    static $i = 0;
//    echo $param1 . ": ". microtime(true), PHP_EOL;
//    $i++;
//    if($i == 3){
//        \Swoole\Timer::clear($timer_id);
//    }
//}, 'A');
//A: 1641218219.607
//A: 1641218220.6068
//A: 1641218221.6071

//$tickB = \Swoole\Timer::tick(1000, function($timer_id, $param1){
//    echo $param1 . ": ". microtime(true), PHP_EOL;
//}, 'B');
//
//\Swoole\Timer::after(5000, function() use($tickB){
//    \Swoole\Timer::clear($tickB);
//});
//B: 1641218178.0143
//B: 1641218179.0137
//B: 1641218180.0136
//B: 1641218181.0131
//B: 1641218182.0136


\Swoole\Timer::tick(1000, function($timer_id, $param1){
    echo $param1 . ": ". microtime(true), PHP_EOL;
}, 'C');
\Swoole\Timer::tick(1000, function($timer_id, $param1){
    echo $param1 . ": ". microtime(true), PHP_EOL;
}, 'D');
\Swoole\Timer::after(5000, function(){
    echo "After: ". microtime(true), PHP_EOL;
});

\Swoole\Timer::after(3000, function(){
    \Swoole\Timer::clearAll();
});
//C: 1641222879.0361
//D: 1641222879.0362
//D: 1641222880.0356
//C: 1641222880.0357
//C: 1641222881.034
//D: 1641222881.0341

//$tickE = \Swoole\Timer::tick(10000, function($timer_id, $param1){
//    echo $param1 . ": ". microtime(true), PHP_EOL;
//}, 'E');
//\Swoole\Timer::tick(10000, function($timer_id, $param1){
//    echo $param1 . ": ". microtime(true), PHP_EOL;
//}, 'F');
//
//var_dump(\Swoole\Timer::info($tickE));
//array(5) {
//  ["exec_msec"]=>
//  int(10000)
//  ["exec_count"]=>
//  int(0)
//  ["interval"]=>
//  int(10000)
//  ["round"]=>
//  int(0)
//  ["removed"]=>
//  bool(false)
//}

//foreach (Swoole\Timer::list() as $timer_id) {
//    var_dump(Swoole\Timer::info($timer_id));
//    var_dump(Swoole\Timer::stats($timer_id));
//}

//array(5) {
//  ["exec_msec"]=>
//  int(10000)
//  ["exec_count"]=>
//  int(0)
//  ["interval"]=>
//  int(10000)
//  ["round"]=>
//  int(0)
//  ["removed"]=>
//  bool(false)
//}
//array(3) {
//  ["initialized"]=>
//  bool(true)
//  ["num"]=>
//  int(2)
//  ["round"]=>
//  int(0)
//}
// ……………………
// ……………………









