<?php
declare(strict_types=1);

namespace StreamWamp\Middleware;

use Cake\ORM\TableRegistry;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use StreamWamp\StreamService;
use StreamWamp\Types\CollectionMessage;

/**
 * SendStreamMessages middleware
 */
class SendStreamMessagesMiddleware implements MiddlewareInterface
{
    /**
     * @var StreamService
     */
    private $service;
    /**
     * @var bool
     */
    private $isBackground;

    public function __construct(StreamService $service, bool $isBackground = true)
    {
        $this->service = $service;
        $this->isBackground = $isBackground;
    }

    /**
     * Process method.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request The request.
     * @param \Psr\Http\Server\RequestHandlerInterface $handler The request handler.
     * @return \Psr\Http\Message\ResponseInterface A response.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $request = $request->withAttribute(
            StreamService::STREAM_ATTR_NAME,
            new CollectionMessage()
        );

        $response = $handler->handle($request);
        /** @var CollectionMessage $collection */
        $collection = $request->getAttribute(StreamService::STREAM_ATTR_NAME);
        if ($collection->isEmpty()) {
            return $response;
        }

        if ($this->isBackground) {
            TableRegistry::getTableLocator()
                ->get('StreamWamp.StreamQueues')
                ->enqueueCollection($collection)
            ;
            return $response;
        }

        StreamService::factory()
            ->getStreamClient()
            ->sendMessages($collection)
        ;
        return $response;
    }
}
