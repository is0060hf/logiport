<?php

	namespace App\Model\Table;

	use Cake\ORM\Query;
	use Cake\ORM\RulesChecker;
	use Cake\ORM\Table;
	use Cake\Validation\Validator;

	/**
	 * Vouchers Model
	 *
	 * @method \App\Model\Entity\Voucher get($primaryKey, $options = [])
	 * @method \App\Model\Entity\Voucher newEntity($data = null, array $options = [])
	 * @method \App\Model\Entity\Voucher[] newEntities(array $data, array $options = [])
	 * @method \App\Model\Entity\Voucher|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
	 * @method \App\Model\Entity\Voucher|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
	 * @method \App\Model\Entity\Voucher patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
	 * @method \App\Model\Entity\Voucher[] patchEntities($entities, array $data, array $options = [])
	 * @method \App\Model\Entity\Voucher findOrCreate($search, callable $callback = null, $options = [])
	 *
	 * @mixin \Cake\ORM\Behavior\TimestampBehavior
	 */
	class ExtVouchersTable extends VouchersTable {

		/**
		 * Initialize method
		 *
		 * @param array $config The configuration for the Table.
		 * @return void
		 */
		public function initialize(array $config) {
			parent::initialize($config);

			$this->setTable('vouchers');
			$this->setDisplayField('id');
			$this->setPrimaryKey('id');

			$this->hasMany('Deliveries')->setForeignKey('vouchers_id');
			$this->hasMany('Routes')->setForeignKey('vouchers_id');
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
					->scalar('deliveryman_name')
					->maxLength('deliveryman_name', 128)
					->requirePresence('deliveryman_name', 'create')
					->notEmpty('deliveryman_name');

			$validator
					->scalar('car_numb')
					->maxLength('car_numb', 128)
					->allowEmpty('car_numb');

			$validator
					->scalar('cs')
					->maxLength('cs', 128)
					->allowEmpty('cs');

			$validator
					->integer('shipper_sign')
					->allowEmpty('shipper_sign');

			$validator
					->scalar('customers_name')
					->maxLength('customers_name', 256)
					->requirePresence('customers_name', 'create')
					->notEmpty('customers_name');

			$validator
					->scalar('delivery_dest')
					->maxLength('delivery_dest', 256)
					->requirePresence('delivery_dest', 'create')
					->notEmpty('delivery_dest');

			$validator
					->dateTime('arrival_time')
					->requirePresence('arrival_time', 'create')
					->notEmpty('arrival_time');

			$validator
					->dateTime('departure_time')
					->requirePresence('departure_time', 'create')
					->notEmpty('departure_time');

			$validator
					->scalar('customers_phone')
					->maxLength('customers_phone', 256)
					->allowEmpty('customers_phone');

			$validator
					->integer('has_return_cargo')
					->allowEmpty('has_return_cargo');

			$validator
					->scalar('appendix')
					->maxLength('appendix', 1024)
					->allowEmpty('appendix');

			$validator
					->scalar('dist_outward')
					->maxLength('dist_outward', 256)
					->allowEmpty('dist_outward');

			$validator
					->scalar('dist_return')
					->maxLength('dist_return', 256)
					->allowEmpty('dist_return');

			$validator
					->scalar('price_outword')
					->maxLength('price_outword', 256)
					->allowEmpty('price_outword');

			$validator
					->scalar('price_return')
					->maxLength('price_return', 256)
					->allowEmpty('price_return');

			$validator
					->scalar('cargo_handling_fee')
					->maxLength('cargo_handling_fee', 256)
					->allowEmpty('cargo_handling_fee');

			$validator
					->scalar('cargo_waiting_fee')
					->maxLength('cargo_waiting_fee', 256)
					->allowEmpty('cargo_waiting_fee');

			$validator
					->scalar('sum_price1')
					->maxLength('sum_price1', 256)
					->allowEmpty('sum_price1');

			$validator
					->scalar('tax')
					->maxLength('tax', 256)
					->allowEmpty('tax');

			$validator
					->scalar('sum_price2')
					->maxLength('sum_price2', 256)
					->allowEmpty('sum_price2');

			return $validator;
		}
	}
