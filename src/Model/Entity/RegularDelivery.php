<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RegularDelivery Entity
 *
 * @property int $id
 * @property int $regular_service_id
 * @property string $deliveryman_name
 * @property string $is_regular
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
class RegularDelivery extends Entity
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
        'regular_service_id' => true,
        'deliveries_or_cargo' => true,
        'outward_or_return' => true,
        'delivery_dest' => true,
        'start_location' => true,
        'destination' => true,
        'distance' => true,
        'price' => true,
        'additional_price' => true,
        'advances_paid' => true,
        'is_exception' => true,
        'appendix' => true,
        'has_take_out' => true,
        'created' => true,
        'modified' => true
    ];
}
