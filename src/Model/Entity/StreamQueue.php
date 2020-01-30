<?php
declare(strict_types=1);

namespace StreamWamp\Model\Entity;

use Cake\ORM\Entity;

/**
 * StreamQueue Entity
 *
 * @property int $id
 * @property string $channel
 * @property array $payload
 * @property string|null $action
 * @property string|null $type
 * @property int $code
 * @property bool|null $has_sent
 * @property \Cake\I18n\FrozenTime $created_at
 * @property \Cake\I18n\FrozenTime|null $modified_at
 */
class StreamQueue extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'channel' => true,
        'payload' => true,
        'action' => true,
        'type' => true,
        'code' => true,
        'has_sent' => true,
        'created_at' => true,
        'modified_at' => true,
    ];
}
