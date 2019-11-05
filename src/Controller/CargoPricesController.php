<?php

	namespace App\Controller;

	use App\Controller\AppController;
	use Cake\Event\Event;

	/**
	 * CargoPrices Controller
	 *
	 * @property \App\Model\Table\CargoPricesTable $CargoPrices
	 *
	 * @method \App\Model\Entity\CargoPrice[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
	 */
	class CargoPricesController extends AppController {
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
			$cargoPrices = $this->paginate($this->CargoPrices);

			$this->set(compact('cargoPrices'));
		}

		/**
		 * View method
		 *
		 * @param string|null $id Cargo Price id.
		 * @return \Cake\Http\Response|void
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function view($id = null) {
			$cargoPrice = $this->CargoPrices->get($id, [
					'contain' => ['PriceTables']
			]);

			$this->set('cargoPrice', $cargoPrice);
		}

		/**
		 * Add method
		 *
		 * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
		 */
		public function add() {
			$cargoPrice = $this->CargoPrices->newEntity();
			if ($this->request->is('post')) {
				$cargoPrice = $this->CargoPrices->patchEntity($cargoPrice, $this->request->getData());
				if ($this->CargoPrices->save($cargoPrice)) {
					$this->Flash->success(__('The cargo price has been saved.'));

					return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('The cargo price could not be saved. Please, try again.'));
			}
			$priceTables = $this->CargoPrices->PriceTables->find('list', ['limit' => 200]);
			$this->set(compact('cargoPrice', 'priceTables'));
		}

		/**
		 * Edit method
		 *
		 * @param string|null $id Cargo Price id.
		 * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function edit($id = null) {
			$cargoPrice = $this->CargoPrices->get($id, [
					'contain' => []
			]);
			if ($this->request->is(['patch', 'post', 'put'])) {
				$cargoPrice = $this->CargoPrices->patchEntity($cargoPrice, $this->request->getData());
				if ($this->CargoPrices->save($cargoPrice)) {
					$this->Flash->success(__('The cargo price has been saved.'));

					return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('The cargo price could not be saved. Please, try again.'));
			}
			$priceTables = $this->CargoPrices->PriceTables->find('list', ['limit' => 200]);
			$this->set(compact('cargoPrice', 'priceTables'));
		}

		/**
		 * Delete method
		 *
		 * @param string|null $id Cargo Price id.
		 * @return \Cake\Http\Response|null Redirects to index.
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function delete($id = null) {
			$this->request->allowMethod(['post', 'delete']);
			$cargoPrice = $this->CargoPrices->get($id);
			if ($this->CargoPrices->delete($cargoPrice)) {
				$this->Flash->success(__('The cargo price has been deleted.'));
			} else {
				$this->Flash->error(__('The cargo price could not be deleted. Please, try again.'));
			}

			return $this->redirect(['action' => 'index']);
		}
	}
