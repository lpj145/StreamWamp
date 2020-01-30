<?php
declare(strict_types=1);

namespace StreamWamp\Test\TestCase\Controller\Component;

use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;
use StreamWamp\Controller\Component\StreamComponent;

/**
 * StreamWamp\Controller\Component\StreamComponent Test Case
 */
class StreamComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \StreamWamp\Controller\Component\StreamComponent
     */
    protected $Stream;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Stream = new StreamComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Stream);

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
