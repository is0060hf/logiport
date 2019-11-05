<?php

	namespace App\Controller;

	use App\Controller\AppController;
	use Cake\Event\Event;

	/**
	 * Users Controller
	 *
	 * @property \App\Model\Table\UsersTable $Users
	 *
	 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
	 */
	class ExtUsersController extends UsersController {
		/**
		 * ログアウトのみログインしていなくても許可
		 * @param Event $event
		 * @return \Cake\Http\Response|null|void
		 */
		public function beforeFilter(Event $event) {
			parent::beforeFilter($event);
			$this->Auth->allow(['logout', 'forbidden', 'add']);
		}

		public function isAuthorized($user) {
			//ログアウトと権限エラー時はスルー
			if (in_array($this->request->getParam('action'), ['forbidden', 'logout', 'add'])) {
				return true;
			}

			// システム管理者以外はドライバー情報に関して全アクション拒否
			if (isset($user) && $user['user_role'] == 'システム管理者') {
				return true;
			}

			return parent::isAuthorized($user);
		}

		/**
		 * ForbiddenExceptionが発生した際の遷移先
		 */
		public function forbidden() {
			$this->viewBuilder()->setLayout('my_error_layout');
		}

		public function login() {
			$this->viewBuilder()->setLayout('my_login_layout');
/*			if ($this->request->is('post')) {
				$login_id = $this->request->getData('login_id');
				$user = $this->Users->findByLoginID($login_id)->first();
				if ($user) {
					$this->Auth->setUser($user);
					return $this->redirect($this->Auth->redirectUrl());
				} else {
					$this->Flash->error(__('ログイン情報に誤りがあります。'));
				}
			}
			$this->set(compact('user'));*/

			if ($this->request->is('post')) {
				$user = $this->Auth->identify();
				if ($user) {
					$this->Auth->setUser($user);
					return $this->redirect($this->Auth->redirectUrl());
				}
				$this->Flash->error(__('ログイン情報に誤りがあります。'));
			}
		}

		public function logout() {
			return $this->redirect($this->Auth->logout());
		}


		/**
		 * Index method
		 *
		 * @return \Cake\Http\Response|void
		 */
		public function index() {
			$this->viewBuilder()->setLayout('datatables_layout');
			$users = $this->paginate($this->Users);

			$this->set(compact('users'));
		}

		/**
		 * View method
		 *
		 * @param string|null $id User id.
		 * @return \Cake\Http\Response|void
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function view($id = null) {
			$this->viewBuilder()->setLayout('my_layout');
			$user = $this->Users->get($id, [
					'contain' => []
			]);

			$this->set('user', $user);
		}

		/**
		 * Add method
		 *
		 * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
		 */
		public function add() {
			$this->viewBuilder()->setLayout('editor_layout');
			$user = $this->Users->newEntity();
			if ($this->request->is('post')) {
				$user = $this->Users->patchEntity($user, $this->request->getData());
				if ($this->Users->save($user)) {
					$this->Flash->success(__('The user has been saved.'));

					return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
			}
			$this->set(compact('user'));
		}

		/**
		 * Edit method
		 *
		 * @param string|null $id User id.
		 * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function edit($id = null) {
			$this->viewBuilder()->setLayout('editor_layout');
			$user = $this->Users->get($id, [
					'contain' => []
			]);
			if ($this->request->is(['patch', 'post', 'put'])) {
				$user = $this->Users->patchEntity($user, $this->request->getData());
				if ($this->Users->save($user)) {
					$this->Flash->success(__('The user has been saved.'));

					return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
			}
			$this->set(compact('user'));
		}

		/**
		 * Delete method
		 *
		 * @param string|null $id User id.
		 * @return \Cake\Http\Response|null Redirects to index.
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function delete($id = null) {
			$this->request->allowMethod(['post', 'delete']);
			$user = $this->Users->get($id);
			if ($this->Users->delete($user)) {
				$this->Flash->success(__('The user has been deleted.'));
			} else {
				$this->Flash->error(__('The user could not be deleted. Please, try again.'));
			}

			return $this->redirect(['action' => 'index']);
		}
	}
