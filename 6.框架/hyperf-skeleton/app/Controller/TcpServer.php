<?php

namespace App\Controller;

use Swoole\Coroutine\Server\Connection;
use Swoole\Server as SwooleServer;

class TcpServer implements \Hyperf\Contract\OnReceiveInterface
{

    /**
     * @inheritDoc
     */
    public function onReceive($server, int $fd, int $reactorId, string $data): void
    {
        $server->send($fd, 'recv：' . $data);
    }

    public function onClose($server, int $fd, int $reactorId){
        echo '连接关闭：' . $fd . ',' . $reactorId;
    }
}
