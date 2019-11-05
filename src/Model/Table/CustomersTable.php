<?php

	namespace App\Model\Table;

	use Cake\ORM\Query;
	use Cake\ORM\RulesChecker;
	use Cake\ORM\Table;
	use Cake\Validation\Validator;

	/**
	 * Customers Model
	 *
	 * @property \App\Model\Table\PriceTablesTable|\Cake\ORM\Association\HasMany $PriceTables
	 *
	 * @method \App\Model\Entity\Customer get($primaryKey, $options = [])
	 * @method \App\Model\Entity\Customer newEntity($data = null, array $options = [])
	 * @method \App\Model\Entity\Customer[] newEntities(array $data, array $options = [])
	 * @method \App\Model\Entity\Customer|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
	 * @method \App\Model\Entity\Customer|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
	 * @method \App\Model\Entity\Customer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
	 * @method \App\Model\Entity\Customer[] patchEntities($entities, array $data, array $options = [])
	 * @method \App\Model\Entity\Customer findOrCreate($search, callable $callback = null, $options = [])
	 *
	 * @mixin \Cake\ORM\Behavior\TimestampBehavior
	 */
	class CustomersTable extends Table {

		/**
		 * Initialize method
		 *
		 * @param array $config The configuration for the Table.
		 * @return void
		 */
		public function initialize(array $config) {
			parent::initialize($config);

			$this->setTable('customers');
			$this->setDisplayField('id');
			$this->setPrimaryKey('id');

			$this->addBehavior('Timestamp');

			$this->hasMany('PriceTables', [
					'foreignKey' => 'customer_id'
			]);

			$this->hasMany('RegularServices', [
					'foreignKey' => 'customer_id'
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
					->scalar('customers_name')
					->maxLength('customers_name', 256)
					->requirePresence('customers_name', 'create')
					->notEmpty('customers_name');

			$validator
					->scalar('customers_phone')
					->maxLength('customers_phone', 32)
					->allowEmpty('customers_phone');

			$validator
					->scalar('delivery_dest')
					->maxLength('delivery_dest', 256)
					->allowEmpty('delivery_dest');

			$validator
					->add('customers_name', [
							'customers_name_unique' => [
									'rule' => 'validateUnique',
									'provider' => 'table',
									'message' => 'その顧客名は既に使用されています'
							]
					]);

			return $validator;
		}
	}
