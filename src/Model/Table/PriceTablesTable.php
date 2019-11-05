<?php

	namespace App\Model\Table;

	use App\Model\Entity\PriceTable;
	use Cake\ORM\Query;
	use Cake\ORM\RulesChecker;
	use Cake\ORM\Table;
	use Cake\Validation\Validator;

	/**
	 * PriceTables Model
	 *
	 * @property \App\Model\Table\CustomersTable|\Cake\ORM\Association\BelongsTo    $Customers
	 * @property \App\Model\Table\CargoPricesTable|\Cake\ORM\Association\HasMany    $CargoPrices
	 * @property \App\Model\Table\CountPricesTable|\Cake\ORM\Association\HasMany    $CountPrices
	 * @property \App\Model\Table\DistancePricesTable|\Cake\ORM\Association\HasMany $DistancePrices
	 * @property \App\Model\Table\WaitingPricesTable|\Cake\ORM\Association\HasMany  $WaitingPrices
	 * @property \App\Model\Table\WorkingPricesTable|\Cake\ORM\Association\HasMany  $WorkingPrices
	 *
	 * @method \App\Model\Entity\PriceTable get($primaryKey, $options = [])
	 * @method \App\Model\Entity\PriceTable newEntity($data = null, array $options = [])
	 * @method \App\Model\Entity\PriceTable[] newEntities(array $data, array $options = [])
	 * @method \App\Model\Entity\PriceTable|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
	 * @method \App\Model\Entity\PriceTable|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
	 * @method \App\Model\Entity\PriceTable patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
	 * @method \App\Model\Entity\PriceTable[] patchEntities($entities, array $data, array $options = [])
	 * @method \App\Model\Entity\PriceTable findOrCreate($search, callable $callback = null, $options = [])
	 *
	 * @mixin \Cake\ORM\Behavior\TimestampBehavior
	 */
	class PriceTablesTable extends Table {

		/**
		 * Initialize method
		 *
		 * @param array $config The configuration for the Table.
		 * @return void
		 */
		public function initialize(array $config) {
			parent::initialize($config);

			$this->setTable('price_tables');
			$this->setDisplayField('id');
			$this->setPrimaryKey('id');

			$this->addBehavior('Timestamp');

			$this->belongsTo('Customers', [
					'foreignKey' => 'customer_id',
					'joinType' => 'INNER'
			]);
			$this->hasMany('CargoPrices', [
					'foreignKey' => 'price_table_id'
			]);
			$this->hasMany('CountPrices', [
					'foreignKey' => 'price_table_id'
			]);
			$this->hasMany('DistancePrices', [
					'foreignKey' => 'price_table_id'
			]);
			$this->hasMany('WaitingPrices', [
					'foreignKey' => 'price_table_id'
			]);
			$this->hasMany('WorkingPrices', [
					'foreignKey' => 'price_table_id'
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
					->integer('basic_price')
					->requirePresence('basic_price', 'create')
					->notEmpty('basic_price');

			$validator
					->integer('return_magnification')
					->allowEmpty('return_magnification');

			$validator
					->integer('return_additional_fee')
					->allowEmpty('return_additional_fee');

			$validator
					->integer('cancel_fee')
					->allowEmpty('cancel_fee');

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
