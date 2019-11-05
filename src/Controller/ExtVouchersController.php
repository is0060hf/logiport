<?php

	namespace App\Controller;

	use App\Controller\AppController;
	use Cake\Event\Event;

	/**
	 * Vouchers Controller
	 *
	 * @property \App\Model\Table\VouchersTable $Vouchers
	 *
	 * @method \App\Model\Entity\Voucher[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
	 */
	class ExtVouchersController extends VouchersController {

		private $user_info;

		public function beforeFilter(Event $event)
		{
			parent::beforeFilter($event);
		}

		public function isAuthorized($user)
		{
			$this->user_info = $user;

			// 登録ユーザー全員が記事を追加できます
			// 3.4.0 より前は $this->request->param('action') が使われました。
			if (in_array($this->request->getParam('action'), ['index', 'add'])) {
				return true;
			}

			if (isset($user) && $user['user_role'] == 'システム管理者') {
				return true;
			}

			// 記事の所有者は編集して削除することができます
			if (in_array($this->request->getParam('action'), ['delete', 'view', 'edit'])) {
				$articleId = (int)$this->request->getParam('pass.0');
				$voucher = $this->Vouchers->get($articleId);
				if(isset($voucher) && isset($user) && $user['username'] == $voucher['deliveryman_name']){
					return true;
				}
			}

			return parent::isAuthorized($user);
		}

		/**
		 * Index method
		 *
		 * @return \Cake\Http\Response|void
		 */
		public function index() {
			$this->viewBuilder()->setLayout('datatables_layout');

			if(isset($this->user_info) && $this->user_info['user_role'] != 'システム管理者'){
				$vouchers = $this->paginate($this->Vouchers->find('All')->where(['deliveryman_name' => $this->user_info['username'] ]));
			}else{
				$vouchers = $this->paginate($this->Vouchers);
			}

			$this->set(compact('vouchers'));
		}

		/**
		 * View method
		 *
		 * @param string|null $id Voucher id.
		 * @return \Cake\Http\Response|void
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function view($id = null) {
			$this->viewBuilder()->setLayout('my_layout');

			$voucher = $this->Vouchers->get($id, [
					'contain' => ['Deliveries','Routes']
			]);

			$this->set('voucher', $voucher);
		}

		/**
		 * Add method
		 *
		 * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
		 */
		public function add() {
			$this->viewBuilder()->setLayout('editor_layout');

			$voucher = $this->Vouchers->newEntity();
			if ($this->request->is('post')) {
				$voucher = $this->Vouchers->patchEntity($voucher, $this->request->getData());
				if ($this->Vouchers->save($voucher)) {
					$this->Flash->success(__('The voucher has been saved.'));

					return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('The voucher could not be saved. Please, try again.'));
			}
			$this->set(compact('voucher'));
		}

		/**
		 * Edit method
		 *
		 * @param string|null $id Voucher id.
		 * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function edit($id = null) {
			$this->viewBuilder()->setLayout('editor_layout');

			$voucher = $this->Vouchers->get($id, [
					'contain' => []
			]);
			if ($this->request->is(['patch', 'post', 'put'])) {
				$voucher = $this->Vouchers->patchEntity($voucher, $this->request->getData());
				if ($this->Vouchers->save($voucher)) {
					$this->Flash->success(__('The voucher has been saved.'));

					return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('The voucher could not be saved. Please, try again.'));
			}
			$this->set(compact('voucher'));
		}

		/**
		 * Delete method
		 *
		 * @param string|null $id Voucher id.
		 * @return \Cake\Http\Response|null Redirects to index.
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function delete($id = null) {
			$this->request->allowMethod(['post', 'delete']);
			$voucher = $this->Vouchers->get($id);
			if ($this->Vouchers->delete($voucher)) {
				$this->Flash->success(__('The voucher has been deleted.'));
			} else {
				$this->Flash->error(__('The voucher could not be deleted. Please, try again.'));
			}

			return $this->redirect(['action' => 'index']);
		}
	}
