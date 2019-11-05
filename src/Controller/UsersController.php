<?php

	namespace App\Controller;

	use App\Util\ModelUtil;
	use ZipArchive;
	use App\Controller\AppController;
	use Cake\Event\Event;
	use Cake\ORM\TableRegistry;
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\Writer\Exception as PhpSpreadsheetWriterException;
	use PhpOffice\PhpSpreadsheet\Writer\Xlsx as XlsxWriter;
	use PhpOffice\PhpSpreadsheet\Settings;
	use PhpOffice\PhpSpreadsheet\Reader\Exception as PhpSpreadsheetReaderException;
	use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;


	/**
	 * Users Controller
	 *
	 * @property \App\Model\Table\UsersTable $Users
	 *
	 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
	 */
	class UsersController extends AppController {

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
			$this->viewBuilder()->setLayout('editor_layout');

			$conditions = [];
			$sort = ['created' => 'desc'];

			if ($this->request->getQuery('sort') && $this->request->getQuery('direction')) {
				$sort = [$this->request->getQuery('sort') => $this->request->getQuery('direction')];
			}

			//検索条件のクリアが選択された場合は全件検索をする
			if ($this->request->getQuery('submit_btn') == 'clear') {
				$users = $this->paginate($this->Users->find('all', ['order' => $sort]));
			} else {
				if ($this->request->getQuery('deliveryman_name') != '') {
					$conditions['username'] = $this->request->getQuery('deliveryman_name');
				}
				$users = $this->paginate($this->Users->find('all', ['order' => $sort, 'conditions' => $conditions]));
			}

			$this->set(compact('users'));
		}

		/**
		 * 請求書を発行するメソッド
		 * @param $selectedId
		 * @throws \PhpOffice\PhpSpreadsheet\Exception
		 * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
		 * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
		 */
		public function writeKanrihu($selectedId) {

			try{
				//テンプレートファイルを読み込む
				$reader = new XlsxReader();
				$spreadsheet = $reader->load(WWW_ROOT . '/upload_xls/kanrihu001.xlsx');
				$sheet = $spreadsheet->getActiveSheet();

				//入力値チェック
				if($this->request->getData('upper_term') == ''){
					throw new \InvalidArgumentException('発行期間（まで）の入力内容が不正です');
				}
				if($this->request->getData('under_term') == ''){
					throw new \InvalidArgumentException('発行期間（から）の入力内容が不正です');
				}

				if(isset($selectedId)){
					// ZIP準備
					$zip = new ZipArchive();
					$fileCounter = 0;
					$zipDir = WWW_ROOT.'/upload_xls/'; // zipファイルを一時的に作る場所。
					$zipName = 'K_'.date("YmdHis").'.zip';

					// 書き込み準備
					$zip->open($zipDir.$zipName, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);

					foreach ($selectedId as $item) {
						$user = TableRegistry::get('Users')->find('All')->where(['id' => $item])->first();
						$voucherList = TableRegistry::get('Vouchers')->find('All')->where(['deliveryman_name' => $user->username,
								'arrival_time <=' => $this->request->getData('upper_term'),
								'arrival_time >=' => $this->request->getData('under_term')]);

						$sheet->setCellValue('B2', date('Y年m月', strtotime($this->request->getData('under_term'))).' '.$user->username);

						$index = 6;
						foreach ($voucherList as $voucher) {
							$delList = TableRegistry::get('Deliveries')->find('All')->where(['voucher_id' => $voucher->id]);
							$delNameList = '';
							$sumPrice = 0;
							$sumAdditionalPrice = 0;
							$sumAdvances_paid = 0;
							$sumDistance = 0;
							$completeTimeList = [];
							$temperature = '';

							$counterNumber = 1;
							$delivaryCounter = 0;

							foreach ($delList as $delItem){
								if($delNameList == ''){
									$delNameList = $delItem->destination;
								}

								if($temperature == ''){
									$temperature = $delItem->temperature;
								}

								if($delItem->price != ''){
									$sumPrice += (int) $delItem->price;
								}

								if($delItem->additional_price != ''){
									$sumAdditionalPrice += (int) $delItem->additional_price;
								}

								if($delItem->advances_paid != ''){
									$sumAdvances_paid += (int) $delItem->advances_paid;
								}

								if($delItem->distance != ''){
									$sumDistance += (int) $delItem->distance;
								}

								$completeTimeList[$delivaryCounter] = $delItem->complete_time;
							}

							//配達先が複数個所存在する場合は、その旨を記述する。
							if($delList->count() > 1){
								$countDelList = $delList->count() - 1;
								$delNameList = $delNameList.'/他'.$countDelList.'件';
							}

							if($delList->count() > 0){
								$sheet->setCellValue('A' . $index, date('Y/m', strtotime($voucher->departure_time)));
								$sheet->setCellValue('B' . $index, $counterNumber);
								$sheet->setCellValue('C' . $index, $voucher->customers_name);
								$sheet->setCellValue('D' . $index, $delNameList);
								$sheet->setCellValue('E' . $index, date("H:i", strtotime($voucher->departure_time)));
								$sheet->setCellValue('F' . $index, date("H:i", strtotime(max($completeTimeList))));
								$sheet->setCellValue('G' . $index, $sumDistance);
								$sheet->setCellValue('H' . $index, $temperature);
								$sheet->setCellValue('J' . $index, $sumPrice);
								$sheet->setCellValue('K' . $index, $sumAdditionalPrice);
								$sheet->setCellValue('L' . $index, $sumAdvances_paid);
								$sheet->setCellValue('M' . $index, $voucher->appendix);
								$index++;
								$counterNumber++;
							}
						}
						try{
							$this->autoRender = false;

							$writer = new XlsxWriter($spreadsheet);
							$file_name = 'K_'.date("YmdHis".'_'.$user->username);
							$writer->save(WWW_ROOT . '/upload_xls/' . $file_name . '.xlsx');
							$zip->addFile(WWW_ROOT . '/upload_xls/' . $file_name . '.xlsx', $file_name . '.xlsx');
							$fileCounter++;

						}catch (PhpSpreadsheetWriterException $ex){
							throw $ex;
						}
					}

					try{

						// ZIPへの書き込み終了
						$zip->close();

						$this->response->type('application/zip');
						$this->response->file(WWW_ROOT . '/upload_xls/' . $zipName, array('download' => true));
						$this->response->download($zipName);

						unlink(WWW_ROOT . '/upload_xls/' . $zipName);

					}catch (PhpSpreadsheetWriterException $ex){
						throw $ex;
					}

				}else{
					throw new \InvalidArgumentException();
				}
			}catch (\InvalidArgumentException $ex){
				throw new \InvalidArgumentException('テンプレートの読み込みに失敗しました。');
			}

		}

		/**
		 * 請求書を発行するメソッド
		 * @param $selectedId
		 * @throws \PhpOffice\PhpSpreadsheet\Exception
		 * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
		 * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
		 */
		public function writeUrikake($selectedId) {

			try{
				//テンプレートファイルを読み込む
				$reader = new XlsxReader();
				$spreadsheet = $reader->load(WWW_ROOT . '/upload_xls/urikake001.xlsx');
				$sheet = $spreadsheet->getActiveSheet();

				//入力値チェック
				if($this->request->getData('upper_term') == ''){
					throw new \InvalidArgumentException('発行期間（まで）の入力内容が不正です');
				}
				if($this->request->getData('under_term') == ''){
					throw new \InvalidArgumentException('発行期間（から）の入力内容が不正です');
				}

				if(isset($selectedId)){
					// ZIP準備
					$zip = new ZipArchive();
					$fileCounter = 0;
					$zipDir = WWW_ROOT.'/upload_xls/'; // zipファイルを一時的に作る場所。
					$zipName = 'U_'.date("YmdHis").'.zip';

					// 書き込み準備
					$zip->open($zipDir.$zipName, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);

					foreach ($selectedId as $item) {
						$sumPrice = 0;
						$sumPriceIncludeCommission = 0;
						$sumAdditionalPrice = 0;
						$sumAdvances_paid = 0;
						$sumDistance = 0;

						$user = TableRegistry::get('Users')->find('All')->where(['id' => $item])->first();
						$voucherList = TableRegistry::get('Vouchers')->find('All')->where(['deliveryman_name' => $user->username,
								'arrival_time <=' => $this->request->getData('upper_term'),
								'arrival_time >=' => $this->request->getData('under_term')]);

						$sheet->setCellValue('A4', date('Y年m月', strtotime($this->request->getData('under_term'))).'分');
						$sheet->setCellValue('C6', $user->username);

						foreach ($voucherList as $voucher) {
							$delList = TableRegistry::get('Deliveries')->find('All')->where(['voucher_id' => $voucher->id]);
							$cst = TableRegistry::get('Customers')->find('All')->where(['customers_name' => $voucher->customers_name])->first();

							foreach ($delList as $delItem){
								if($delItem->additional_price != ''){
									$sumAdditionalPrice += (int) $delItem->additional_price;
								}

								if($delItem->advances_price != ''){
									$sumAdvances_paid += (int) $delItem->advances_price;
								}

								if($delItem->distance != ''){
									$sumDistance += (int) $delItem->distance;
								}
							}

							//ドライバー用の料金テーブルが存在する顧客はそちらのテーブルを参考にする
							if(ModelUtil::hasDriverPriceTable($cst->id)){
								$sumPriceIncludeCommission += (int) ModelUtil::getPriceFromDistance($cst->id, $sumDistance, 'driver');
							}else{
								$sumPriceIncludeCommission += (int) $voucher->sum_price1;
							}

							$sumPrice += (int) $voucher->sum_price1;
						}

						$sheet->setCellValue('A11', $sumPrice);
						$sheet->setCellValue('E11', -1*$sumPriceIncludeCommission);
						$sheet->setCellValue('G11', $user->insurance_fee);
						$sheet->setCellValue('I11', $sumAdvances_paid);
						$sheet->setCellValue('N11', $user->car_fee);

						try{
							$this->autoRender = false;

							$writer = new XlsxWriter($spreadsheet);
							$file_name = 'U_'.date("YmdHis".'_'.$user->username);
							$writer->save(WWW_ROOT . '/upload_xls/' . $file_name . '.xlsx');
							$zip->addFile(WWW_ROOT . '/upload_xls/' . $file_name . '.xlsx', $file_name . '.xlsx');
							$fileCounter++;

						}catch (PhpSpreadsheetWriterException $ex){
							throw $ex;
						}
					}

					try{

						// ZIPへの書き込み終了
						$zip->close();

						$this->response->type('application/zip');
						$this->response->file(WWW_ROOT . '/upload_xls/' . $zipName, array('download' => true));
						$this->response->download($zipName);

						unlink(WWW_ROOT . '/upload_xls/' . $zipName);

					}catch (PhpSpreadsheetWriterException $ex){
						throw $ex;
					}

				}else{
					throw new \InvalidArgumentException();
				}
			}catch (\InvalidArgumentException $ex){
				throw new \InvalidArgumentException('テンプレートの読み込みに失敗しました。');
			}

		}

		/**
		 * Index method
		 *
		 * @return \Cake\Http\Response|void
		 */
		public function urikake() {
			if ($this->request->is('post')) {
				//POSTの場合は請求書の発行
				if ($this->request->getData('submit_btn') == 'urikake_hakkou') {
					try {
						$sel = $this->request->getData('sel');
						$this->writeUrikake($sel);
						return;
					} catch (PhpSpreadsheetReaderException $ex) {
						$this->Flash->error(__('テンプレートのフォーマットが不正です。'));
					} catch (PhpSpreadsheetWriterException $ex) {
						$this->Flash->error(__('売掛金明細書の書き込みに失敗しました。'));
					} catch (\PhpOffice\PhpSpreadsheet\Exception $ex) {
						$this->Flash->error(__('売掛金明細書の発行に失敗しました。'));
					} catch (\InvalidArgumentException $ex) {
						$this->Flash->error(__($ex->getMessage()));
					}
				} elseif ($this->request->getData('submit_btn') == 'kanrihu_hakkou') {
					try {
						$sel = $this->request->getData('sel');
						$this->writeKanrihu($sel);
						return;
					} catch (PhpSpreadsheetReaderException $ex) {
						$this->Flash->error(__('テンプレートのフォーマットが不正です。'));
					} catch (PhpSpreadsheetWriterException $ex) {
						$this->Flash->error(__('売掛金明細書の書き込みに失敗しました。'));
					} catch (\PhpOffice\PhpSpreadsheet\Exception $ex) {
						$this->Flash->error(__('売掛金明細書の発行に失敗しました。'));
					} catch (\InvalidArgumentException $ex) {
						$this->Flash->error(__($ex->getMessage()));
					}
				} else {
					$this->Flash->error(__('不正なアクセスです。操作をやり直してください。' . $this->request->getData('submit_btn')));
				}

				return $this->redirect(['action' => 'urikake']);
			} else {
				//POST以外は基本的にGET（検索、検索条件のクリア、ページング、ソート）の想定
				$this->viewBuilder()->setLayout('editor_layout');

				$this->paginate = [
						'limit' => 50
				];

				$conditions = [];
				$sort = ['created' => 'desc'];

				if ($this->request->getQuery('sort') && $this->request->getQuery('direction')) {
					$sort = [$this->request->getQuery('sort') => $this->request->getQuery('direction')];
				}

				//検索条件のクリアが選択された場合は全件検索をする
				if ($this->request->getQuery('submit_btn') == 'clear') {
					$users = $this->paginate($this->Users->find('all', ['order' => $sort]));
				} else {
					if ($this->request->getQuery('deliveryman_name') != '') {
						$conditions['username'] = $this->request->getQuery('deliveryman_name');
					}
					$users = $this->paginate($this->Users->find('all', ['order' => $sort, 'conditions' => $conditions]));
				}

				if ($this->request->session()->read('Auth.User.user_role') == 'システム管理者') {
					$this->set(compact('users'));
				}
			}
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
					$this->Flash->success(__('ドライバー情報を正常に追加しました。'));
					return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('ドライバー情報を追加できませんでした。'));
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
					$this->Flash->success(__('ドライバー情報を正常に更新しました。'));
					return $this->redirect(['action' => 'view', $user->id]);
				}
				$this->Flash->error(__('ドライバー情報を更新できませんでした。'));
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
		public function passwordUpdate($id = null) {
			$user = $this->Users->get($id, [
					'contain' => []
			]);
			if ($this->request->is(['patch', 'post', 'put'])) {
				$user = $this->Users->patchEntity($user, $this->request->getData());
				if ($this->Users->save($user)) {
					$this->Flash->success(__('パスワードを正常に更新しました'));
					return $this->redirect(['action' => 'view', $user->id]);
				}
				$this->Flash->error(__('パスワードを更新できませんでした。'));
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
				$this->Flash->success(__('ドライバー情報を削除いたしました。'));
			} else {
				$this->Flash->error(__('ドライバー情報を削除できませんでした。'));
			}

			return $this->redirect(['action' => 'index']);
		}
	}
