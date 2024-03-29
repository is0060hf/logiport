<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AdditionalPrice Entity
 *
 * @property int $id
 * @property int $delivery_id
 * @property string $advances_or_additional
 * @property string $title
 * @property int $price
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Delivery $delivery
 */
class AdditionalPrice extends Entity
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
        'delivery_id' => true,
        'advances_or_additional' => true,
        'title' => true,
        'price' => true,
        'created' => true,
        'modified' => true,
        'delivery' => true
    ];
}
