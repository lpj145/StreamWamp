<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateStreamQueue extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('stream_queues');

        $table->addColumn('channel', 'string', [
            'default' => null,
            'null' => false
        ]);

        $table->addColumn('payload', 'json');

        $table->addColumn('action', 'string', [
            'default' => '',
            'null' => true
        ]);

        $table->addColumn('type', 'string', [
            'limit' => 30,
            'default' => '',
            'null' => true
        ]);

        $table->addColumn('code', 'integer');

        $table->addColumn('has_sent', 'boolean', [
            'default' => false,
            'null' => true
        ]);

        $table->addTimestamps('created_at', 'modified_at');

        $table->create();
    }
}
