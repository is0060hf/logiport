<?php

	namespace App\Model\Table;

	use Cake\ORM\Query;
	use Cake\ORM\RulesChecker;
	use Cake\ORM\Table;
	use Cake\Validation\Validator;

	/**
	 * Users Model
	 *
	 * @method \App\Model\Entity\User get($primaryKey, $options = [])
	 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
	 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
	 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
	 * @method \App\Model\Entity\User|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
	 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
	 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
	 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
	 *
	 * @mixin \Cake\ORM\Behavior\TimestampBehavior
	 */
	class UsersTable extends Table {

		/**
		 * Initialize method
		 *
		 * @param array $config The configuration for the Table.
		 * @return void
		 */
		public function initialize(array $config) {
			parent::initialize($config);

			$this->setTable('users');
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
		public function validationDefault(Validator $validator) {
			$validator
					->integer('id')
					->allowEmpty('id', 'create');

			$validator
					->scalar('username')
					->maxLength('username', 255)
					->requirePresence('username', 'create')
					->notEmpty('username');

			$validator->add('username',[
					'username_unique'  => [
							'rule' => 'validateUnique',
							'provider' => 'table',
							'message' => 'そのユーザー名はすでに使用されています'
					]
			]);

			$validator
					->scalar('password')
					->maxLength('password', 255)
					->requirePresence('password', 'create')
					->notEmpty('password');

			$validator
					->scalar('mail_address')
					->maxLength('mail_address', 255)
					->allowEmpty('mail_address');

			$validator
					->scalar('car_numb')
					->maxLength('car_numb', 128)
					->allowEmpty('car_numb');

			$validator
					->scalar('insurance_fee')
					->allowEmpty('insurance_fee');

			$validator
					->scalar('car_fee')
					->allowEmpty('car_fee');

			$validator
					->scalar('commition')
					->allowEmpty('commition');

			$validator
					->scalar('user_role')
					->maxLength('user_role', 64)
					->allowEmpty('user_role');

			return $validator;
		}

		/**
		 * Returns a rules checker object that will be used for validating
		 * application integrity.
		 *
		 * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
		 * @return \Cake\ORM\RulesChecker
		 */
		public function buildRules(RulesChecker $rules) {
			$rules->add($rules->isUnique(['username']));

			return $rules;
		}
	}
