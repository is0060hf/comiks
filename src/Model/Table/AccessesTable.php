<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Accesses Model
 *
 * @method \App\Model\Entity\Access get($primaryKey, $options = [])
 * @method \App\Model\Entity\Access newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Access[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Access|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Access saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Access patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Access[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Access findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AccessesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('accesses');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('url')
            ->maxLength('url', 256)
            ->requirePresence('url', 'create')
            ->notEmptyString('url');

        $validator
            ->dateTime('access_time')
            ->requirePresence('access_time', 'create')
            ->notEmptyDateTime('access_time');

        $validator
            ->scalar('ip_address')
            ->maxLength('ip_address', 128)
            ->allowEmptyString('ip_address');

        $validator
            ->scalar('host_name')
            ->maxLength('host_name', 256)
            ->allowEmptyString('host_name');

        $validator
            ->scalar('referer')
            ->maxLength('referer', 512)
            ->allowEmptyString('referer');

        $validator
            ->scalar('browser_info')
            ->maxLength('browser_info', 512)
            ->allowEmptyString('browser_info');

        $validator
            ->scalar('request_method')
            ->maxLength('request_method', 512)
            ->allowEmptyString('request_method');

        return $validator;
    }
}
