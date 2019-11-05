<?php

	namespace App\Controller;

	use App\Controller\AppController;
	use Cake\Event\Event;
	use Cake\ORM\TableRegistry;
	use Cake\Datasource\ConnectionManager;

	/**
	 * PriceTables Controller
	 *
	 * @property \App\Model\Table\PriceTablesTable $PriceTables
	 *
	 * @method \App\Model\Entity\PriceTable[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
	 */
	class PriceTablesController extends AppController {
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
					'contain' => ['Customers']
			];
			$priceTables = $this->paginate($this->PriceTables);

			$this->set(compact('priceTables'));
		}

		/**
		 * View method
		 *
		 * @param string|null $id Price Table id.
		 * @return \Cake\Http\Response|void
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function view($id = null) {
			$priceTable = $this->PriceTables->get($id, [
					'contain' => ['Customers', 'CargoPrices', 'CountPrices', 'DistancePrices', 'WaitingPrices', 'WorkingPrices']
			]);

			$this->set('priceTable', $priceTable);
		}

		/**
		 * Add method
		 *
		 * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
		 */
		public function add() {
			$priceTable = $this->PriceTables->newEntity();
			if ($this->request->is('post')) {
				$priceTable = $this->PriceTables->patchEntity($priceTable, $this->request->getData());
				if ($this->PriceTables->save($priceTable)) {
					$this->Flash->success(__('料金表を登録しました。'));
					return $this->redirect(['controller' => 'Customers', 'action' => 'view', $priceTable->customer_id]);
				}
				$this->Flash->error(__('料金表の登録に失敗しました。もう一度やり直してください。'));
			}
			$customers = $this->PriceTables->Customers->find('list', ['limit' => 200]);
			$this->set(compact('priceTable', 'customers'));
		}

		/**
		 * Add method
		 *
		 * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
		 */
		public function addDriverPriceTable() {
			$priceTable = $this->PriceTables->newEntity();
			if ($this->request->is('post')) {
				$priceTable = $this->PriceTables->patchEntity($priceTable, $this->request->getData());
				if ($this->PriceTables->save($priceTable)) {
					$this->Flash->success(__('料金表を登録しました。'));
					return $this->redirect(['controller' => 'Customers', 'action' => 'view', $priceTable->customer_id]);
				}
				$this->Flash->error(__('料金表の登録に失敗しました。もう一度やり直してください。'));
			}
			$customers = $this->PriceTables->Customers->find('list', ['limit' => 200]);
			$this->set(compact('priceTable', 'customers'));
		}

		/**
		 * Edit method
		 *
		 * @param string|null $id Price Table id.
		 * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function edit($id = null) {
			$priceTable = $this->PriceTables->get($id, [
					'contain' => []
			]);
			if ($this->request->is(['patch', 'post', 'put'])) {
				$priceTable = $this->PriceTables->patchEntity($priceTable, $this->request->getData());
				if ($this->PriceTables->save($priceTable)) {
					$this->Flash->success(__('料金表を登録しました。'));
					return $this->redirect(['controller' => 'Customers', 'action' => 'view', $priceTable->customer_id]);
				}
				$this->Flash->error(__('料金表の登録に失敗しました。もう一度やり直してください。'));
			}
			$customers = $this->PriceTables->Customers->find('list', ['limit' => 200]);
			$this->set(compact('priceTable', 'customers'));
		}

		/**
		 * Delete method
		 *
		 * @param string|null $id Price Table id.
		 * @return \Cake\Http\Response|null Redirects to index.
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function delete($id = null) {
			$this->request->allowMethod(['post', 'delete']);
			$priceTable = $this->PriceTables->get($id);
			if ($this->PriceTables->delete($priceTable)) {
				$this->Flash->success(__('The price table has been deleted.'));
			} else {
				$this->Flash->error(__('The price table could not be deleted. Please, try again.'));
			}

			return $this->redirect(['action' => 'index']);
		}

		/**
		 * 料金表に紐づいた距離当たりの料金データを全て削除する
		 *
		 * @param $id
		 * @return bool
		 */
		public static function deleteAllDistancePrices($price_table_id){
			$priceTable = TableRegistry::get('PriceTables')->get($price_table_id);
			$myDistancePrices = TableRegistry::get('DistancePrices')->find('All')->where(['price_table_id' => $priceTable->id]);
			$deleteResult = true;

			$connection = ConnectionManager::get('default');
			// トランザクション開始
			$connection->begin();
			try {

				foreach ($myDistancePrices as $myDistancePrice){
					if(!TableRegistry::get('DistancePrices')->delete($myDistancePrice)){
						$deleteResult = false;
					}
				}

				if($deleteResult){
					$connection->commit();
				}else{
					$connection->rollback();
				}

			} catch(\Exception $e) {
				$connection->rollback();
			}

			return $deleteResult;
		}
	}
