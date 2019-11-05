<?php

	namespace App\Model\Entity;

	use Cake\Auth\DefaultPasswordHasher;
	use Cake\ORM\Entity;

	/**
	 * User Entity
	 *
	 * @property int                        $id
	 * @property string                     $username
	 * @property string                     $password
	 * @property string|null                $mail_address
	 * @property int|null                   $user_role
	 * @property \Cake\I18n\FrozenTime|null $created
	 * @property \Cake\I18n\FrozenTime|null $modified
	 */
	class ExtUser extends User {

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
				'username' => true,
				'password' => true,
				'mail_address' => true,
				'user_role' => true,
				'created' => true,
				'modified' => true
		];

		protected function _setPassword($password) {
			if (strlen($password) > 0) {
				return (new DefaultPasswordHasher)->hash($password);
			}
		}

		/**
		 * Fields that are excluded from JSON versions of the entity.
		 *
		 * @var array
		 */
		protected $_hidden = [
				'password'
		];
	}
