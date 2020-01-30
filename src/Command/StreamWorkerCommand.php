<?php
declare(strict_types=1);

namespace StreamWamp\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\ORM\TableRegistry;
use function React\Promise\all;
use StreamWamp\Model\Table\StreamQueuesTable;
use StreamWamp\StreamClient;
use StreamWamp\StreamService;
use StreamWamp\Types\StreamMessage;
use Thruway\Logging\ConsoleLogger;
use Thruway\Logging\Logger;

/**
 * StreamWorker command.
 */
class StreamWorkerCommand extends Command
{
    const SECONDS_THREE_DAYS_TO_FLUSH_BUFFER = 259.200;
    const SECONDS_TO_RE_WORK = 5;
    const DAYS_TO_FLUSH = 3;

    /**
     * @var StreamQueuesTable
     */
    private $StreamQueues;
    /**
     * @var StreamClient
     */
    private $client;

    private $isAlreadyWorking = false;

    public function initialize(): void
    {
        $this->StreamQueues = TableRegistry::getTableLocator()
            ->get('StreamWamp.StreamQueues');
        $this->StreamQueues
            ->getConnection()
            ->connect();

        $this->client = StreamService::factory()
            ->getStreamClient();

        Logger::set(new ConsoleLogger());
    }

    /**
     * Hook method for defining this command's option parser.
     *
     * @see https://book.cakephp.org/3.0/en/console-and-shells/commands.html#defining-arguments-and-options
     *
     * @param \Cake\Console\ConsoleOptionParser $parser The parser to be defined
     * @return \Cake\Console\ConsoleOptionParser The built parser.
     */
    public function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser = parent::buildOptionParser($parser);

        return $parser;
    }

    /**
     * @param Arguments $args
     * @param ConsoleIo $io
     * @throws \Exception
     */
    public function execute(Arguments $args, ConsoleIo $io)
    {
        $io->info('Initializing work to send messages on stream (wampV2).');
        $this->client->start(false);
        $io->info('Adding observers to stream and database.');
        $this->client
            ->getLoop()
            ->addPeriodicTimer(
                self::SECONDS_THREE_DAYS_TO_FLUSH_BUFFER,
                [$this, 'flushDatabaseBuffer']
            );
        $this->client
            ->getLoop()
            ->addPeriodicTimer(
                self::SECONDS_TO_RE_WORK,
                [$this, 'trySendMessages']
            );

        $io->success('Connection has been stabilized, working...');
        $this->client->getLoop()->run();
    }

    public function trySendMessages()
    {
        $collectionMessages = $this->StreamQueues->getMessagesNotSent();
        if (
            $collectionMessages->isEmpty()
            || !$this->client->haveSession()
            || $this->isAlreadyWorking
        ) {
            return;
        }
        /**
         * By each message send, and store all promises, after resolver
         * always update a messages and free worker to worker again.
         */
        all($collectionMessages->each(function(StreamMessage $message){
            return $this->client->sendMessage($message);
        }))
            ->always(function() use($collectionMessages){
                $this->StreamQueues->updateQueueToSent($collectionMessages);
                $this->isAlreadyWorking = false;
            })
        ;
        $this->isAlreadyWorking = true;
    }

    /**
     * A function to delete old messages on database.
     */
    public function flushDatabaseBuffer()
    {
        $this->StreamQueues->flushMessagesHasSentByDays(
            self::DAYS_TO_FLUSH
        );
    }
}
