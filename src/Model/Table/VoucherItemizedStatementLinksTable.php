<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * VoucherItemizedStatementLinks Model
 *
 * @property \App\Model\Table\ItemizedStatementsTable|\Cake\ORM\Association\BelongsTo $ItemizedStatements
 * @property \App\Model\Table\VouchersTable|\Cake\ORM\Association\BelongsTo $Vouchers
 *
 * @method \App\Model\Entity\VoucherItemizedStatementLink get($primaryKey, $options = [])
 * @method \App\Model\Entity\VoucherItemizedStatementLink newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\VoucherItemizedStatementLink[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\VoucherItemizedStatementLink|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VoucherItemizedStatementLink|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VoucherItemizedStatementLink patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\VoucherItemizedStatementLink[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\VoucherItemizedStatementLink findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class VoucherItemizedStatementLinksTable extends Table
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

        $this->setTable('voucher_itemized_statement_links');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ItemizedStatements', [
            'foreignKey' => 'itemized_statement_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Vouchers', [
            'foreignKey' => 'voucher_id',
            'joinType' => 'INNER'
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
        $rules->add($rules->existsIn(['itemized_statement_id'], 'ItemizedStatements'));
        $rules->add($rules->existsIn(['voucher_id'], 'Vouchers'));

        return $rules;
    }
}
