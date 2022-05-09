<?php


foreach (range(1, 3) as $i) {
    $fp = stream_socket_client("tcp://127.0.0.1:8089", $errno, $errstr) or die("error: $errstr\n");
    $msg = "客户端发消息" . microtime(true);
    fwrite($fp, pack('N', strlen($msg)) . $msg);
    sleep(2);
    $data = fread($fp, 8192);
    if($data){
        var_dump(substr($data, 4, unpack('N', substr($data, 0, 4))[1]));
    }
    fclose($fp);
}

// [root@localhost source]# php 3.52socketclient.php
// string(59) "你发来的数据是："客户端发消息1640318342.8369""
// string(59) "你发来的数据是："客户端发消息1640318344.8386""
// string(59) "你发来的数据是："客户端发消息1640318346.8397""

