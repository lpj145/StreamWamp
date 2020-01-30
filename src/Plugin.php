<?php
declare(strict_types=1);

namespace StreamWamp;

use Cake\Console\CommandCollection;
use Cake\Core\BasePlugin;
use Cake\Core\Configure;
use Cake\Core\PluginApplicationInterface;
use Cake\Http\MiddlewareQueue;
use Psr\Log\NullLogger;
use StreamWamp\Command\StreamWorkerCommand;
use StreamWamp\Middleware\SendStreamMessagesMiddleware;
use StreamWamp\Types\StreamTransportConfig;
use Thruway\Logging\Logger;

/**
 * Plugin for StreamWamp
 */
class Plugin extends BasePlugin
{
    private $configArray = [];

    /**
     * Load all the plugin configuration and bootstrap logic.
     *
     * The host application is provided as an argument. This allows you to load
     * additional plugin dependencies, or attach events.
     *
     * @param \Cake\Core\PluginApplicationInterface $app The host application
     * @return void
     */
    public function bootstrap(PluginApplicationInterface $app): void
    {
        $this->configArray = Configure::readOrFail('StreamWamp');

        if ($this->configArray['log'] ?? true) {
            Logger::set(new NullLogger());
        }

        StreamService::factory(
            StreamTransportConfig::fromArray(
                $this->configArray
            )
        );
        parent::bootstrap($app);
    }

    public function console(CommandCollection $commands): CommandCollection
    {
        $commands->add('stream_worker', StreamWorkerCommand::class);
        return $commands;
    }

    public function middleware(MiddlewareQueue $middleware): MiddlewareQueue
    {
        return $middleware->push(
            new SendStreamMessagesMiddleware(
                StreamService::factory(),
                $this->configArray['background'] ?? true
            )
        );
    }
}
