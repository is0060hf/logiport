<?php

	namespace App\Controller;

	use App\Controller\AppController;
	use Cake\Event\Event;

	/**
	 * WaitingPrices Controller
	 *
	 * @property \App\Model\Table\WaitingPricesTable $WaitingPrices
	 *
	 * @method \App\Model\Entity\WaitingPrice[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
	 */
	class WaitingPricesController extends AppController {
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
			$waitingPrices = $this->paginate($this->WaitingPrices);

			$this->set(compact('waitingPrices'));
		}

		/**
		 * View method
		 *
		 * @param string|null $id Waiting Price id.
		 * @return \Cake\Http\Response|void
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function view($id = null) {
			$waitingPrice = $this->WaitingPrices->get($id, [
					'contain' => ['PriceTables']
			]);

			$this->set('waitingPrice', $waitingPrice);
		}

		/**
		 * Add method
		 *
		 * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
		 */
		public function add() {
			$waitingPrice = $this->WaitingPrices->newEntity();
			if ($this->request->is('post')) {
				$waitingPrice = $this->WaitingPrices->patchEntity($waitingPrice, $this->request->getData());
				if ($this->WaitingPrices->save($waitingPrice)) {
					$this->Flash->success(__('The waiting price has been saved.'));

					return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('The waiting price could not be saved. Please, try again.'));
			}
			$priceTables = $this->WaitingPrices->PriceTables->find('list', ['limit' => 200]);
			$this->set(compact('waitingPrice', 'priceTables'));
		}

		/**
		 * Edit method
		 *
		 * @param string|null $id Waiting Price id.
		 * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function edit($id = null) {
			$waitingPrice = $this->WaitingPrices->get($id, [
					'contain' => []
			]);
			if ($this->request->is(['patch', 'post', 'put'])) {
				$waitingPrice = $this->WaitingPrices->patchEntity($waitingPrice, $this->request->getData());
				if ($this->WaitingPrices->save($waitingPrice)) {
					$this->Flash->success(__('The waiting price has been saved.'));

					return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('The waiting price could not be saved. Please, try again.'));
			}
			$priceTables = $this->WaitingPrices->PriceTables->find('list', ['limit' => 200]);
			$this->set(compact('waitingPrice', 'priceTables'));
		}

		/**
		 * Delete method
		 *
		 * @param string|null $id Waiting Price id.
		 * @return \Cake\Http\Response|null Redirects to index.
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function delete($id = null) {
			$this->request->allowMethod(['post', 'delete']);
			$waitingPrice = $this->WaitingPrices->get($id);
			if ($this->WaitingPrices->delete($waitingPrice)) {
				$this->Flash->success(__('The waiting price has been deleted.'));
			} else {
				$this->Flash->error(__('The waiting price could not be deleted. Please, try again.'));
			}

			return $this->redirect(['action' => 'index']);
		}
	}
