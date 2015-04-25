<?php
/**
 * This file is part of the sesp package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rybbow\App;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\MessageInterface;
use Ratchet\Wamp\Topic;
use Ratchet\Wamp\WampServerInterface;

/**
 * Class TestApp
 *
 * @author  Michał Rybnik <michal.rybnik@fuero.pl> 
 */
class TestApp implements WampServerInterface
{
    protected $clients;

    protected $channels;

    public function __construct() {
        $this->clients  = new \SplObjectStorage();
        $this->channels = [];
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        echo sprintf('[%s] - (%s) -> Connection #%d',
                date('Y-m-d H:i:s'), $conn->remoteAddress, $conn->resourceId) . PHP_EOL;
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);

        echo sprintf('[%s] - (%s) -> Disconnected #%d',
                date('Y-m-d H:i:s'), $conn->remoteAddress, $conn->resourceId) . PHP_EOL;
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo sprintf('[%s] - (%s) -> Error for connection #%d: %s',
                date('Y-m-d H:i:s'), $conn->remoteAddress, $conn->resourceId, $e->getMessage()) . PHP_EOL;

        $conn->close();
    }

    /**
     * A request to subscribe to a topic has been made
     * @param \Ratchet\ConnectionInterface $conn
     * @param string|Topic $topic The topic to subscribe to
     */
    public function onSubscribe(ConnectionInterface $conn, $topic)
    {
        $this->channels[$topic->getId()] = $topic;
        $rawContext = json_decode($topic->getId());
        if ($rawContext->channel === '__handshake') {
            $payload = new \stdClass();
            $payload->status = 'Accepted';
            $conn->send(json_encode($payload));
            $topic->broadcast(json_encode($payload));
        }

        echo sprintf('[%s] - (%s) -> Subscribed #%d for channel %s',
                date('Y-m-d H:i:s'), $conn->remoteAddress, $conn->resourceId, $rawContext->channel) . PHP_EOL;

//        $numRecv = count($this->clients) - 1;
//
//        $payload = new \stdClass();
//        $payload->test = 123;
//        $payload->message = $msg;
//
//        $string = json_encode($payload);
//        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
//            , $conn->resourceId, $string, $numRecv, $numRecv == 1 ? '' : 's');
////        $conn->send($string);
//        foreach ($this->clients as $client) {
////            if ($conn !== $client) {
//            // The sender is not the receiver, send to each client connected
//            $client->send($string);
////            }
//        }
    }

    /**
     * An RPC call has been received
     * @param \Ratchet\ConnectionInterface $conn
     * @param string $id The unique ID of the RPC, required to respond to
     * @param string|Topic $topic The topic to execute the call against
     * @param array $params Call parameters received from the client
     */
    public function onCall(ConnectionInterface $conn, $id, $topic, array $params)
    {
        // TODO: Implement onCall() method.
    }

    /**
     * A request to unsubscribe from a topic has been made
     * @param \Ratchet\ConnectionInterface $conn
     * @param string|Topic $topic The topic to unsubscribe from
     */
    public function onUnSubscribe(ConnectionInterface $conn, $topic)
    {
        // TODO: Implement onUnSubscribe() method.
    }

    /**
     * A client is attempting to publish content to a subscribed connections on a URI
     * @param \Ratchet\ConnectionInterface $conn
     * @param string|Topic $topic The topic the user has attempted to publish to
     * @param string $event Payload of the publish
     * @param array $exclude A list of session IDs the message should be excluded from (blacklist)
     * @param array $eligible A list of session Ids the message should be send to (whitelist)
     */
    public function onPublish(ConnectionInterface $conn, $topic, $event, array $exclude, array $eligible)
    {
        // @todo handle command or query
    }
}