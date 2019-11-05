<?php

	namespace App\Controller;

	use App\Controller\AppController;
	use Cake\Event\Event;
	use Cake\ORM\TableRegistry;

	/**
	 * DistancePrices Controller
	 *
	 * @property \App\Model\Table\DistancePricesTable $DistancePrices
	 *
	 * @method \App\Model\Entity\DistancePrice[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
	 */
	class DistancePricesController extends AppController {
		public function beforeFilter(Event $event) {
			parent::beforeFilter($event);
		}

		public function isAuthorized($user) {
			if (isset($user) && $user['user_role'] == 'システム管理者') {
				return true;
			}
			return parent::isAuthorized($user);
		}

		/**
		 * Index method
		 *
		 * @return \Cake\Http\Response|void
		 */
		public function index() {
			$this->paginate = [
					'contain' => ['PriceTables']
			];
			$distancePrices = $this->paginate($this->DistancePrices);

			$this->set(compact('distancePrices'));
		}

		/**
		 * View method
		 *
		 * @param string|null $id Distance Price id.
		 * @return \Cake\Http\Response|void
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function view($id = null) {
			$distancePrice = $this->DistancePrices->get($id, [
					'contain' => ['PriceTables']
			]);

			$this->set('distancePrice', $distancePrice);
		}

		/**
		 * Add method
		 *
		 * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
		 */
		public function add() {
			$distancePrice = $this->DistancePrices->newEntity();
			if ($this->request->is('post')) {
				$distancePrice = $this->DistancePrices->patchEntity($distancePrice, $this->request->getData());
				if ($this->DistancePrices->save($distancePrice)) {
					$this->Flash->success(__('料金区分を登録しました。'));
					$pTable = TableRegistry::get('PriceTables')->find()->where(['id' => $distancePrice->price_table_id])->first();
					return $this->redirect(['controller' => 'Customers', 'action' => 'view',$pTable->customer_id]);
				}
				$this->Flash->error(__('料金区分登録中にエラーが発生しました。もう一度やり直してください。'));
			}
			$priceTables = $this->DistancePrices->PriceTables->find('list', ['limit' => 200]);
			$this->set(compact('distancePrice', 'priceTables'));
		}

		/**
		 * 顧客用料金表の距離当りの料金データを基に、ドライバー用料金表の距離当たりの料金データを生成する。
		 * @param $customer_id
		 * @return \Cake\Http\Response|null
		 */
		public function copyFromOrdinalScale($customer_id) {
			$distancePrice = $this->DistancePrices->newEntity();

			//対顧客用の料金表を取得する
			$priceTable = TableRegistry::get('PriceTables')->find()->where(['customer_id' => $customer_id, 'mode' => ''])->first();

			//対顧客用の料金表が存在しない場合にはエラー
			if(!$priceTable){
				$this->Flash->error(__('対顧客用の料金表が登録されていません。先に対顧客用の料金表を登録してください。'));
				return $this->redirect(['controller' => 'Customers', 'action' => 'view', $customer_id]);
			}

			//対ドライバーの料金表を取得する
			$driverPriceTable = TableRegistry::get('PriceTables')->find()->where(['customer_id' => $customer_id, 'mode' => 'driver'])->first();

			//対ドライバーの料金表が存在しない場合にはエラー
			if(!$driverPriceTable){
				$this->Flash->error(__('対ドライバー用の料金表が登録されていません。先に対ドライバー用の料金表を登録してください。'));
				return $this->redirect(['controller' => 'Customers', 'action' => 'view', $customer_id]);
			}

			if ($this->request->is('post')) {

				//必須項目が万一渡っていなかったらやり直し
				$magnification = $this->request->getData('magnification');
				if(!$magnification || $magnification == '' ){
					$this->Flash->error(__('倍率を指定してください。'));
					return $this->redirect(['action' => 'copyFromOrdinalScale', $customer_id]);
				}

				//現状ドライバー用料金表に登録されている距離当たりの料金データをすべて削除する
				PriceTablesController::deleteAllDistancePrices($driverPriceTable->id);

				//対顧客用の料金表に紐づく距離当たりの料金データを取得する
				$distancePrices = TableRegistry::get('DistancePrices')->find('All')->where(['price_table_id' => $priceTable->id]);

				foreach ($distancePrices as $distancePrice){
					$driverDistancePrice = TableRegistry::get('DistancePrices')->newEntity();
					$driverDistancePrice->price_table_id = $driverPriceTable->id;
					$driverDistancePrice->distance = $distancePrice->distance;
					$driverDistancePrice->price = round($distancePrice->price * intval($magnification) / 100.0);
					TableRegistry::get('DistancePrices')->save($driverDistancePrice);
				}

				$distancePrice = $this->DistancePrices->patchEntity($distancePrice, $this->request->getData());
				if ($this->DistancePrices->save($distancePrice)) {
					$this->Flash->success(__('料金区分をコピーしました。'));
					return $this->redirect(['controller' => 'Customers', 'action' => 'view',$customer_id]);
				}
				$this->Flash->error(__('料金区分登録中にエラーが発生しました。もう一度やり直してください。'));
			}
			$priceTables = $this->DistancePrices->PriceTables->find('list', ['limit' => 200]);
			$this->set(compact('distancePrice', 'priceTables'));
			$this->set(compact('customer_id'));
		}

		/**
		 * Edit method
		 *
		 * @param string|null $id Distance Price id.
		 * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function edit($id = null) {
			$distancePrice = $this->DistancePrices->get($id, [
					'contain' => []
			]);
			if ($this->request->is(['patch', 'post', 'put'])) {
				$distancePrice = $this->DistancePrices->patchEntity($distancePrice, $this->request->getData());
				if ($this->DistancePrices->save($distancePrice)) {
					$this->Flash->success(__('料金区分を登録しました。'));
					$pTable = TableRegistry::get('PriceTables')->find()->where(['id' => $distancePrice->price_table_id])->first();
					return $this->redirect(['controller' => 'Customers', 'action' => 'view',$pTable->customer_id]);
				}
				$this->Flash->error(__('料金区分登録中にエラーが発生しました。もう一度やり直してください。'));
			}
			$priceTables = $this->DistancePrices->PriceTables->find('list', ['limit' => 200]);
			$this->set(compact('distancePrice', 'priceTables'));
		}

		/**
		 * Delete method
		 *
		 * @param string|null $id Distance Price id.
		 * @return \Cake\Http\Response|null Redirects to index.
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function delete($id = null) {
			$this->request->allowMethod(['post', 'delete']);
			$distancePrice = $this->DistancePrices->get($id);
			if ($this->DistancePrices->delete($distancePrice)) {
				$this->Flash->success(__('料金区分を削除しました。'));
			} else {
				$this->Flash->error(__('料金区分削除中にエラーが発生しました。もう一度やり直してください。'));
			}
			$pTable = TableRegistry::get('PriceTables')->find()->where(['id' => $distancePrice->price_table_id])->first();
			return $this->redirect(['controller' => 'Customers', 'action' => 'view',$pTable->customer_id]);
		}
	}
