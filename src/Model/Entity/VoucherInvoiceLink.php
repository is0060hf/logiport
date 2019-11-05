<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * VoucherInvoiceLink Entity
 *
 * @property int $id
 * @property int $voucher_id
 * @property int $invoice_id
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Voucher $voucher
 * @property \App\Model\Entity\Invoice $invoice
 */
class VoucherInvoiceLink extends Entity
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
        'voucher_id' => true,
        'invoice_id' => true,
        'created' => true,
        'modified' => true,
        'voucher' => true,
        'invoice' => true
    ];
}
