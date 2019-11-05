<?php

	namespace App\Controller;

	use App\Controller\AppController;
	use Cake\Event\Event;
	use Cake\ORM\TableRegistry;
	use App\Util;
	use Cake\Datasource\ConnectionManager;

	/**
	 * Deliveries Controller
	 *
	 * @property \App\Model\Table\DeliveriesTable $Deliveries
	 *
	 * @method \App\Model\Entity\Delivery[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
	 */
	class DeliveriesController extends AppController {

		public function beforeFilter(Event $event)
		{
			parent::beforeFilter($event);
		}

		public function isAuthorized($user)
		{
			return true;
		}

		/**
		 * Index method
		 *
		 * @return \Cake\Http\Response|void
		 */
		public function index() {
			$this->paginate = [
					'contain' => ['Vouchers']
			];
			$deliveries = $this->paginate($this->Deliveries);

			$this->set(compact('deliveries'));
		}

		/**
		 * View method
		 *
		 * @param string|null $id Delivery id.
		 * @return \Cake\Http\Response|void
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function view($id = null) {
			$delivery = $this->Deliveries->get($id, [
					'contain' => ['Vouchers']
			]);

			$this->set('delivery', $delivery);
		}

		/**
		 * Add method
		 *
		 * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
		 */
		public function add() {
			$delivery = $this->Deliveries->newEntity();
			if ($this->request->is('post')) {
				$delivery = $this->Deliveries->patchEntity($delivery, $this->request->getData());

				$connection = ConnectionManager::get('default');
				// トランザクション開始
				$connection->begin();

				try {
					$deliveryEntity = $this->Deliveries->save($delivery);

					if ($deliveryEntity) {
						$voucher = TableRegistry::get('Vouchers')->find('All')->where(['id' => $delivery->voucher_id])->first();
						$voucher->sum_price1 = Util\ModelUtil::getSumPrice1($voucher->id);
						$voucher->tax = round($voucher->sum_price1 * 0.08);
						$voucher->sum_price2 = $voucher->sum_price1 + $voucher->tax + Util\ModelUtil::getSumAdvancesPaid($voucher->id);

						if(TableRegistry::get('Vouchers')->save($voucher)){
							$connection->commit();
							$this->Flash->success(__('情報を追加しました。'));
							return $this->redirect(['controller'=>'Vouchers', 'action' => 'view', $delivery->voucher_id]);
						}
					}

					$connection->rollback();
					$this->request->session()->write('ValidationError', $deliveryEntity);
					$this->Flash->error(__('情報を追加できませんでした。'));
				} catch(\Exception $e) {
					// ロールバック
					$connection->rollback();
					$this->Flash->error(__('情報を追加できませんでした。'));
				}
			}
			$vouchers = $this->Deliveries->Vouchers->find('list', ['limit' => 200]);
			$this->set(compact('delivery', 'vouchers'));
			return $this->redirect(['controller'=>'Vouchers', 'action' => 'view', $delivery->voucher_id]);
		}


		/**
		 * Edit method
		 *
		 * @param string|null $id Delivery id.
		 * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function edit($id = null) {
			$delivery = $this->Deliveries->get($id, [
					'contain' => []
			]);
			if ($this->request->is(['patch', 'post', 'put'])) {
				$connection = ConnectionManager::get('default');
				// トランザクション開始
				$connection->begin();

				try {
					$delivery = $this->Deliveries->patchEntity($delivery, $this->request->getData());
					$deliveryEntity = $this->Deliveries->save($delivery);
					if ($deliveryEntity) {
						$voucher = TableRegistry::get('Vouchers')->find('All')->where(['id' => $delivery->voucher_id])->first();
						$voucher->sum_price1 = Util\ModelUtil::getSumPrice1($voucher->id);
						$voucher->tax = round($voucher->sum_price1 * 0.08);
						$voucher->sum_price2 = $voucher->sum_price1 + $voucher->tax + Util\ModelUtil::getSumAdvancesPaid($voucher->id);

						if(TableRegistry::get('Vouchers')->save($voucher)){
							$connection->commit();
							$this->Flash->success(__('情報を更新しました。'));
							return $this->redirect(['controller'=>'Deliveries', 'action' => 'view', $delivery->id]);
						}
					}

					$connection->rollback();
					$this->request->session()->write('ValidationError', $deliveryEntity);
					$this->Flash->error(__('情報を更新できませんでした。'));
				} catch(\Exception $e) {
					// ロールバック
					$connection->rollback();
					$this->Flash->error(__('情報を更新できませんでした。'));
				}
			}
			$vouchers = $this->Deliveries->Vouchers->find('list', ['limit' => 200]);
			$this->set(compact('delivery', 'vouchers'));
		}

		/**
		 * Delete method
		 *
		 * @param string|null $id Delivery id.
		 * @return \Cake\Http\Response|null Redirects to index.
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function delete($id = null) {
			$this->request->allowMethod(['post', 'delete']);
			$delivery = $this->Deliveries->get($id);

			$connection = ConnectionManager::get('default');
			// トランザクション開始
			$connection->begin();

			try {
				//まずは納品・積込情報を削除
				if ($this->Deliveries->delete($delivery)) {

					//続いて紐づく経路情報を削除
					$myRouteList = TableRegistry::get('Routes')->find('All')->where(['delivery_id' => $delivery->id]);
					$resultRouteDelete = true;
					foreach ($myRouteList as $myRoute) {
						if(!TableRegistry::get('Routes')->delete($myRoute)){
							$resultRouteDelete = false;
						}
					}

					if($resultRouteDelete){
						//最後に伝票の金額を更新
						$voucher = TableRegistry::get('Vouchers')->find('All')->where(['id' => $delivery->voucher_id])->first();
						$voucher->sum_price1 = Util\ModelUtil::getSumPrice1($voucher->id, $delivery->distance);
						$voucher->tax = round($voucher->sum_price1 * 0.08);
						$voucher->sum_price2 = $voucher->sum_price1 + $voucher->tax + Util\ModelUtil::getSumAdvancesPaid($voucher->id) - $delivery->advances_paid;

						if(TableRegistry::get('Vouchers')->save($voucher)){
							$connection->commit();
							$this->Flash->success(__('納品・積込情報を削除いたしました。'));
							return $this->redirect(['controller'=>'Vouchers', 'action' => 'view', $delivery->voucher_id]);
						}else{
							$connection->rollback();
							$this->Flash->error(__('納品・積込情報を削除できませんでした。伝票の更新に失敗しました。'));
						}
					}else{
						$connection->rollback();
						$this->Flash->error(__('納品・積込情報を削除できませんでした。経路情報の削除に失敗しました。'));
					}
				} else {
					$connection->rollback();
					$this->Flash->error(__('納品・積込情報を削除できませんでした。'));
				}
			} catch(\Exception $e) {
				// ロールバック
				$connection->rollback();
				$this->Flash->error(__('納品・積込情報を削除できませんでした。予期せぬエラー'));
			}
			return $this->redirect(['controller'=>'Vouchers', 'action' => 'view', $delivery->voucher_id]);
		}
	}
