<?php
declare(strict_types=1);

namespace StreamWamp\Types;

use App\Types\MessageStream;

class CollectionMessage extends \SplObjectStorage
{
    /**
     * @var MessageStream[]
     */
    private $messages = [];

    /**
     * @return MessageStream[]
     */
    public function getIterator()
    {
        return $this->messages;
    }

    public function addMessage(StreamMessage $message)
    {
        $this->messages[] = $message;
    }

    public function isEmpty(): bool
    {
        return empty($this->messages);
    }

    public function count(): int
    {
        return count($this->messages);
    }

    public function each(callable $callback)
    {
        return array_map($callback, $this->messages);
    }
}
