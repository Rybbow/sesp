<?php
/**
 * This file is part of the sesp package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\Wamp\WampServer;
use Rybbow\App\TestApp;

require dirname(__DIR__) . '/vendor/autoload.php';

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new WampServer(
                new TestApp()
            )
        )
    ),
    17017
);

try {
    $server->run();
} catch (\Exception $e) {
    echo "Server died due to an exception";
}
