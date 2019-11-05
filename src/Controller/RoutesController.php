<?php

	namespace App\Controller;

	use App\Controller\AppController;
    use App\Model\Table\DeliveriesTable;
    use Cake\Event\Event;
    use Cake\ORM\TableRegistry;

	/**
	 * Routes Controller
	 *
	 * @property \App\Model\Table\RoutesTable $Routes
	 *
	 * @method \App\Model\Entity\Route[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
	 */
	class RoutesController extends AppController {
		public function beforeFilter(Event $event) {
			parent::beforeFilter($event);
		}

		public function isAuthorized($user) {
			return true;
		}

		/**
		 * Index method
		 *
		 * @return \Cake\Http\Response|void
		 */
		public function index() {
			$this->paginate = [
					'contain' => ['Vouchers']
			];
			$routes = $this->paginate($this->Routes);

			$this->set(compact('routes'));
		}

		/**
		 * View method
		 *
		 * @param string|null $id Route id.
		 * @return \Cake\Http\Response|void
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function view($id = null) {
			$route = $this->Routes->get($id, [
					'contain' => ['Vouchers']
			]);

			$this->set('route', $route);
		}

		/**
		 * Add method
		 *
		 * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
		 */
		public function add() {
			$route = $this->Routes->newEntity();
			if ($this->request->is('post')) {
				$route = $this->Routes->patchEntity($route, $this->request->getData());
				$routesEntity = $this->Routes->save($route);
				if ($routesEntity) {
					$this->Flash->success(__('情報を追加しました。'));

					return $this->redirect(['controller'=>'Vouchers', 'action' => 'view', $route->voucher_id]);
				}
				$this->request->session()->write('ValidationError', $routesEntity);
				$this->Flash->error(__('情報を追加できませんでした。'));
			}
			$vouchers = $this->Routes->Vouchers->find('list', ['limit' => 200]);
			$this->set(compact('route', 'vouchers'));
			return $this->redirect(['controller'=>'Vouchers', 'action' => 'view', $route->voucher_id]);
		}

        /**
         * Add method
         *
         * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
         */
        public function addPart() {
            $route = $this->Routes->newEntity();
            if ($this->request->is('post')) {
                if($this->request->getData('delivery_id') != ''){
                    $delivery = TableRegistry::get('Deliveries')->find('All')->where(['id' => $this->request->getData('delivery_id')])->first();
                    $deliveryTable = TableRegistry::get('Deliveries');

                    if($delivery){
                        $route = $this->Routes->patchEntity($route, $this->request->getData());
                        $routesEntity = $this->Routes->save($route);

                        if($this->request->getData('advances_or_additional') == '追加料金'){
                            $additional_price = $delivery->additional_price;
                            $delivery->additional_price = (int) $additional_price + (int) $this->request->getData('price');
                        }else{
                            $advances_paid = $delivery->advances_paid;
                            $delivery->advances_paid = (int) $advances_paid + (int) $this->request->getData('price');
                        }
                        $deliveryEntity = $deliveryTable->save($delivery);

                        if ($routesEntity && $deliveryEntity) {
                            $this->Flash->success(__('情報を追加しました。'));

                            return $this->redirect(['controller'=>'Vouchers', 'action' => 'view', $route->voucher_id]);
                        }
                        $this->request->session()->write('ValidationError', $routesEntity);
                        $this->Flash->error(__('情報を追加できませんでした。'));
                    }
                }
            }
            $vouchers = $this->Routes->Vouchers->find('list', ['limit' => 200]);
            $this->set(compact('route', 'vouchers'));
            return $this->redirect(['controller'=>'Vouchers', 'action' => 'view', $route->voucher_id]);
        }

		/**
		 * Edit method
		 *
		 * @param string|null $id Route id.
		 * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function edit($id = null) {
			$route = $this->Routes->get($id, [
					'contain' => []
			]);
			if ($this->request->is(['patch', 'post', 'put'])) {
				$route = $this->Routes->patchEntity($route, $this->request->getData());
				if ($this->Routes->save($route)) {
					$this->Flash->success(__('The route has been saved.'));

					return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('The route could not be saved. Please, try again.'));
			}
			$vouchers = $this->Routes->Vouchers->find('list', ['limit' => 200]);
			$this->set(compact('route', 'vouchers'));
		}

		/**
		 * Delete method
		 *
		 * @param string|null $id Route id.
		 * @return \Cake\Http\Response|null Redirects to index.
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function delete($id = null) {
			$this->request->allowMethod(['post', 'delete']);
			$route = $this->Routes->get($id);
			if ($this->Routes->delete($route)) {
				$this->Flash->success(__('納品・積込情報を削除いたしました。'));
			} else {
				$this->Flash->error(__('納品・積込情報を削除できませんでした。'));
			}

			return $this->redirect(['controller'=>'Vouchers', 'action' => 'view', $route->voucher_id]);
		}

        /**
         * Delete method
         *
         * @param string|null $id Route id.
         * @return \Cake\Http\Response|null Redirects to index.
         * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
         */
        public function deletePart($id = null) {
            $this->request->allowMethod(['post', 'delete']);
            $route = $this->Routes->get($id);

            $delivery = TableRegistry::get('Deliveries')->find('All')->where(['id' => $route->delivery_id])->first();
            $deliveryTable = TableRegistry::get('Deliveries');

            if($delivery) {
                if ($route->advances_or_additional == '追加料金') {
                    $additional_price = $delivery->additional_price;
                    $delivery->additional_price = (int)$additional_price - (int)$route->price;
                } else {
                    $advances_paid = $delivery->advances_paid;
                    $delivery->advances_paid = (int)$advances_paid - (int)$route->price;
                }
                $deliveryEntity = $deliveryTable->save($delivery);

                if($deliveryEntity){
                    if ($this->Routes->delete($route)) {
                        $this->Flash->success(__('納品・積込情報を削除いたしました。'));
                    } else {
                        $this->Flash->error(__('納品・積込情報を削除できませんでした。'));
                    }
                }else{
                    $this->Flash->error(__('納品・積込情報を削除できませんでした'));
                }
            }
            return $this->redirect(['controller'=>'Vouchers', 'action' => 'view', $route->voucher_id]);
        }
	}
