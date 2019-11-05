<?php

	namespace App\Controller;

	use App\Controller\AppController;
	use Cake\Event\Event;
	use Cake\ORM\TableRegistry;

	/**
	 * Deliveries Controller
	 *
	 * @property \App\Model\Table\RegularDeliveriesTable $RegularDeliveries
	 *
	 * @method \App\Model\Entity\Delivery[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
	 */
	class RegularDeliveriesController extends AppController {

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
		 * @param string|null $id RegularDelivery id.
		 * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
		 */
		public function add($id = null) {
			$regularDelivery = $this->RegularDeliveries->newEntity();
			if ($this->request->is('post')) {
				$regularDelivery = $this->RegularDeliveries->patchEntity($regularDelivery, $this->request->getData());
				$regularDeliveryEntity = $this->RegularDeliveries->save($regularDelivery);
				if ($regularDeliveryEntity) {
					$this->Flash->success(__('情報を追加しました。'));

					$rs = TableRegistry::get('RegularServices')->find()->where(['id' => $id])->first();
					return $this->redirect(['controller'=>'Customers', 'action' => 'view', $rs->customer_id]);
				}
				$this->request->session()->write('ValidationError', $regularDeliveryEntity);
				$this->Flash->error(__('情報を追加できませんでした。'));
			}

			$this->set(compact('id'));
			$this->set(compact('regularDelivery'));
		}

		/**
		 * Edit method
		 *
		 * @param string|null $id Delivery id.
		 * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function edit($id = null) {
			$regularDelivery = $this->RegularDeliveries->get($id, [
					'contain' => []
			]);
			if ($this->request->is(['patch', 'post', 'put'])) {
				$regularDelivery = $this->RegularDeliveries->patchEntity($regularDelivery, $this->request->getData());
        $regularDeliveryEntity = $this->RegularDeliveries->save($regularDelivery);
				if ($regularDeliveryEntity) {
					$this->Flash->success(__('情報を更新しました。'));

					$rd = TableRegistry::get('RegularDeliveries')->find()->where(['id' => $id])->first();
					$rs = TableRegistry::get('RegularServices')->find()->where(['id' => $rd->regular_service_id])->first();
					return $this->redirect(['controller'=>'Customers', 'action' => 'view', $rs->customer_id]);
        }
        $this->request->session()->write('ValidationError', $regularDeliveryEntity);
				$this->Flash->error(__('情報を更新できませんでした。'));
			}

			$this->set(compact('regularDelivery'));
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
			$regularDelivery = $this->RegularDeliveries->get($id);
			$rd = TableRegistry::get('RegularDeliveries')->find()->where(['id' => $id])->first();
			$rs = TableRegistry::get('RegularServices')->find()->where(['id' => $rd->regular_service_id])->first();

			if ($this->RegularDeliveries->delete($regularDelivery)) {
				$this->Flash->success(__('削除いたしました。'));
			} else {
				$this->Flash->error(__('削除できませんでした。'));
			}

			return $this->redirect(['controller'=>'Customers', 'action' => 'view', $rs->customer_id]);
		}
	}
