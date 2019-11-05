<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Invoice Entity
 *
 * @property int $id
 * @property int $bank_id
 * @property int|null $sum_fare
 * @property int|null $sum_additional_fee
 * @property int|null $sum_advances_paid
 * @property int|null $sum_tax
 * @property int|null $sum_price
 * @property string $invoice_name
 * @property string $invoice_atena
 * @property \Cake\I18n\FrozenTime|null $invoice_date
 * @property string $moto_name
 * @property string|null $moto_zip
 * @property string|null $moto_address
 * @property string|null $moto_tel
 * @property string|null $moto_fax
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Bank $bank
 * @property \App\Model\Entity\VoucherInvoiceLink[] $voucher_invoice_links
 */
class Invoice extends Entity
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
        'bank_id' => true,
        'sum_fare' => true,
        'sum_additional_fee' => true,
        'sum_advances_paid' => true,
        'sum_tax' => true,
        'sum_price' => true,
        'invoice_name' => true,
        'invoice_atena' => true,
        'invoice_date' => true,
        'moto_name' => true,
        'moto_zip' => true,
        'moto_address' => true,
        'moto_tel' => true,
        'moto_fax' => true,
        'created' => true,
        'modified' => true,
        'bank' => true,
        'voucher_invoice_links' => true
    ];
}
