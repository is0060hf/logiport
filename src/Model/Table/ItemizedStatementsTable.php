<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ItemizedStatements Model
 *
 * @property \App\Model\Table\ItemizedStatementInvoiceLinksTable|\Cake\ORM\Association\HasMany $ItemizedStatementInvoiceLinks
 * @property \App\Model\Table\VoucherItemizedStatementLinksTable|\Cake\ORM\Association\HasMany $VoucherItemizedStatementLinks
 *
 * @method \App\Model\Entity\ItemizedStatement get($primaryKey, $options = [])
 * @method \App\Model\Entity\ItemizedStatement newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ItemizedStatement[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ItemizedStatement|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ItemizedStatement|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ItemizedStatement patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ItemizedStatement[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ItemizedStatement findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ItemizedStatementsTable extends Table
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

        $this->setTable('itemized_statements');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('ItemizedStatementInvoiceLinks', [
            'foreignKey' => 'itemized_statement_id'
        ]);
        $this->hasMany('VoucherItemizedStatementLinks', [
            'foreignKey' => 'itemized_statement_id'
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
}
