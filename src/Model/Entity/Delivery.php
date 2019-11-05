<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Delivery Entity
 *
 * @property int $id
 * @property int $voucher_id
 * @property string|null $deliveries_or_cargo
 * @property string|null $outward_or_return
 * @property string|null $delivery_dest
 * @property string|null $start_location
 * @property string $destination
 * @property int $distance
 * @property int $price
 * @property int $additional_price
 * @property int $advances_paid
 * @property string|null $is_exception
 * @property string|null $appendix
 * @property string|null $receipt_flg
 * @property \Cake\I18n\FrozenTime $arrival_time
 * @property \Cake\I18n\FrozenTime $complete_time
 * @property string|null $has_take_out
 * @property string|null $temperature
 * @property string|null $receipt_sign
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Voucher $voucher
 */
class Delivery extends Entity
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
        'deliveries_or_cargo' => true,
        'outward_or_return' => true,
        'start_location' => true,
        'delivery_dest' => true,
        'destination' => true,
        'distance' => true,
        'price' => true,
        'additional_price' => true,
        'advances_paid' => true,
        'is_exception' => true,
        'appendix' => true,
        'receipt_flg' => true,
        'arrival_time' => true,
        'complete_time' => true,
        'has_take_out' => true,
        'temperature' => true,
        'receipt_sign' => true,
        'created' => true,
        'modified' => true,
        'voucher' => true
    ];
}
