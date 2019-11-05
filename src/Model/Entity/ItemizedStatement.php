<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ItemizedStatement Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenDate $billing_date
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\ItemizedStatementInvoiceLink[] $itemized_statement_invoice_links
 * @property \App\Model\Entity\VoucherItemizedStatementLink[] $voucher_itemized_statement_links
 */
class ItemizedStatement extends Entity
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
        'billing_date' => true,
        'delivery_dest' => true,
        'delivery_dest_count' => true,
        'customers_name' => true,
        'distance' => true,
        'price' => true,
        'additional_price' => true,
        'advances_paid' => true,
        'appendix' => true,
        'created' => true,
        'modified' => true,
        'itemized_statement_invoice_links' => true,
        'voucher_itemized_statement_links' => true
    ];
}
