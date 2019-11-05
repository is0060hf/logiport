<?php

	namespace App\Controller;

	use App\Controller\AppController;
	use Cake\Event\Event;

	/**
	 * VoucherInvoiceLinks Controller
	 *
	 * @property \App\Model\Table\VoucherInvoiceLinksTable $VoucherInvoiceLinks
	 *
	 * @method \App\Model\Entity\VoucherInvoiceLink[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
	 */
	class VoucherInvoiceLinksController extends AppController {
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
					'contain' => ['Vouchers', 'Invoices']
			];
			$voucherInvoiceLinks = $this->paginate($this->VoucherInvoiceLinks);

			$this->set(compact('voucherInvoiceLinks'));
		}

		/**
		 * View method
		 *
		 * @param string|null $id Voucher Invoice Link id.
		 * @return \Cake\Http\Response|void
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function view($id = null) {
			$voucherInvoiceLink = $this->VoucherInvoiceLinks->get($id, [
					'contain' => ['Vouchers', 'Invoices']
			]);

			$this->set('voucherInvoiceLink', $voucherInvoiceLink);
		}

		/**
		 * Add method
		 *
		 * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
		 */
		public function add() {
			$voucherInvoiceLink = $this->VoucherInvoiceLinks->newEntity();
			if ($this->request->is('post')) {
				$voucherInvoiceLink = $this->VoucherInvoiceLinks->patchEntity($voucherInvoiceLink, $this->request->getData());
				if ($this->VoucherInvoiceLinks->save($voucherInvoiceLink)) {
					$this->Flash->success(__('The voucher invoice link has been saved.'));

					return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('The voucher invoice link could not be saved. Please, try again.'));
			}
			$vouchers = $this->VoucherInvoiceLinks->Vouchers->find('list', ['limit' => 200]);
			$invoices = $this->VoucherInvoiceLinks->Invoices->find('list', ['limit' => 200]);
			$this->set(compact('voucherInvoiceLink', 'vouchers', 'invoices'));
		}

		/**
		 * Edit method
		 *
		 * @param string|null $id Voucher Invoice Link id.
		 * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function edit($id = null) {
			$voucherInvoiceLink = $this->VoucherInvoiceLinks->get($id, [
					'contain' => []
			]);
			if ($this->request->is(['patch', 'post', 'put'])) {
				$voucherInvoiceLink = $this->VoucherInvoiceLinks->patchEntity($voucherInvoiceLink, $this->request->getData());
				if ($this->VoucherInvoiceLinks->save($voucherInvoiceLink)) {
					$this->Flash->success(__('The voucher invoice link has been saved.'));

					return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('The voucher invoice link could not be saved. Please, try again.'));
			}
			$vouchers = $this->VoucherInvoiceLinks->Vouchers->find('list', ['limit' => 200]);
			$invoices = $this->VoucherInvoiceLinks->Invoices->find('list', ['limit' => 200]);
			$this->set(compact('voucherInvoiceLink', 'vouchers', 'invoices'));
		}

		/**
		 * Delete method
		 *
		 * @param string|null $id Voucher Invoice Link id.
		 * @return \Cake\Http\Response|null Redirects to index.
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function delete($id = null) {
			$this->request->allowMethod(['post', 'delete']);
			$voucherInvoiceLink = $this->VoucherInvoiceLinks->get($id);
			if ($this->VoucherInvoiceLinks->delete($voucherInvoiceLink)) {
				$this->Flash->success(__('The voucher invoice link has been deleted.'));
			} else {
				$this->Flash->error(__('The voucher invoice link could not be deleted. Please, try again.'));
			}

			return $this->redirect(['action' => 'index']);
		}
	}
