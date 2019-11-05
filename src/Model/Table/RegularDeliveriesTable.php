<?php

	namespace App\Model\Table;

	use Cake\ORM\Query;
	use Cake\ORM\RulesChecker;
	use Cake\ORM\Table;
	use Cake\Validation\Validator;

	/**
	 * RegularDeliveries Model
	 *
	 * @property \App\Model\Table\VouchersTable|\Cake\ORM\Association\BelongsTo $Vouchers
	 *
	 * @method \App\Model\Entity\RegularDelivery get($primaryKey, $options = [])
	 * @method \App\Model\Entity\RegularDelivery newEntity($data = null, array $options = [])
	 * @method \App\Model\Entity\RegularDelivery[] newEntities(array $data, array $options = [])
	 * @method \App\Model\Entity\RegularDelivery|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
	 * @method \App\Model\Entity\RegularDelivery|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
	 * @method \App\Model\Entity\RegularDelivery patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
	 * @method \App\Model\Entity\RegularDelivery[] patchEntities($entities, array $data, array $options = [])
	 * @method \App\Model\Entity\RegularDelivery findOrCreate($search, callable $callback = null, $options = [])
	 *
	 * @mixin \Cake\ORM\Behavior\TimestampBehavior
	 */
	class RegularDeliveriesTable extends Table {

		/**
		 * Initialize method
		 *
		 * @param array $config The configuration for the Table.
		 * @return void
		 */
		public function initialize(array $config) {
			parent::initialize($config);

			$this->setTable('regular_deliveries');
			$this->setDisplayField('id');
			$this->setPrimaryKey('id');

			$this->addBehavior('Timestamp');

			$this->belongsTo('RegularServices', [
					'foreignKey' => 'regular_service_id',
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
					->scalar('deliveries_or_cargo')
					->maxLength('deliveries_or_cargo', 64)
					->allowEmpty('deliveries_or_cargo');

			$validator
					->scalar('outward_or_return')
					->maxLength('outward_or_return', 32)
					->allowEmpty('outward_or_return');

			$validator
					->scalar('delivery_dest')
					->maxLength('delivery_dest', 256);

			$validator
					->scalar('start_location')
					->maxLength('start_location', 256);

			$validator
					->scalar('destination')
					->maxLength('destination', 256);

			$validator
					->scalar('is_exception')
					->maxLength('is_exception', 32)
					->allowEmpty('is_exception');

			$validator
					->scalar('appendix')
					->maxLength('appendix', 512)
					->allowEmpty('appendix');

			$validator
					->scalar('has_take_out')
					->maxLength('has_take_out', 32)
					->allowEmpty('has_take_out');

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
			$rules->add($rules->existsIn(['regular_service_id'], 'RegularServices'));

			return $rules;
		}
	}
