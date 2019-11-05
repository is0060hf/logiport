<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Voucher Entity
 *
 * @property int $id
 * @property string $deliveryman_name
 * @property string $is_regular
 * @property int $regular_service_id
 * @property string|null $car_numb
 * @property string|null $cs
 * @property string|null $shipper_sign
 * @property string $customers_name
 * @property string $delivery_dest
 * @property \Cake\I18n\FrozenTime $arrival_time
 * @property \Cake\I18n\FrozenTime $departure_time
 * @property string|null $customers_phone
 * @property string|null $has_return_cargo
 * @property string|null $appendix
 * @property string|null $dist_outward
 * @property string|null $dist_return
 * @property string|null $price_outword
 * @property string|null $price_return
 * @property string|null $cargo_handling_fee
 * @property string|null $cargo_waiting_fee
 * @property string|null $sum_price1
 * @property string|null $tax
 * @property string|null $sum_price2
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Delivery[] $deliveries
 * @property \App\Model\Entity\Route[] $routes
 */
class Voucher extends Entity
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
        'deliveryman_name' => true,
        'is_regular' => true,
        'regular_service_id' => true,
        'car_numb' => true,
        'cs' => true,
        'shipper_sign' => true,
        'customers_name' => true,
        'delivery_dest' => true,
        'arrival_time' => true,
        'departure_time' => true,
        'customers_phone' => true,
        'has_return_cargo' => true,
        'appendix' => true,
        'dist_outward' => true,
        'dist_return' => true,
        'price_outword' => true,
        'price_return' => true,
        'cargo_handling_min' => true,
        'cargo_handling_fee' => true,
        'cargo_waiting_min' => true,
        'cargo_waiting_fee' => true,
        'sum_price1' => true,
        'tax' => true,
        'sum_price2' => true,
        'created' => true,
        'modified' => true,
        'deliveries' => true,
        'routes' => true
    ];
}
