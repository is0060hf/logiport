<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ItemizedStatementInvoiceLink Entity
 *
 * @property int $id
 * @property int $itemized_statement_id
 * @property int $invoice_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\ItemizedStatement $itemized_statement
 * @property \App\Model\Entity\Invoice $invoice
 */
class ItemizedStatementInvoiceLink extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'itemized_statement_id' => true,
        'invoice_id' => true,
        'created' => true,
        'modified' => true,
        'itemized_statement' => true,
        'invoice' => true
    ];
}
