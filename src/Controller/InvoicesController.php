<?php

	namespace App\Controller;

	use App\Controller\AppController;
	use Cake\Event\Event;

	/**
	 * Invoices Controller
	 *
	 * @property \App\Model\Table\InvoicesTable $Invoices
	 *
	 * @method \App\Model\Entity\Invoice[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
	 */
	class InvoicesController extends AppController {
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
					'contain' => ['Banks']
			];
			$invoices = $this->paginate($this->Invoices);

			$this->set(compact('invoices'));
		}

		/**
		 * View method
		 *
		 * @param string|null $id Invoice id.
		 * @return \Cake\Http\Response|void
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function view($id = null) {
			$invoice = $this->Invoices->get($id, [
					'contain' => ['Banks', 'VoucherInvoiceLinks']
			]);

			$this->set('invoice', $invoice);
		}

		/**
		 * Add method
		 *
		 * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
		 */
		public function add() {
			$invoice = $this->Invoices->newEntity();
			if ($this->request->is('post')) {
				$invoice = $this->Invoices->patchEntity($invoice, $this->request->getData());
				if ($this->Invoices->save($invoice)) {
					$this->Flash->success(__('The invoice has been saved.'));

					return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('The invoice could not be saved. Please, try again.'));
			}
			$banks = $this->Invoices->Banks->find('list', ['limit' => 200]);
			$this->set(compact('invoice', 'banks'));
		}

		/**
		 * Edit method
		 *
		 * @param string|null $id Invoice id.
		 * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function edit($id = null) {
			$invoice = $this->Invoices->get($id, [
					'contain' => []
			]);
			if ($this->request->is(['patch', 'post', 'put'])) {
				$invoice = $this->Invoices->patchEntity($invoice, $this->request->getData());
				if ($this->Invoices->save($invoice)) {
					$this->Flash->success(__('The invoice has been saved.'));

					return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('The invoice could not be saved. Please, try again.'));
			}
			$banks = $this->Invoices->Banks->find('list', ['limit' => 200]);
			$this->set(compact('invoice', 'banks'));
		}

		/**
		 * Delete method
		 *
		 * @param string|null $id Invoice id.
		 * @return \Cake\Http\Response|null Redirects to index.
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function delete($id = null) {
			$this->request->allowMethod(['post', 'delete']);
			$invoice = $this->Invoices->get($id);
			if ($this->Invoices->delete($invoice)) {
				$this->Flash->success(__('The invoice has been deleted.'));
			} else {
				$this->Flash->error(__('The invoice could not be deleted. Please, try again.'));
			}

			return $this->redirect(['action' => 'index']);
		}
	}
