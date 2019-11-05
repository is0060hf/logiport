<?php

	namespace App\Controller;

	use App\Controller\AppController;
	use Cake\Event\Event;

	/**
	 * Deliveries Controller
	 *
	 * @property \App\Model\Table\RegularServicesTable $RegularServices
	 *
	 * @method \App\Model\Entity\Delivery[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
	 */
	class RegularServicesController extends AppController {

		public function beforeFilter(Event $event)
		{
			parent::beforeFilter($event);
		}

		public function isAuthorized($user)
		{
			return true;
		}

		/**
		 * Add method
		 *
		 * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
		 */
		public function add() {
			$regularService = $this->RegularServices->newEntity();
			if ($this->request->is('post')) {
				$regularService = $this->RegularServices->patchEntity($regularService, $this->request->getData());
				$regularServiceEntity = $this->RegularServices->save($regularService);
				if ($regularServiceEntity) {
					$this->Flash->success(__('情報を追加しました。'));

					return $this->redirect(['controller'=>'Customers', 'action' => 'view', $regularService->customer_id]);
				}
				$this->request->session()->write('ValidationError', $regularServiceEntity);
				$this->Flash->error(__('情報を追加できませんでした。'));
			}
			$customers = $this->RegularServices->Customers->find('list', ['limit' => 200]);
			$this->set(compact('regularService', 'customers'));
		}

		/**
		 * Edit method
		 *
		 * @param string|null $id Delivery id.
		 * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function edit($id = null) {
			$regularService = $this->RegularServices->get($id, [
					'contain' => []
			]);
			if ($this->request->is(['patch', 'post', 'put'])) {
				$regularService = $this->RegularServices->patchEntity($regularService, $this->request->getData());
				$regularServiceEntity = $this->RegularServices->save($regularService);
				if ($regularServiceEntity) {
					$this->Flash->success(__('情報を更新しました。'));

          return $this->redirect(['controller'=>'Customers', 'action' => 'view', $regularService->customer_id]);
        }
        $this->request->session()->write('ValidationError', $regularServiceEntity);
				$this->Flash->error(__('情報を更新できませんでした。'));
			}
			$customers = $this->RegularServices->Customers->find('list', ['limit' => 200]);
			$this->set(compact('regularService', 'customers'));
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
			$regularService = $this->RegularServices->get($id);
			if ($this->RegularServices->delete($regularService)) {
				$this->Flash->success(__('情報を削除いたしました。'));
			} else {
				$this->Flash->error(__('情報を削除できませんでした。'));
			}

			return $this->redirect(['controller'=>'Customers', 'action' => 'view', $regularService->customer_id]);
		}
	}
