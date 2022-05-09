<?php
$q = msg_get_queue(1);
foreach (range(1, 100) as $i) {
    $data = "消息来了" . microtime(true);
    msg_send($q, $i, $data, false);
}
