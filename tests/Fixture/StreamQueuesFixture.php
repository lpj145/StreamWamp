<?php
declare(strict_types=1);

namespace StreamWamp\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * StreamQueuesFixture
 */
class StreamQueuesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'channel' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null],
        'payload' => ['type' => 'json', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null],
        'action' => ['type' => 'string', 'length' => 255, 'default' => '', 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null],
        'type' => ['type' => 'string', 'length' => 30, 'default' => '', 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null],
        'code' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'has_sent' => ['type' => 'boolean', 'length' => null, 'default' => 0, 'null' => true, 'comment' => null, 'precision' => null],
        'created_at' => ['type' => 'timestampfractional', 'length' => null, 'default' => 'CURRENT_TIMESTAMP', 'null' => false, 'comment' => null, 'precision' => 6],
        'modified_at' => ['type' => 'timestampfractional', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => 6],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
    ];
    // @codingStandardsIgnoreEnd
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'channel' => 'Lorem ipsum dolor sit amet',
                'payload' => '',
                'action' => 'Lorem ipsum dolor sit amet',
                'type' => 'Lorem ipsum dolor sit amet',
                'code' => 1,
                'has_sent' => 1,
                'created_at' => '',
                'modified_at' => '',
            ],
        ];
        parent::init();
    }
}
