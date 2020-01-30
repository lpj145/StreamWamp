<?php
declare(strict_types=1);

namespace StreamWamp\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use StreamWamp\Model\Table\StreamQueuesTable;

/**
 * StreamWamp\Model\Table\StreamQueuesTable Test Case
 */
class StreamQueuesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \StreamWamp\Model\Table\StreamQueuesTable
     */
    protected $StreamQueues;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'plugin.StreamWamp.StreamQueues',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('StreamQueues') ? [] : ['className' => StreamQueuesTable::class];
        $this->StreamQueues = TableRegistry::getTableLocator()->get('StreamQueues', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->StreamQueues);

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
     * Test getMessagesNotSent method
     *
     * @return void
     */
    public function testGetMessagesNotSent(): void
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
