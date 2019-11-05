<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Route Entity
 *
 * @property int $id
 * @property int $voucher_id
 * @property string $on_ic
 * @property string $off_ic
 * @property int|null $price
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Voucher $voucher
 */
class Route extends Entity
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
        'delivery_id' => true,
        'advances_or_additional' => true,
        'on_ic' => true,
        'off_ic' => true,
        'price' => true,
        'created' => true,
        'modified' => true,
        'voucher' => true,
        'delivery' => true
    ];
}
