<?php

	namespace App\Model\Entity;

	use Cake\ORM\Entity;

	/**
	 * Customer Entity
	 *
	 * @property int                                $id
	 * @property string                             $customers_name
	 * @property string|null                        $customers_phone
	 * @property string|null                        $delivery_dest
	 * @property \Cake\I18n\FrozenTime|null         $created
	 * @property \Cake\I18n\FrozenTime|null         $modified
	 *
	 * @property \App\Model\Entity\PriceTable[]     $price_tables
	 * @property \App\Model\Entity\RegularService[] $regular_services
	 */
	class Customer extends Entity {

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
				'customers_name' => true,
				'customers_phone' => true,
				'delivery_dest' => true,
				'created' => true,
				'modified' => true,
				'price_tables' => true,
				'regular_services' => true
		];
	}
