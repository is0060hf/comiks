<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \App\Model\Table\CategoriesTable&\Cake\ORM\Association\HasMany $Categories
 * @property \App\Model\Table\CategoryNamesTable&\Cake\ORM\Association\HasMany $CategoryNames
 * @property &\Cake\ORM\Association\HasMany $Contacts
 * @property \App\Model\Table\PageNamesTable&\Cake\ORM\Association\HasMany $PageNames
 * @property \App\Model\Table\PostsTable&\Cake\ORM\Association\HasMany $Posts
 * @property \App\Model\Table\PricePlansTable&\Cake\ORM\Association\HasMany $PricePlans
 * @property \App\Model\Table\UserActivitiesTable&\Cake\ORM\Association\HasMany $UserActivities
 * @property \App\Model\Table\UserNoticeFlagsTable&\Cake\ORM\Association\HasMany $UserNoticeFlags
 * @property \App\Model\Table\UserNoticesTable&\Cake\ORM\Association\HasMany $UserNotices
 * @property \App\Model\Table\UserSkillsTable&\Cake\ORM\Association\HasMany $UserSkills
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Categories', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('CategoryNames', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Contacts', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('PageNames', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Posts', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('PricePlans', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('UserActivities', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('UserNoticeFlags', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('UserNotices', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('UserSkills', [
            'foreignKey' => 'user_id',
        ]);
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
            ->scalar('login_name')
            ->maxLength('login_name', 255)
            ->requirePresence('login_name', 'create')
            ->notEmptyString('login_name')
            ->add('login_name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('login_cd')
            ->maxLength('login_cd', 255)
            ->requirePresence('login_cd', 'create')
            ->notEmptyString('login_cd')
            ->add('login_cd', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('password')
            ->maxLength('password', 256)
            ->requirePresence('password', 'create')
            ->notEmptyString('password');

        $validator
            ->scalar('mail_address')
            ->maxLength('mail_address', 512)
            ->allowEmptyString('mail_address');

        $validator
            ->integer('rank_kb')
            ->notEmptyString('rank_kb');

        $validator
            ->integer('user_role')
            ->notEmptyString('user_role');

        $validator
            ->scalar('job_name')
            ->maxLength('job_name', 512)
            ->allowEmptyString('job_name');

        $validator
            ->scalar('twitter_account')
            ->maxLength('twitter_account', 256)
            ->allowEmptyString('twitter_account');

        $validator
            ->scalar('youtube_account')
            ->maxLength('youtube_account', 256)
            ->allowEmptyString('youtube_account');

        $validator
            ->scalar('instagram_account')
            ->maxLength('instagram_account', 256)
            ->allowEmptyString('instagram_account');

        $validator
            ->scalar('facebook_account')
            ->maxLength('facebook_account', 256)
            ->allowEmptyString('facebook_account');

        $validator
            ->scalar('intro_message')
            ->maxLength('intro_message', 512)
            ->allowEmptyString('intro_message');

        $validator
            ->scalar('skill_message')
            ->maxLength('skill_message', 512)
            ->allowEmptyString('skill_message');

        $validator
            ->scalar('icon_image_path')
            ->maxLength('icon_image_path', 512)
            ->allowEmptyFile('icon_image_path');

        $validator
            ->scalar('default_featured_image_path')
            ->maxLength('default_featured_image_path', 512)
            ->allowEmptyFile('default_featured_image_path');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['login_name']));
        $rules->add($rules->isUnique(['login_cd']));

        return $rules;
    }
}
