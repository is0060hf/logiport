<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * WorkingPrice Entity
 *
 * @property int $id
 * @property int $price_table_id
 * @property int $working
 * @property int $price
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\PriceTable $price_table
 */
class WorkingPrice extends Entity
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
        'price_table_id' => true,
        'working' => true,
        'price' => true,
        'created' => true,
        'modified' => true,
        'price_table' => true
    ];
}
