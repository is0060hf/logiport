<?php

	namespace App\Model\Table;

	use Cake\ORM\Query;
	use Cake\ORM\RulesChecker;
	use Cake\ORM\Table;
	use Cake\Validation\Validator;

	/**
	 * Routes Model
	 *
	 * @property \App\Model\Table\VouchersTable|\Cake\ORM\Association\BelongsTo $Vouchers
	 *
	 * @method \App\Model\Entity\Route get($primaryKey, $options = [])
	 * @method \App\Model\Entity\Route newEntity($data = null, array $options = [])
	 * @method \App\Model\Entity\Route[] newEntities(array $data, array $options = [])
	 * @method \App\Model\Entity\Route|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
	 * @method \App\Model\Entity\Route|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
	 * @method \App\Model\Entity\Route patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
	 * @method \App\Model\Entity\Route[] patchEntities($entities, array $data, array $options = [])
	 * @method \App\Model\Entity\Route findOrCreate($search, callable $callback = null, $options = [])
	 *
	 * @mixin \Cake\ORM\Behavior\TimestampBehavior
	 */
	class RoutesTable extends Table {

		/**
		 * Initialize method
		 *
		 * @param array $config The configuration for the Table.
		 * @return void
		 */
		public function initialize(array $config) {
			parent::initialize($config);

			$this->setTable('routes');
			$this->setDisplayField('id');
			$this->setPrimaryKey('id');

			$this->addBehavior('Timestamp');

			$this->belongsTo('Vouchers', [
					'foreignKey' => 'voucher_id',
					'joinType' => 'INNER'
			]);

			$this->belongsTo('Deliveries', [
					'foreignKey' => 'delivery_id',
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
					->scalar('on_ic')
					->maxLength('on_ic', 256)
					->requirePresence('on_ic', 'create')
					->notEmpty('on_ic');

			$validator
					->scalar('off_ic')
					->maxLength('off_ic', 256)
					->requirePresence('off_ic', 'create')
					->notEmpty('off_ic');

			$validator
					->integer('price')
					->allowEmpty('price');

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
			$rules->add($rules->existsIn(['voucher_id'], 'Vouchers'));
			$rules->add($rules->existsIn(['delivery_id'], 'Deliveries'));

			return $rules;
		}
	}
