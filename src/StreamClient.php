<?php
/**
 * Created by PhpStorm.
 * User: Marquinho
 * Date: 28/01/2020
 * Time: 10:54
 */

namespace StreamWamp;

use App\Types\MessageStream;
use function React\Promise\all;
use StreamWamp\Types\CollectionMessage;
use StreamWamp\Types\StreamMessage;
use Thruway\Authentication\ClientAuthenticationInterface;
use Thruway\Authentication\ClientWampCraAuthenticator;
use Thruway\ClientSession;
use Thruway\Peer\Client;

class StreamClient extends Client
{
    public function __construct(
        string $realm,
        string $user,
        string $secret,
        ClientAuthenticationInterface $authentication = null
    )
    {
        parent::__construct($realm, null);

        if (is_null($authentication)) {
            $authentication = new ClientWampCraAuthenticator(
                $user,
                $secret
            );
        }

        $this->setAuthId($user);
        $this->addClientAuthenticator($authentication);
    }

    public function haveSession(): bool
    {
        return $this->getSession() instanceof ClientSession;
    }

    /**
     * Same as publish WAMP message
     * @param StreamMessage $message
     * @return \React\Promise\Promise
     */
    public function sendMessage(StreamMessage $message)
    {
        return $this->getSession()
            ->publish(
                $message->getChannel(),
                [],
                $message->getMessage(),
                ['acknowledge' => true]
            );
    }

    public function sendMessages(CollectionMessage $messages)
    {
        $this->on('open', function() use($messages) {
            all($messages->each([$this, 'sendMessage']))
                ->always(function () {
                    $this->stopConnection();
                });
        });
        $this->start();
    }

    /**
     * Stop connection with wamp server.
     */
    public function stopConnection()
    {
        $this->getSession()->close();
        $this->getLoop()->stop();
    }
}