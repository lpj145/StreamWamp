<?php
declare(strict_types=1);
namespace StreamWamp;


use StreamWamp\Types\StreamTransportConfig;
use Thruway\Transport\PawlTransportProvider;

class StreamService
{
    const STREAM_QUEUE_NAME = 'stream_queue';
    const STREAM_ATTR_NAME = 'streamWamp';

    /**
     * @var PawlTransportProvider
     */
    private $transport;
    /**
     * @var StreamClient
     */
    private $streamClient;
    /**
     * @var StreamService
     */
    private static $service;

    public function __construct(
        StreamTransportConfig $config,
        StreamClient $streamClient = null,
        PawlTransportProvider $provider = null
    )
    {
        if (is_null($streamClient)) {
            $streamClient = new StreamClient(
                $config->getRealm(),
                $config->getUser(),
                $config->getSecret()
            );
        }

        if (is_null($provider)) {
            $provider = new PawlTransportProvider(
                $config->getUrl()
            );
        }

        $streamClient->addTransportProvider($provider);

        $this->streamClient = $streamClient;
        $this->transport = $provider;
    }

    /**
     * @return PawlTransportProvider
     */
    public function getTransport(): PawlTransportProvider
    {
        return $this->transport;
    }

    /**
     * @return StreamClient
     */
    public function getStreamClient(): StreamClient
    {
        return $this->streamClient;
    }

    /**
     * @param StreamTransportConfig $config
     * @param StreamClient|null $streamClient
     * @param PawlTransportProvider|null $provider
     * @return StreamService
     */
    public static function factory(
        StreamTransportConfig $config = null,
        StreamClient $streamClient = null,
        PawlTransportProvider $provider = null
    )
    {
        if (self::$service instanceof StreamService) {
            return self::$service;
        }

        self::$service = new self(
            $config,
            $streamClient,
            $provider
        );

        return self::$service;
    }
}
