<?php
declare(strict_types=1);

namespace StreamWamp\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use StreamWamp\StreamClient;
use StreamWamp\StreamService;
use StreamWamp\Types\CollectionMessage;
use StreamWamp\Types\StreamMessage;

/**
 * Stream component
 */
class StreamComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function sendMessage(StreamMessage $message): void
    {
        $this->getCollection()
            ->addMessage($message);
    }

    public function getClient(): StreamClient
    {
        return StreamService::factory()
            ->getStreamClient();
    }

    protected function getCollection(): CollectionMessage
    {
        return $this->getController()
            ->getRequest()
            ->getAttribute(StreamService::STREAM_ATTR_NAME)
        ;
    }
}
