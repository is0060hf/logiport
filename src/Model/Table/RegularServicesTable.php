<?php

	namespace App\Model\Table;

	use Cake\ORM\Query;
	use Cake\ORM\RulesChecker;
	use Cake\ORM\Table;
	use Cake\Validation\Validator;

	/**
	 * RegularServices Model
	 *
	 * @property \App\Model\Table\CustomersTable|\Cake\ORM\Association\BelongsTo    $Customers
	 *
	 * @method \App\Model\Entity\RegularService get($primaryKey, $options = [])
	 * @method \App\Model\Entity\RegularService newEntity($data = null, array $options = [])
	 * @method \App\Model\Entity\RegularService[] newEntities(array $data, array $options = [])
	 * @method \App\Model\Entity\RegularService|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
	 * @method \App\Model\Entity\RegularService|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
	 * @method \App\Model\Entity\RegularService patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
	 * @method \App\Model\Entity\RegularService[] patchEntities($entities, array $data, array $options = [])
	 * @method \App\Model\Entity\RegularService findOrCreate($search, callable $callback = null, $options = [])
	 *
	 * @mixin \Cake\ORM\Behavior\TimestampBehavior
	 */
	class RegularServicesTable extends Table {

		/**
		 * Initialize method
		 *
		 * @param array $config The configuration for the Table.
		 * @return void
		 */
		public function initialize(array $config) {
			parent::initialize($config);

			$this->setTable('regular_services');
			$this->setDisplayField('id');
			$this->setPrimaryKey('id');

			$this->addBehavior('Timestamp');

			$this->hasMany('RegularDeliveries', [
					'foreignKey' => 'customer_id',
					'joinType' => 'INNER'
			]);

			$this->belongsTo('Customers', [
					'foreignKey' => 'customer_id',
					'joinType' => 'INNER'
			]);
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
					->scalar('regular_service_name')
					->maxLength('regular_service_name', 256)
					->notEmpty('regular_service_name');

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
			$rules->add($rules->existsIn(['customer_id'], 'Customers'));

			return $rules;
		}
	}
