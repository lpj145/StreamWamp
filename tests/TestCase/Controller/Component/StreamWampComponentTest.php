<?php
declare(strict_types=1);

namespace StreamWamp\Test\TestCase\Controller\Component;

use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;
use StreamWamp\Controller\Component\StreamWampComponent;

/**
 * StreamWamp\Controller\Component\StreamWampComponent Test Case
 */
class StreamWampComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \StreamWamp\Controller\Component\StreamWampComponent
     */
    protected $StreamWamp;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->StreamWamp = new StreamWampComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->StreamWamp);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
