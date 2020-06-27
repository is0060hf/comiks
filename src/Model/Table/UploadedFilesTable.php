<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UploadedFiles Model
 *
 * @method \App\Model\Entity\UploadedFile get($primaryKey, $options = [])
 * @method \App\Model\Entity\UploadedFile newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\UploadedFile[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\UploadedFile|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UploadedFile saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UploadedFile patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\UploadedFile[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\UploadedFile findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UploadedFilesTable extends Table
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

        $this->setTable('uploaded_files');
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
            ->scalar('file_path')
            ->maxLength('file_path', 512)
            ->allowEmptyFile('file_path');

        $validator
            ->boolean('used_flg')
            ->notEmptyString('used_flg');

        return $validator;
    }
}
