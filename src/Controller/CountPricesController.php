<?php

	namespace App\Controller;

	use App\Controller\AppController;
	use Cake\Event\Event;

	/**
	 * CountPrices Controller
	 *
	 * @property \App\Model\Table\CountPricesTable $CountPrices
	 *
	 * @method \App\Model\Entity\CountPrice[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
	 */
	class CountPricesController extends AppController {
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
			$countPrices = $this->paginate($this->CountPrices);

			$this->set(compact('countPrices'));
		}

		/**
		 * View method
		 *
		 * @param string|null $id Count Price id.
		 * @return \Cake\Http\Response|void
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function view($id = null) {
			$countPrice = $this->CountPrices->get($id, [
					'contain' => ['PriceTables']
			]);

			$this->set('countPrice', $countPrice);
		}

		/**
		 * Add method
		 *
		 * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
		 */
		public function add() {
			$countPrice = $this->CountPrices->newEntity();
			if ($this->request->is('post')) {
				$countPrice = $this->CountPrices->patchEntity($countPrice, $this->request->getData());
				if ($this->CountPrices->save($countPrice)) {
					$this->Flash->success(__('The count price has been saved.'));

					return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('The count price could not be saved. Please, try again.'));
			}
			$priceTables = $this->CountPrices->PriceTables->find('list', ['limit' => 200]);
			$this->set(compact('countPrice', 'priceTables'));
		}

		/**
		 * Edit method
		 *
		 * @param string|null $id Count Price id.
		 * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function edit($id = null) {
			$countPrice = $this->CountPrices->get($id, [
					'contain' => []
			]);
			if ($this->request->is(['patch', 'post', 'put'])) {
				$countPrice = $this->CountPrices->patchEntity($countPrice, $this->request->getData());
				if ($this->CountPrices->save($countPrice)) {
					$this->Flash->success(__('The count price has been saved.'));

					return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('The count price could not be saved. Please, try again.'));
			}
			$priceTables = $this->CountPrices->PriceTables->find('list', ['limit' => 200]);
			$this->set(compact('countPrice', 'priceTables'));
		}

		/**
		 * Delete method
		 *
		 * @param string|null $id Count Price id.
		 * @return \Cake\Http\Response|null Redirects to index.
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function delete($id = null) {
			$this->request->allowMethod(['post', 'delete']);
			$countPrice = $this->CountPrices->get($id);
			if ($this->CountPrices->delete($countPrice)) {
				$this->Flash->success(__('The count price has been deleted.'));
			} else {
				$this->Flash->error(__('The count price could not be deleted. Please, try again.'));
			}

			return $this->redirect(['action' => 'index']);
		}
	}
