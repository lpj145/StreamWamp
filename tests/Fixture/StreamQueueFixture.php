<?php
declare(strict_types=1);

namespace StreamWamp\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * StreamQueueFixture
 */
class StreamQueueFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'stream_queue';
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'message' => ['type' => 'json', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null],
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
                'message' => '',
                'has_sent' => 1,
                'created_at' => '',
                'modified_at' => '',
            ],
        ];
        parent::init();
    }
}
