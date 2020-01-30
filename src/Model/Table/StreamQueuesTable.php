<?php
declare(strict_types=1);

namespace StreamWamp\Model\Table;

use Cake\I18n\FrozenTime;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use StreamWamp\Model\Entity\StreamQueue;
use StreamWamp\Types\CollectionMessage;
use StreamWamp\Types\StreamMessage;

/**
 * StreamQueues Model
 *
 * @method \StreamWamp\Model\Entity\StreamQueue get($primaryKey, $options = [])
 * @method \StreamWamp\Model\Entity\StreamQueue newEntity($data = null, array $options = [])
 * @method \StreamWamp\Model\Entity\StreamQueue[] newEntities(array $data, array $options = [])
 * @method \StreamWamp\Model\Entity\StreamQueue|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \StreamWamp\Model\Entity\StreamQueue saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \StreamWamp\Model\Entity\StreamQueue patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \StreamWamp\Model\Entity\StreamQueue[] patchEntities($entities, array $data, array $options = [])
 * @method \StreamWamp\Model\Entity\StreamQueue findOrCreate($search, callable $callback = null, $options = [])
 */
class StreamQueuesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('stream_queues');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
    }

    public function getMessagesNotSent(int $limit = 10): CollectionMessage
    {
        $collection = new CollectionMessage();
        $messages = $this->find('all')
            ->where(['has_sent' => false])
            ->orderAsc('created_at')
            ->limit($limit)
            ->all();

        $messages->each(function(StreamQueue $queue) use($collection){
            $collection->addMessage(
                new StreamMessage(
                    $queue->channel,
                    $queue->payload,
                    $queue->type,
                    $queue->action,
                    $queue->code,
                    [
                        'id' => $queue->id
                    ]
                )
            );
        });

        return $collection;
    }

    public function updateQueueToSent(CollectionMessage $collectionMessage)
    {
        $conditions = $collectionMessage->each(function(StreamMessage $messageStream){
            return $messageStream->getMeta()['id'];
        });
        $this->updateAll(['has_sent' => true], $conditions);
    }

    public function enqueueMessage(StreamMessage $message)
    {
        $this->saveOrFail(
            $this->newEntity([
                'channel' => $message->getChannel(),
                'payload' => $message->getPayload(),
                'action' => $message->getAction(),
                'type' => $message->getType(),
                'code' => $message->getCode()
            ])
        );
    }

    public function enqueueCollection(CollectionMessage $collectionMessage)
    {
        $collectionMessage->each([$this, 'enqueueMessage']);
    }

    public function flushMessagesHasSentByDays(int $numberOfDays)
    {
        $nowDate = FrozenTime::now();
        $dateBefore = $nowDate->subDays($numberOfDays);
        $this->query()
            ->delete($this->getTable())
            ->where([
                'created_at <= :date',
                'has_sent' => true
            ])
            ->bind(':date', $dateBefore->toW3cString())
            ->execute()
        ;
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('channel')
            ->maxLength('channel', 255)
            ->requirePresence('channel', 'create')
            ->notEmptyString('channel');

        $validator
            ->requirePresence('payload', 'create')
            ->notEmptyString('payload');

        $validator
            ->scalar('action')
            ->maxLength('action', 255)
            ->allowEmptyString('action');

        $validator
            ->scalar('type')
            ->maxLength('type', 30)
            ->allowEmptyString('type');

        $validator
            ->integer('code')
            ->requirePresence('code', 'create')
            ->notEmptyString('code');

        $validator
            ->boolean('has_sent')
            ->allowEmptyString('has_sent');

        $validator
            ->dateTime('created_at')
            ->notEmptyDateTime('created_at');

        $validator
            ->dateTime('modified_at')
            ->allowEmptyDateTime('modified_at');

        return $validator;
    }
}
