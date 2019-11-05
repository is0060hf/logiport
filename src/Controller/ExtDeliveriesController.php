<?php

	namespace App\Controller;

	use App\Controller\AppController;
	use Cake\Event\Event;

	/**
	 * Deliveries Controller
	 *
	 * @property \App\Model\Table\DeliveriesTable $Deliveries
	 *
	 * @method \App\Model\Entity\Delivery[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
	 */
	class ExtDeliveriesController extends DeliveriesController {

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
				if ($this->Deliveries->save($delivery)) {
					$this->Flash->success(__('情報を追加しました。'));
					return $this->redirect(['controller'=>'Vouchers', 'action'=>'view', $delivery->vouchers_id]);
				}else{
					$this->Flash->error('情報を追加できませんでした。');
					$this->set(compact('delivery', 'vouchers'));
					return $this->redirect(['controller'=>'Vouchers', 'action'=>'view', $delivery->vouchers_id]);
				}
			}
			$vouchers = $this->Deliveries->Vouchers->find('list', ['limit' => 200]);
			$this->set(compact('delivery', 'vouchers'));
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
				$delivery = $this->Deliveries->patchEntity($delivery, $this->request->getData());
				if ($this->Deliveries->save($delivery)) {
					$this->Flash->success(__('The delivery has been saved.'));

					return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('The delivery could not be saved. Please, try again.'));
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
			if ($this->Deliveries->delete($delivery)) {
				$this->Flash->success(__('The delivery has been deleted.'));
			} else {
				$this->Flash->error(__('The delivery could not be deleted. Please, try again.'));
			}

			return $this->redirect(['action' => 'index']);
		}
	}
