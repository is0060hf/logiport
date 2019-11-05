<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Invoices Model
 *
 * @property \App\Model\Table\BanksTable|\Cake\ORM\Association\BelongsTo $Banks
 * @property \App\Model\Table\VoucherInvoiceLinksTable|\Cake\ORM\Association\HasMany $VoucherInvoiceLinks
 *
 * @method \App\Model\Entity\Invoice get($primaryKey, $options = [])
 * @method \App\Model\Entity\Invoice newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Invoice[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Invoice|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Invoice|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Invoice patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Invoice[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Invoice findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class InvoicesTable extends Table
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

        $this->setTable('invoices');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Banks', [
            'foreignKey' => 'bank_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('VoucherInvoiceLinks', [
            'foreignKey' => 'invoice_id'
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
            ->allowEmpty('id', 'create');

        $validator
            ->integer('sum_fare')
            ->allowEmpty('sum_fare');

        $validator
            ->integer('sum_additional_fee')
            ->allowEmpty('sum_additional_fee');

        $validator
            ->integer('sum_advances_paid')
            ->allowEmpty('sum_advances_paid');

        $validator
            ->integer('sum_tax')
            ->allowEmpty('sum_tax');

        $validator
            ->integer('sum_price')
            ->allowEmpty('sum_price');

        $validator
            ->scalar('invoice_name')
            ->maxLength('invoice_name', 256)
            ->requirePresence('invoice_name', 'create')
            ->notEmpty('invoice_name');

        $validator
            ->scalar('invoice_atena')
            ->maxLength('invoice_atena', 256)
            ->requirePresence('invoice_atena', 'create')
            ->notEmpty('invoice_atena');

        $validator
            ->dateTime('invoice_date')
            ->allowEmpty('invoice_date');

        $validator
            ->scalar('moto_name')
            ->maxLength('moto_name', 256)
            ->requirePresence('moto_name', 'create')
            ->notEmpty('moto_name');

        $validator
            ->scalar('moto_zip')
            ->maxLength('moto_zip', 16)
            ->allowEmpty('moto_zip');

        $validator
            ->scalar('moto_address')
            ->maxLength('moto_address', 512)
            ->allowEmpty('moto_address');

        $validator
            ->scalar('moto_tel')
            ->maxLength('moto_tel', 32)
            ->allowEmpty('moto_tel');

        $validator
            ->scalar('moto_fax')
            ->maxLength('moto_fax', 32)
            ->allowEmpty('moto_fax');

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
        $rules->add($rules->existsIn(['bank_id'], 'Banks'));

        return $rules;
    }
}
