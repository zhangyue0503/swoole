<?php

// \Swoole\Runtime::enableCoroutine();
// $time = microtime(true);

// \Swoole\Coroutine\run(function(){
//     $pdoConfig = new \Swoole\Database\PDOConfig();
//     $pdoConfig
//         // ->withUnixSocket('/var/lib/mysql/mysql.sock')
//        ->withHost('localhost')
//        ->withPort(3306)
//         ->withDbName('zyblog')
//         ->withCharset('utf8mb4')
//         ->withUsername('root')
//         ->withPassword('');

//     $pool = new \Swoole\Database\PDOPool($pdoConfig, 2);

//     for($i = 10000;$i--;){
//         go(function()use($pool){
//             $pdo = $pool->get();
//             $statement = $pdo->prepare('SELECT ? + ?');
//             if (!$statement) {
//                 throw new RuntimeException('Prepare failed');
//             }
//             $a = mt_rand(1, 100);
//             $b = mt_rand(1, 100);
//             $result = $statement->execute([$a, $b]);
//             if (!$result) {
//                 throw new RuntimeException('Execute failed');
//             }
//             $result = $statement->fetchAll();
//             if ($a + $b !== (int)$result[0][0]) {
//                 throw new RuntimeException('Bad result');
//             }
//             echo spl_object_id($pdo), PHP_EOL; // 打印 pdo 对象 id
//             $pool->put($pdo);
//         });
//     }
// });
// echo microtime(true) - $time, PHP_EOL;
//11
//8
//8
//11
//0.0019669532775879

// 1024 2 0.23715400695801
// 1024 10 0.13657021522522

$time = microtime(true);
\Swoole\Coroutine\run(function(){
    $pool = new \Swoole\Database\RedisPool((new \Swoole\Database\RedisConfig())
        ->withHost('127.0.0.1')
        ->withPort(6379)
        ->withAuth('')
        ->withDbIndex(0)
        ->withTimeout(1)
    , 200);
    for ($n = 10000; $n--;) {
        go(function () use ($pool) {
            $redis = $pool->get();
            $result = $redis->set('foo', 'bar');
            if (!$result) {
                throw new RuntimeException('Set failed');
            }
            $result = $redis->get('foo');
            if ($result !== 'bar') {
                throw new RuntimeException('Get failed');
            }
            echo spl_object_id($redis), PHP_EOL; // 打印 pdo 对象 id
            $pool->put($redis);
        });
    }
});

echo microtime(true) - $time, PHP_EOL;
//14
//16
//14
//16
//0.0018310546875
