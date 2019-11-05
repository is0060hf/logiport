<?php

	namespace App\Model\Table;

	use Cake\ORM\Query;
	use Cake\ORM\RulesChecker;
	use Cake\ORM\Table;
	use Cake\Validation\Validator;

	/**
	 * Deliveries Model
	 *
	 * @property \App\Model\Table\VouchersTable|\Cake\ORM\Association\BelongsTo $Vouchers
	 *
	 * @method \App\Model\Entity\Delivery get($primaryKey, $options = [])
	 * @method \App\Model\Entity\Delivery newEntity($data = null, array $options = [])
	 * @method \App\Model\Entity\Delivery[] newEntities(array $data, array $options = [])
	 * @method \App\Model\Entity\Delivery|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
	 * @method \App\Model\Entity\Delivery|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
	 * @method \App\Model\Entity\Delivery patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
	 * @method \App\Model\Entity\Delivery[] patchEntities($entities, array $data, array $options = [])
	 * @method \App\Model\Entity\Delivery findOrCreate($search, callable $callback = null, $options = [])
	 *
	 * @mixin \Cake\ORM\Behavior\TimestampBehavior
	 */
	class DeliveryHistoriesTable extends Table {

		/**
		 * Initialize method
		 *
		 * @param array $config The configuration for the Table.
		 * @return void
		 */
		public function initialize(array $config) {
			parent::initialize($config);

			$this->setTable('delivery_histories');
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
					->scalar('start_location')
					->maxLength('start_location', 256);

			$validator
					->scalar('destination')
					->maxLength('destination', 256);

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
			return $rules;
		}
	}
