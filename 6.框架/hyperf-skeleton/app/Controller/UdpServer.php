<?php

namespace App\Controller;

use Swoole\WebSocket\Server;

class UdpServer implements \Hyperf\Contract\OnPacketInterface
{

    /**
     * @inheritDoc
     */
    public function onPacket($server, $data, $clientInfo): void
    {
        var_dump($clientInfo);
        $server->sendto($clientInfo['address'], $clientInfo['port'], 'Server：' . $data);
    }
}
