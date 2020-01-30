<?php
declare(strict_types=1);

namespace StreamWamp\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use StreamWamp\Model\Table\StreamQueueTable;

/**
 * StreamWamp\Model\Table\StreamQueueTable Test Case
 */
class StreamQueueTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \StreamWamp\Model\Table\StreamQueueTable
     */
    protected $StreamQueue;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'plugin.StreamWamp.StreamQueue',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('StreamQueue') ? [] : ['className' => StreamQueueTable::class];
        $this->StreamQueue = TableRegistry::getTableLocator()->get('StreamQueue', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->StreamQueue);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test sendMessage method
     *
     * @return void
     */
    public function testSendMessage(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test sendCollection method
     *
     * @return void
     */
    public function testSendCollection(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
