<?php

	namespace App\Controller;

	use App\Controller\AppController;
	use Cake\Event\Event;

	/**
	 * WorkingPrices Controller
	 *
	 * @property \App\Model\Table\WorkingPricesTable $WorkingPrices
	 *
	 * @method \App\Model\Entity\WorkingPrice[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
	 */
	class WorkingPricesController extends AppController {
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
			$workingPrices = $this->paginate($this->WorkingPrices);

			$this->set(compact('workingPrices'));
		}

		/**
		 * View method
		 *
		 * @param string|null $id Working Price id.
		 * @return \Cake\Http\Response|void
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function view($id = null) {
			$workingPrice = $this->WorkingPrices->get($id, [
					'contain' => ['PriceTables']
			]);

			$this->set('workingPrice', $workingPrice);
		}

		/**
		 * Add method
		 *
		 * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
		 */
		public function add() {
			$workingPrice = $this->WorkingPrices->newEntity();
			if ($this->request->is('post')) {
				$workingPrice = $this->WorkingPrices->patchEntity($workingPrice, $this->request->getData());
				if ($this->WorkingPrices->save($workingPrice)) {
					$this->Flash->success(__('The working price has been saved.'));

					return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('The working price could not be saved. Please, try again.'));
			}
			$priceTables = $this->WorkingPrices->PriceTables->find('list', ['limit' => 200]);
			$this->set(compact('workingPrice', 'priceTables'));
		}

		/**
		 * Edit method
		 *
		 * @param string|null $id Working Price id.
		 * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function edit($id = null) {
			$workingPrice = $this->WorkingPrices->get($id, [
					'contain' => []
			]);
			if ($this->request->is(['patch', 'post', 'put'])) {
				$workingPrice = $this->WorkingPrices->patchEntity($workingPrice, $this->request->getData());
				if ($this->WorkingPrices->save($workingPrice)) {
					$this->Flash->success(__('The working price has been saved.'));

					return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('The working price could not be saved. Please, try again.'));
			}
			$priceTables = $this->WorkingPrices->PriceTables->find('list', ['limit' => 200]);
			$this->set(compact('workingPrice', 'priceTables'));
		}

		/**
		 * Delete method
		 *
		 * @param string|null $id Working Price id.
		 * @return \Cake\Http\Response|null Redirects to index.
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function delete($id = null) {
			$this->request->allowMethod(['post', 'delete']);
			$workingPrice = $this->WorkingPrices->get($id);
			if ($this->WorkingPrices->delete($workingPrice)) {
				$this->Flash->success(__('The working price has been deleted.'));
			} else {
				$this->Flash->error(__('The working price could not be deleted. Please, try again.'));
			}

			return $this->redirect(['action' => 'index']);
		}
	}
