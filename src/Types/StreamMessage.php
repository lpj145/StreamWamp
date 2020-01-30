<?php
declare(strict_types=1);

namespace StreamWamp\Types;


class StreamMessage
{
    /**
     * @var array
     */
    private $payload;
    /**
     * @var string
     */
    private $type;
    /**
     * @var int
     */
    private $code;
    /**
     * @var string
     */
    private $action;
    /**
     * @var array
     */
    private $meta;
    /**
     * @var int
     */
    private $time;
    /**
     * @var string
     */
    private $channel;

    public function __construct(
        string $channel,
        array $payload,
        string $type,
        string $action = 'none',
        int $code = 200,
        array $meta = []
    )
    {
        $this->payload = $payload;
        $this->type = $type;
        $this->code = $code;
        $this->action = $action;
        $this->time = time();
        $this->meta = $meta;
        $this->channel = $channel;
    }

    public function getMessage(): array
    {
        $result = [
            'payload' => $this->payload,
            'type' => $this->type,
            'code' => $this->code,
            'action' => $this->action,
            'time' => $this->time
        ];

        if (!empty($this->meta)) {
            $result['meta'] = $this->meta;
        }

        return $result;
    }

    public function getChannel(): string
    {
        return $this->channel;
    }

    /**
     * @return array
     */
    public function getPayload(): array
    {
        return $this->payload;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @return array
     */
    public function getMeta(): array
    {
        return $this->meta;
    }
}