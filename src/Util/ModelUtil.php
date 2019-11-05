<?php
	/**
	 * Created by PhpStorm.
	 * User: kyuuya58
	 * Date: 2019/06/06
	 * Time: 5:36
	 */
	namespace App\Util;

	use Cake\ORM\TableRegistry;
	use Cake\Datasource\ConnectionManager;

	class ModelUtil {

		/**
		 * 指定の伝票に紐づくDelivery情報の料金を再計算する
		 * @param $voucher_id
		 */
		public static function updateDeliveryPrices($voucher_id){
			$connection = ConnectionManager::get('default');

			// トランザクション開始
			$connection->begin();
			try {
				$voucher = TableRegistry::get('Vouchers')->find('All')->where(['id' => $voucher_id])->first();
				$deliveries = TableRegistry::get('Deliveries')->find('All')->where(['voucher_id' => $voucher_id]);
				$cst = TableRegistry::get('Customers')->find('All')->where(['customers_name' => $voucher->customers_name])->first();
				$saveResult = true;
				foreach ($deliveries as $delivery){
					$delivery->price = ModelUtil::getPriceFromDistance($cst->id,$delivery->distance);

					if(!TableRegistry::get('Deliveries')->save($delivery)){
						$saveResult = false;
					}
				}

				if($saveResult){
					$connection->commit();
				}else{
					$connection->rollback();
				}
			} catch(\Exception $e) {
				// ロールバック
				$connection->rollback();
			}
		}

		/**
		 * 指定のDelivery情報の料金を再計算する
		 * @param $voucher_id
		 */
		public static function updateDeliveryPrice($delivery_id){
			$connection = ConnectionManager::get('default');

			// トランザクション開始
			$connection->begin();
			try {
				$delivery = TableRegistry::get('Deliveries')->find('All')->where(['id' => $delivery_id])->first();
				$voucher = TableRegistry::get('Vouchers')->find('All')->where(['id' => $delivery->voucher_id])->first();
				$cst = TableRegistry::get('Customers')->find('All')->where(['customers_name' => $voucher->customers_name])->first();

				$delivery->price = ModelUtil::getPriceFromDistance($cst->id,$delivery->distance);

				if(TableRegistry::get('Deliveries')->save($delivery)){
					$connection->commit();
				}else{
					$connection->rollback();
				}

			} catch(\Exception $e) {
				// ロールバック
				$connection->rollback();
			}
		}

		/**
		 * 指定の帳票の料金情報を、紐づくDelivery情報から計算する。
		 * @param $voucher_id
		 */
		public static function updateVoucherPrice($voucher_id){
			$connection = ConnectionManager::get('default');
			// トランザクション開始
			$connection->begin();
			try {

				$voucher = TableRegistry::get('Vouchers')->find('All')->where(['id' => $voucher_id])->first();
				$voucher->sum_price1 = ModelUtil::getSumPrice1($voucher->id);
				$voucher->tax = round($voucher->sum_price1 * 0.08);
				$voucher->sum_price2 = $voucher->sum_price1 + $voucher->tax + ModelUtil::getSumAdvancesPaid($voucher->id);

				if(TableRegistry::get('Vouchers')->save($voucher)){
					$connection->commit();
				}else{
					$connection->rollback();
				}

			} catch(\Exception $e) {
				// ロールバック
				$connection->rollback();
			}

		}

		/**
		 * 立替金の合計を計算する
		 * @param $id
		 * @return int
		 */
		public static function getSumAdvancesPaid($id) {
			$voucher = TableRegistry::get('Vouchers')->find('All')->where(['id' => $id])->first();

			if ($voucher) {
				$deliveries = TableRegistry::get('Deliveries')->find('All')->where(['voucher_id' => $voucher->id]);
				$resultPrice = 0;
				foreach ($deliveries as $delivery) {
					$resultPrice += $delivery->advances_paid;
				}
				return $resultPrice;
			} else {
				return 0;
			}
		}

		/**
		 * 追加料金と運賃の合計金額を算出する
		 * @param $id : 伝票ID
		 * @param $delDist : 削除分の距離
		 * @return int
		 */
		public static function getSumPrice1($id, $delDist = 0) {
			$voucher = TableRegistry::get('Vouchers')->find('All')->where(['id' => $id])->first();
			$cst = TableRegistry::get('Customers')->find('All')->where(['customers_name' => $voucher->customers_name])->first();

			if ($voucher && $cst) {
				$deliveries = TableRegistry::get('Deliveries')->find('All')->where(['voucher_id' => $voucher->id]);
				$sumAdditionalPrice = 0;
				$sumDistance = 0;
				foreach ($deliveries as $delivery) {
					$sumAdditionalPrice += $delivery->additional_price;
					$sumDistance += $delivery->distance;
				}
				return ModelUtil::getPriceFromDistance($cst->id, $sumDistance - $delDist) + $sumAdditionalPrice;
			} else {
				return 0;
			}
		}

		/**
		 * 顧客IDと距離から料金を算出する
		 * @param $customer_id
		 * @param $dist
		 * @param $mode
		 * @return int
		 */
		public static function getPriceFromDistance($customer_id, $dist, $mode = '') {
			$cst = TableRegistry::get('Customers')->find('All')->where(['id' => $customer_id])->first();

			if ($cst && is_numeric($dist)) {
				$pTable = TableRegistry::get('PriceTables')->find()->where(['customer_id' => $cst->id, 'mode' => $mode])->first();
				$nowPrice = 0;
				if ($pTable) {
					$distancePriceTable = TableRegistry::get('DistancePrices')->find()->where(['price_table_id' => $pTable->id])->orderAsc('distance');

					for ($nowDist = 0; $nowDist <= $dist; $nowDist++) {
						$resultPrice = 0;
						foreach ($distancePriceTable as $tItem) {
							if ($nowDist >= $tItem->distance) {
								$resultPrice = $tItem->price;
							}
						}
						$nowPrice += $resultPrice;
					}

					return $nowPrice + $pTable->basic_price;
				} else {
					return 0;
				}
			} else {
				return 0;
			}
		}

		/**
		 * 顧客情報にドライバー用の料金区分が存在するかを判定するためのメソッド
		 * @param $customer_id
		 * @return bool
		 */
		public static function hasDriverPriceTable($customer_id){
			$pTable = TableRegistry::get('PriceTables')->find()->where(['customer_id' => $customer_id, 'mode' => 'driver'])->first();
			if($pTable){
				return true;
			}
			return false;
		}
	}