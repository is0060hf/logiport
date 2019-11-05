<?php

	namespace App\Controller;

	use App\Controller\AppController;
	use Cake\Event\Event;
	use Cake\ORM\TableRegistry;

	/**
	 * Customers Controller
	 *
	 * @property \App\Model\Table\CustomersTable $Customers
	 *
	 * @method \App\Model\Entity\Customer[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
	 */
	class CustomersController extends AppController {
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
			$customers = $this->paginate($this->Customers->find('all')->orderDesc('created'));

			$this->set(compact('customers'));
		}

		/**
		 * View method
		 *
		 * @param string|null $id Customer id.
		 * @return \Cake\Http\Response|void
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function view($id = null) {
			$customer = $this->Customers->get($id, [
					'contain' => ['PriceTables']
			]);
			$regular_services = TableRegistry::get('RegularServices')->find('All')->where(['customer_id' => $customer->id]);
			$this->set(compact('customer', 'regular_services'));
		}

		/**
		 * Add method
		 *
		 * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
		 */
		public function add() {
			$customer = $this->Customers->newEntity();
			if ($this->request->is('post')) {
				$customer = $this->Customers->patchEntity($customer, $this->request->getData());
				if ($this->Customers->save($customer)) {
					$this->Flash->success(__('顧客情報を正常に登録しました。'));

					return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('顧客情報の登録に失敗しました。もう一度やり直してください。'));
			}
			$this->set(compact('customer'));
		}

		/**
		 * Edit method
		 *
		 * @param string|null $id Customer id.
		 * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function edit($id = null) {
			$customer = $this->Customers->get($id, [
					'contain' => []
			]);
			if ($this->request->is(['patch', 'post', 'put'])) {
				$customer = $this->Customers->patchEntity($customer, $this->request->getData());
				if ($this->Customers->save($customer)) {
					$this->Flash->success(__('顧客情報を正常に登録しました。'));

					return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('顧客情報の登録に失敗しました。もう一度やり直してください。'));
			}
			$this->set(compact('customer'));
		}

		/**
		 * Delete method
		 *
		 * @param string|null $id Customer id.
		 * @return \Cake\Http\Response|null Redirects to index.
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function delete($id = null) {
			$this->request->allowMethod(['post', 'delete']);
			$customer = $this->Customers->get($id);
			if ($this->Customers->delete($customer)) {
				$this->Flash->success(__('顧客情報を削除しました。'));
			} else {
				$this->Flash->error(__('顧客情報の削除に失敗しました。もう一度やり直してください。'));
			}

			return $this->redirect(['action' => 'index']);
		}
	}
