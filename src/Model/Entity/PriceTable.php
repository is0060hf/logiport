<?php

	namespace App\Model\Entity;

	use Cake\ORM\Entity;

	/**
	 * PriceTable Entity
	 *
	 * @property int                               $id
	 * @property int                               $customer_id
	 * @property int                               $basic_price
	 * @property int|null                          $return_magnification
	 * @property int|null                          $return_additional_fee
	 * @property int|null                          $cancel_fee
	 * @property \Cake\I18n\FrozenTime|null        $created
	 * @property \Cake\I18n\FrozenTime|null        $modified
	 *
	 * @property \App\Model\Entity\Customer        $customer
	 * @property \App\Model\Entity\CargoPrice[]    $cargo_prices
	 * @property \App\Model\Entity\CountPrice[]    $count_prices
	 * @property \App\Model\Entity\DistancePrice[] $distance_prices
	 * @property \App\Model\Entity\WaitingPrice[]  $waiting_prices
	 * @property \App\Model\Entity\WorkingPrice[]  $working_prices
	 */
	class PriceTable extends Entity {

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
				'customer_id' => true,
				'mode' => true,
				'basic_price' => true,
				'return_magnification' => true,
				'return_additional_fee' => true,
				'waiting_basic_min' => true,
				'waiting_fee' => true,
				'handling_basic_min' => true,
				'handling_fee' => true,
				'cargo_basic_dist' => true,
				'cargo_fee' => true,
				'cancel_fee' => true,
				'created' => true,
				'modified' => true,
				'customer' => true,
				'cargo_prices' => true,
				'count_prices' => true,
				'distance_prices' => true,
				'waiting_prices' => true,
				'working_prices' => true,
				'upper_limit_delivery_for_free' => true,
				'additional_delivery_price' => true
		];
	}
