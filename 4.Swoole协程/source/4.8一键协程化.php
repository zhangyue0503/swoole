<?php
\Swoole\Runtime::enableCoroutine();
go(function(){
    $i = 9999999999999;
    while($i--){
        file_put_contents("./4.7test", $i.PHP_EOL);
    }
    echo 111;
});

go(function(){
    echo 222;
});

