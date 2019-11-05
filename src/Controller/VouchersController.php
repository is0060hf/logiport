<?php

	namespace App\Controller;

	use App\Controller\AppController;
	use App\Util\ModelUtil;
	use Cake\Event\Event;
	use Cake\ORM\TableRegistry;
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\Writer\Exception as PhpSpreadsheetWriterException;
	use PhpOffice\PhpSpreadsheet\Writer\Xlsx as XlsxWriter;
	use PhpOffice\PhpSpreadsheet\Settings;
	use PhpOffice\PhpSpreadsheet\Reader\Exception as PhpSpreadsheetReaderException;
	use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;
	use Cake\Datasource\ConnectionManager;

	/**
	 * Vouchers Controller
	 *
	 * @property \App\Model\Table\VouchersTable $Vouchers
	 *
	 * @method \App\Model\Entity\Voucher[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
	 */
	class VouchersController extends AppController {

		public $paginate = [
				'limit' => 20
		];

		private $user_info;

		public function beforeFilter(Event $event) {
			parent::beforeFilter($event);
			if ($this->request->getSession()->read('errors')) {
				foreach ($this->request->getSession()->read('errors') as $model => $errors) {
					$this->loadModel($model);
					$this->$model->validationErrors = $errors;
				}
				$this->request->getSession()->delete('errors');
			}
		}

		public function isAuthorized($user) {
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
				if (isset($voucher) && isset($user) && $user['username'] == $voucher['deliveryman_name']) {
					return true;
				}
			}

			return parent::isAuthorized($user);
		}

		/**
		 * 伝票情報から請求書のＰＤＦを出力する
		 */
		function ajaxGetSeikyuushoPDF() {

		}

		/**
		 * 伝票入力欄にて配達員の情報が変更されたときに呼び出される関数
		 * @throws \Exception
		 */
		function ajaxGetUserInfo() {
			$this->autoRender = FALSE;
			$this->response->type('json');

			if (!$this->request->is('ajax')) {
				throw new \Exception();
			}

			$id = $this->request->getQuery('userid');
			$user = TableRegistry::get('Users')->find()->where(['username' => $id])->first();
			$status = !empty($user);
			if ($user) {
				$result = [
						'username' => $user->username,
						'car_numb' => $user->car_numb
				];
				$error = [];
			} else {
				$result = [];
				$error = array(
						'message' => 'データがありません',
						'code' => 404
				);
			}
			// json_encodeを使用してJSON形式で返却
			echo json_encode(compact('status', 'result', 'error'));
		}

		/**
		 * 伝票入力欄にて、お得意先の値が変更されたときに呼び出される項目
		 * @throws \Exception
		 */
		function ajaxGetDeliveryDest() {
			$this->autoRender = FALSE;
			$this->response->type('json');

			if (!$this->request->is('ajax')) {
				throw new \Exception();
			}

			$id = $this->request->getQuery('customersName');
			$customer = TableRegistry::get('Customers')->find()->where(['customers_name' => $id])->first();
			$status = !empty($customer);
			if ($customer) {
				$result = [
						'delivery_dest' => $customer->delivery_dest,
						'customers_phone' => $customer->customers_phone
				];
				$error = [];
			} else {
				$result = [];
				$error = array(
						'message' => 'データがありません' . $id,
						'code' => 404
				);
			}
			// json_encodeを使用してJSON形式で返却
			echo json_encode(compact('status', 'result', 'error'));
		}

		/**
		 * 伝票入力欄にて、往路距離が変更されたときに呼び出される関数
		 * @throws \Exception
		 */
		function ajaxGetPriceFromDistance() {
			$this->autoRender = FALSE;
			$this->response->type('json');

			if (!$this->request->is('ajax')) {
				throw new \Exception();
			}

			$dist = $this->request->getQuery('dist');
			$cst_name = $this->request->getQuery('cst_name');

			$cst = TableRegistry::get('Customers')->find()->where(['customers_name' => $cst_name])->first();
			if (is_numeric($dist)) {
				if ($cst) {
					$pTable = TableRegistry::get('PriceTables')->find()->where(['customer_id' => $cst->id])->first();
					$nowPrice = 0;
					if ($pTable) {
						$distancePriceTable = TableRegistry::get('DistancePrices')->find()->where(['price_table_id' => $pTable->id])->orderAsc('distance');

						for ($nowDist = 0; $nowDist <= $dist; $nowDist++) {
							$resultPrice = 0;
							foreach ($distancePriceTable as $tItem) {
								if ($nowDist >= $tItem->distance) {
									$resultPrice = $tItem->price;
								}
							}
							$nowPrice += $resultPrice;
						}

						$result = [
								'price' => $nowPrice + $pTable->basic_price
						];
						$error = [];
					} else {
						$result = [];
						$error = array(
								'message' => '料金表情報がありません',
								'code' => 404
						);
					}
				} else {
					$result = [];
					$error = array(
							'message' => '顧客情報がありません',
							'code' => 404
					);
				}
			} else {
				$result = [];
				$error = array(
						'message' => '距離が数値ではありません',
						'code' => 500
				);
			}

			$status = !empty($pTable);

			// json_encodeを使用してJSON形式で返却
			echo json_encode(compact('status', 'result', 'error'));
		}

		/**
		 * 伝票入力欄にて、お得意先の値が変更されたときに呼び出される項目
		 * @throws \Exception
		 */
		function ajaxGetCargoHandlingFee() {
			$this->autoRender = FALSE;
			$this->response->type('json');

			if (!$this->request->is('ajax')) {
				throw new \Exception();
			}

			$price_return = $this->request->getQuery('price_return');
			$cst_name = $this->request->getQuery('cst_name');

			$cst = TableRegistry::get('Customers')->find()->where(['customers_name' => $cst_name])->first();
			if ($cst) {
				$pTable = TableRegistry::get('PriceTables')->find()->where(['customer_id' => $cst->id])->first();

				if ($pTable) {
					$return_magnification = $pTable->return_magnification;
					$return_additional_fee = $pTable->return_additional_fee;

					if ($return_additional_fee) {
						$result = [
								'price' => $return_additional_fee
						];
						$error = [];
					} else {
						if (is_numeric($price_return)) {
							$result = [
									'price' => round($price_return * $return_magnification / 100)
							];
							$error = [];
						} else {
							$result = [];
							$error = array(
									'message' => '距離が数値ではありません',
									'code' => 500
							);
						}
					}
				} else {
					$result = [];
					$error = array(
							'message' => '料金表情報がありません',
							'code' => 404
					);
				}
			} else {
				$result = [];
				$error = array(
						'message' => '顧客情報がありません',
						'code' => 404
				);
			}

			$status = !empty($cst);

			// json_encodeを使用してJSON形式で返却
			echo json_encode(compact('status', 'result', 'error'));
		}

		/**
		 * 伝票入力欄にて、往路距離が変更されたときに呼び出される関数
		 * @throws \Exception
		 */
		function ajaxGetWaitingFee() {
			$this->autoRender = FALSE;
			$this->response->type('json');

			if (!$this->request->is('ajax')) {
				throw new \Exception();
			}

			$time = $this->request->getQuery('time');
			$cst_name = $this->request->getQuery('cst_name');

			$cst = TableRegistry::get('Customers')->find()->where(['customers_name' => $cst_name])->first();
			if (is_numeric($time)) {
				if ($cst) {
					$pTable = TableRegistry::get('PriceTables')->find()->where(['customer_id' => $cst->id])->first();
					if ($pTable) {
						$waiting_basic_min = $pTable->waiting_basic_min;
						$waiting_fee = $pTable->waiting_fee;
						$waitingFeeContainBasic = $time - $waiting_basic_min;
						if ($waitingFeeContainBasic < 0) {
							$waitingFeeContainBasic = 0;
						}

						$result = [
								'price' => $waiting_fee * $waitingFeeContainBasic
						];
						$error = [];
					} else {
						$result = [];
						$error = array(
								'message' => '料金表情報がありません',
								'code' => 404
						);
					}
				} else {
					$result = [];
					$error = array(
							'message' => '顧客情報がありません',
							'code' => 404
					);
				}
			} else {
				$result = [];
				$error = array(
						'message' => '距離が数値ではありません',
						'code' => 500
				);
			}

			$status = !empty($pTable);

			// json_encodeを使用してJSON形式で返却
			echo json_encode(compact('status', 'result', 'error'));
		}

		/**
		 * 出発地と行き先から過去に登録された同様のデータを参照し、
		 * 一番距離の長いものを返す。ただし例外は含めない
		 * @throws \Exception
		 */
		function ajaxGetDistanceLongest() {
			$this->autoRender = FALSE;
			$this->response->type('json');

			if (!$this->request->is('ajax')) {
				throw new \Exception();
			}

			$start_location = $this->request->getQuery('start_location');
			$destination = $this->request->getQuery('destination');

			if ($start_location && $destination) {
				$deliveryMaxDist = TableRegistry::get('Deliveries')->find('All')
						->where(['start_location' => $start_location, 'destination' => $destination, 'is_exception !=' => 'あり'])->order(['distance' => 'desc'])->first();
				$status = !is_null($deliveryMaxDist);
				if ($deliveryMaxDist) {
					$result = [
							'distance' => $deliveryMaxDist->distance
					];
					$error = [];
				} else {
					$result = [
							'distance' => 0
					];
					$error = [];
				}
			} else {
				$result = [];
				$error = array(
						'message' => '必要なクエリが足りません',
						'code' => 404
				);
			}


			// json_encodeを使用してJSON形式で返却
			echo json_encode(compact('status', 'result', 'error'));
		}

		/**
		 * Index method
		 *
		 * @return \Cake\Http\Response|void
		 */
		public function index() {
			$this->viewBuilder()->setLayout('editor_layout');

			if ($this->request->session()->read('Auth.User.user_role') == 'システム管理者') {
				$conditions = [];
				$sort = ['created' => 'desc'];

				if ($this->request->getQuery('sort') && $this->request->getQuery('direction')) {
					$sort = [$this->request->getQuery('sort') => $this->request->getQuery('direction')];
				}

				//検索条件のクリアが選択された場合は全件検索をする
				if ($this->request->getQuery('submit_btn') == 'clear') {
					$vouchers = $this->paginate($this->Vouchers->find('all', ['order' => $sort]));
				} else {
					if ($this->request->getQuery('deliveryman_name') != '') {
						$conditions['deliveryman_name'] = $this->request->getQuery('deliveryman_name');
					}
					if ($this->request->getQuery('customers_name') != '') {
						$conditions['customers_name'] = $this->request->getQuery('customers_name');
					}
					if ($this->request->getQuery('delivery_dest') != '') {
						$conditions['delivery_dest'] = $this->request->getQuery('delivery_dest');
					}
					if ($this->request->getQuery('appendix') != '') {
						$conditions['appendix LIKE'] = '%' . $this->request->getQuery('appendix') . '%';
					}
					if ($this->request->getQuery('upper_created') != '') {
						$conditions['created <='] = $this->request->getQuery('upper_created');
					}
					if ($this->request->getQuery('under_created') != '') {
						$conditions['created >='] = $this->request->getQuery('under_created');
					}
					$vouchers = $this->paginate($this->Vouchers->find('all', ['order' => $sort, 'conditions' => $conditions]));
				}
			} else {
				$vouchers = $this->paginate($this->Vouchers->find('all')->where(['deliveryman_name' => $this->request->session()->read('Auth.User.username')]));
			}

			$this->set(compact('vouchers'));
		}

		/**
		 * Index method
		 *
		 * @return \Cake\Http\Response|void
		 */
		public function indexPart() {
			$this->viewBuilder()->setLayout('editor_layout');

			if ($this->request->session()->read('Auth.User.user_role') == 'システム管理者') {
				$conditions = [];
				$sort = ['created' => 'desc'];

				if ($this->request->getQuery('sort') && $this->request->getQuery('direction')) {
					$sort = [$this->request->getQuery('sort') => $this->request->getQuery('direction')];
				}

				//検索条件のクリアが選択された場合は全件検索をする
				if ($this->request->getQuery('submit_btn') == 'clear') {
					$vouchers = $this->paginate($this->Vouchers->find('all', ['order' => $sort]));
				} else {
					if ($this->request->getQuery('deliveryman_name') != '') {
						$conditions['deliveryman_name'] = $this->request->getQuery('deliveryman_name');
					}
					if ($this->request->getQuery('customers_name') != '') {
						$conditions['customers_name'] = $this->request->getQuery('customers_name');
					}
					if ($this->request->getQuery('delivery_dest') != '') {
						$conditions['delivery_dest'] = $this->request->getQuery('delivery_dest');
					}
					if ($this->request->getQuery('appendix') != '') {
						$conditions['appendix LIKE'] = '%' . $this->request->getQuery('appendix') . '%';
					}
					if ($this->request->getQuery('upper_created') != '') {
						$conditions['created <='] = $this->request->getQuery('upper_created');
					}
					if ($this->request->getQuery('under_created') != '') {
						$conditions['created >='] = $this->request->getQuery('under_created');
					}
					$vouchers = $this->paginate($this->Vouchers->find('all', ['order' => $sort, 'conditions' => $conditions]));
				}
			} else {
				$vouchers = $this->paginate($this->Vouchers->find('all')->where(['deliveryman_name' => $this->request->session()->read('Auth.User.username')]));
			}

			$this->set(compact('vouchers'));
		}

		/**
		 * 請求書を発行するメソッド
		 * @param $selectedId
		 * @throws \PhpOffice\PhpSpreadsheet\Exception
		 * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
		 * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
		 */
		public function writeSeikyuu($selectedId) {

			try {
				//テンプレートファイルを読み込む
				$reader = new XlsxReader();
				$spreadsheet = $reader->load(WWW_ROOT . '/upload_xls/seikyu003.xlsx');
				$sheet = $spreadsheet->getActiveSheet();

				//入力値チェック
				if ($this->request->getData('seikyuuduki') == '') {
					throw new \InvalidArgumentException('請求月の入力内容が不正です');
				}

				if ($this->request->getData('customers_name') == '') {
					throw new \InvalidArgumentException('請求先の入力内容が不正です');
				}

				if ($this->request->getData('hakkoubi') == '') {
					throw new \InvalidArgumentException('発行日の入力内容が不正です');
				}

				if (isset($selectedId)) {
					//テンプレートのデータを全て読み込む
					$sheet->setCellValue('H2', '(' . $this->request->getData('seikyuuduki') . '月分）');
					$sheet->setCellValue('A5', $this->request->getData('customers_name') . ' 御中');
					$sheet->setCellValue('M3', '請求日：' . $this->request->getData('hakkoubi'));

					$index = 26;

					foreach ($selectedId as $item) {
						$itemizedStatement = TableRegistry::get('ItemizedStatements')->find('All')->where(['id' => $item])->first();

						$sheet->setCellValue('A' . $index, $itemizedStatement->billing_date);
						$sheet->setCellValue('C' . $index, $itemizedStatement->delivery_dest);
						$sheet->setCellValue('F' . $index, $itemizedStatement->delivery_dest_count);
						$sheet->setCellValue('J' . $index, $itemizedStatement->price);
						$sheet->setCellValue('L' . $index, $itemizedStatement->additional_price);
						$sheet->setCellValue('N' . $index, $itemizedStatement->advances_paid);
						$sheet->setCellValue('P' . $index, $itemizedStatement->appendix);
						$index++;
					}

					try {
						$this->autoRender = false;

						$writer = new XlsxWriter($spreadsheet);
						$file_name = 'S_' . date("YmdHis");
						$writer->save(WWW_ROOT . '/upload_xls/' . $file_name . '.xlsx');

						$this->response->type('application/xlsx');
						$this->response->file(WWW_ROOT . '/upload_xls/' . $file_name . '.xlsx', array('download' => true));
						$this->response->download($file_name . '.xlsx');
					} catch (PhpSpreadsheetWriterException $ex) {
						throw $ex;
					}

				} else {
					throw new \InvalidArgumentException();
				}
			} catch (\InvalidArgumentException $ex) {
				throw new \InvalidArgumentException('テンプレートの読み込みに失敗しました。');
			}

		}

		/**
		 * 内訳明細書を発行するメソッド
		 * @param $selectedId
		 * @throws \PhpOffice\PhpSpreadsheet\Exception
		 * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
		 * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
		 */
		public function writeUtiwake($selectedId) {

			try {
				//テンプレートファイルを読み込む
				$reader = new XlsxReader();
				$spreadsheet = $reader->load(WWW_ROOT . '/upload_xls/utiwake002.xlsx');
				$sheet = $spreadsheet->getActiveSheet();

				//入力値チェック
				if ($this->request->getData('seikyuuduki') == '') {
					throw new \InvalidArgumentException('請求月の入力内容が不正です');
				}

				if ($this->request->getData('hakkoubi') == '') {
					throw new \InvalidArgumentException('発行日の入力内容が不正です');
				}

				if (isset($selectedId)) {
					//テンプレートのデータを全て読み込む
					$sheet->setCellValue('I2', '(' . $this->request->getData('seikyuuduki') . '月分）');
					$sheet->setCellValue('Q4', '請求日：' . $this->request->getData('hakkoubi'));

					$startRow = 12;
					$index = $startRow;
					$delivery_dest_counter = 0;
					$savedata['delivery_dest'] = '';
					$savedata['distance'] = 0;
					$savedata['price'] = 0;
					$savedata['additional_price'] = 0;
					$savedata['advances_paid'] = 0;


					foreach ($selectedId as $item) {
						$voucher = TableRegistry::get('Vouchers')->find('All')->where(['id' => $item])->first();
						$delList = TableRegistry::get('Deliveries')->find('All')->where(['voucher_id' => $item]);

						$delivery_dest = '';
						$destination = '';
						$distance = 0;
						$price = 0;
						$additional_price = 0;
						$advances_paid = 0;
						$has_take_out = 'なし';
						$appendix = '';

						foreach ($delList as $delItem) {
							if ($savedata['delivery_dest'] != '') {
								$savedata['delivery_dest'] = $savedata['delivery_dest'] . ' / ' . $delItem->delivery_dest;
							} else {
								$savedata['delivery_dest'] = $delItem->delivery_dest;
							}

							if ($delivery_dest != ''){
								$delivery_dest = $delivery_dest . ' / ' . $delItem->delivery_dest;
							}else{
								$delivery_dest = $delItem->delivery_dest;
							}

							if ($destination != ''){
								$destination = $destination . ' / ' . $delItem->destination;
							}else{
								$destination = $delItem->destination;
							}

							$savedata['distance'] += (int) $delItem->distance;
							$savedata['price'] += (int) $delItem->price;
							$savedata['additional_price'] += (int) $delItem->additional_price;
							$savedata['advances_paid'] += (int) $delItem->advances_paid;

							$distance += $delItem->distance;
							$price += $delItem->price;
							$additional_price += $delItem->additional_price;
							$advances_paid += $delItem->advances_paid;

							if ($delItem->has_take_out == 'あり'){
								$has_take_out = 'あり';
							}

							$delivery_dest_counter += 1;
						}
						$sheet->setCellValue('A' . $index, date('d日', strtotime($voucher->departure_time)));
						$sheet->setCellValue('C' . $index, $delivery_dest);
						$sheet->setCellValue('F' . $index, $destination);
						$sheet->setCellValue('L' . $index, $distance);
						$sheet->setCellValue('N' . $index, $price);
						$sheet->setCellValue('P' . $index, $additional_price);
						$sheet->setCellValue('R' . $index, $advances_paid);
						$sheet->setCellValue('T' . $index, $has_take_out);
						$sheet->setCellValue('V' . $index, $appendix);

						$index++;
					}

					$savedata['delivery_dest_count'] = $delivery_dest_counter;

					try {
						$savedata['billing_date'] = $this->request->getData('hakkoubi');
						$savedata['customers_name'] = $this->request->getData('customers_name');
						$itemizedStatementTable = TableRegistry::get('ItemizedStatements');
						$itemizedStatement = $itemizedStatementTable->newEntity($savedata);
						$itemizedStatementTable->save($itemizedStatement);

						$this->autoRender = false;

						$writer = new XlsxWriter($spreadsheet);
						$file_name = 'U_' . date("YmdHis");
						$writer->save(WWW_ROOT . '/upload_xls/' . $file_name . '.xlsx');

						$this->response->type('application/xlsx');
						$this->response->file(WWW_ROOT . '/upload_xls/' . $file_name . '.xlsx', array('download' => true));
						$this->response->download($file_name . '.xlsx');
					} catch (PhpSpreadsheetWriterException $ex) {
						throw $ex;
					}

				} else {
					throw new \InvalidArgumentException();
				}
			} catch (\InvalidArgumentException $ex) {
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
		public function writeFax($selectedId) {

			try {
				//テンプレートファイルを読み込む
				$reader = new XlsxReader();
				$spreadsheet = $reader->load(WWW_ROOT . '/upload_xls/fax001.xlsx');
				$sheet = $spreadsheet->getActiveSheet();

				//入力値チェック
				if ($this->request->getData('seikyuuduki') == '') {
					throw new \InvalidArgumentException('請求月の入力内容が不正です');
				}

				if ($this->request->getData('customers_name') == '') {
					throw new \InvalidArgumentException('請求先の入力内容が不正です');
				}

				if ($this->request->getData('hakkoubi') == '') {
					throw new \InvalidArgumentException('発行日の入力内容が不正です');
				}

				if (isset($selectedId)) {
					//テンプレートのデータを全て読み込む
					$sheet->setCellValue('G2', '作成日：' . $this->request->getData('hakkoubi'));
					$sheet->setCellValue('B3', $this->request->getData('customers_name') . ' 御中');
					$sheet->setCellValue('B8', $this->request->getData('hakkoubi') . '配送の実績をご報告いたしますのでご査収ください。');

					$index = 13;

					foreach ($selectedId as $item) {
						$voucher = TableRegistry::get('Vouchers')->find('All')->where(['id' => $item])->first();
						$delList = TableRegistry::get('Deliveries')->find('All')->where(['voucher_id' => $item]);

						$delNameList = '';
						$sumPrice = 0;
						$sumAdditionalPrice = 0;
						$sumAdvances_paid = 0;
						$sumDistance = 0;

						foreach ($delList as $delItem) {
							if ($delNameList == '') {
								$delNameList = $delItem->destination;
							} else {
								$delNameList = $delNameList . '/' . $delItem->destination;
							}

							if ($delItem->price != '') {
								$sumPrice += (int)$delItem->price;
							}

							if ($delItem->additional_price != '') {
								$sumAdditionalPrice += (int)$delItem->additional_price;
							}

							if ($delItem->advances_price != '') {
								$sumAdvances_paid += (int)$delItem->advances_price;
							}

							if ($delItem->distance != '') {
								$sumDistance += (int)$delItem->distance;
							}
						}

						$sheet->setCellValue('A' . $index, date('Y/m/d', strtotime($voucher->departure_time)));
						$sheet->setCellValue('B' . $index, $voucher->delivery_dest);
						$sheet->setCellValue('C' . $index, $delNameList);
						$sheet->setCellValue('D' . $index, $sumDistance);
						$sheet->setCellValue('E' . $index, $sumPrice);
						$sheet->setCellValue('F' . $index, $sumAdditionalPrice);
						$sheet->setCellValue('G' . $index, $sumAdvances_paid);
						$sheet->setCellValue('I' . $index, $voucher->appendix);
						$index++;
					}

					try {
						$this->autoRender = false;

						$writer = new XlsxWriter($spreadsheet);
						$file_name = 'F_' . date("YmdHis");
						$writer->save(WWW_ROOT . '/upload_xls/' . $file_name . '.xlsx');

						$this->response->type('application/xlsx');
						$this->response->file(WWW_ROOT . '/upload_xls/' . $file_name . '.xlsx', array('download' => true));
						$this->response->download($file_name . '.xlsx');
					} catch (PhpSpreadsheetWriterException $ex) {
						throw $ex;
					}

				} else {
					throw new \InvalidArgumentException();
				}
			} catch (\InvalidArgumentException $ex) {
				throw new \InvalidArgumentException('テンプレートの読み込みに失敗しました。');
			}

		}

		/**
		 * 請求書の発行画面
		 */
		public function seikyuu() {
			$this->viewBuilder()->setLayout('search_layout');
			if ($this->request->is('post')) {
				//POSTの場合は内訳明細書の発行
				if ($this->request->getData('submit_btn') == 'utiwake_hakkou') {
					try {
						$sel = $this->request->getData('sel');
						$this->writeUtiwake($sel);
						return;
					} catch (PhpSpreadsheetReaderException $ex) {
						$this->Flash->error(__('テンプレートのフォーマットが不正です。'));
					} catch (PhpSpreadsheetWriterException $ex) {
						$this->Flash->error(__('内訳明細書の書き込みに失敗しました。'));
					} catch (\PhpOffice\PhpSpreadsheet\Exception $ex) {
						$this->Flash->error(__('内訳明細書の発行に失敗しました。'));
					} catch (\InvalidArgumentException $ex) {
						$this->Flash->error(__($ex->getMessage()));
					}
				} else {
					$this->Flash->error(__('不正なアクセスです。操作をやり直してください。' . $this->request->getData('submit_btn')));
				}

				return $this->redirect(['action' => 'seikyuu']);
			} else {
				//POST以外は基本的にGET（検索、検索条件のクリア、ページング、ソート）の想定
				$vouchers = $this->searchReportExec();
				$vouchersExcludeDestination = $this->searchReportExecExcludeDestination();
				$this->set(compact('vouchers'));
				$this->set(compact('vouchersExcludeDestination'));
			}
		}

		/**
		 * 内訳から請求書を作成する
		 */
		public function seikyuuFromUtiwake() {
			$this->viewBuilder()->setLayout('search_layout');
			if ($this->request->is('post')) {
				//POSTの場合は請求書の発行
				if ($this->request->getData('submit_btn') == 'seikyuu_hakkou') {
					try {
						$sel = $this->request->getData('sel');
						$this->writeSeikyuu($sel);
						return;
					} catch (PhpSpreadsheetReaderException $ex) {
						$this->Flash->error(__('テンプレートのフォーマットが不正です。'));
					} catch (PhpSpreadsheetWriterException $ex) {
						$this->Flash->error(__('請求書の書き込みに失敗しました。'));
					} catch (\PhpOffice\PhpSpreadsheet\Exception $ex) {
						$this->Flash->error(__('請求書の発行に失敗しました。'));
					} catch (\InvalidArgumentException $ex) {
						$this->Flash->error(__($ex->getMessage()));
					}
				} else {
					$this->Flash->error(__('不正なアクセスです。操作をやり直してください。' . $this->request->getData('submit_btn')));
				}

				return $this->redirect(['action' => 'seikyuuFromUtiwake']);
			} else {
				//POST以外は基本的にGET（検索、検索条件のクリア、ページング、ソート）の想定
				$itemizedStatements = $this->searchUtiwakeExec();
				$vouchersExcludeDestination = $this->searchReportExecExcludeDestination();
				$this->set(compact('itemizedStatements'));
				$this->set(compact('vouchersExcludeDestination'));
			}
		}

		/**
		 * FAX送付状生成画面の処理
		 * POST：FAX送付状出力
		 * GET：項目検索
		 * @return \Cake\Http\Response|null|void
		 */
		public function fax() {
			$this->viewBuilder()->setLayout('search_layout');
			if ($this->request->is('post')) {
				//POSTの場合はFAX送付状の発行
				if ($this->request->getData('submit_btn') == 'fax_hakkou') {
					try {
						$sel = $this->request->getData('sel');
						$this->writeFax($sel);
						return;
					} catch (PhpSpreadsheetReaderException $ex) {
						$this->Flash->error(__('テンプレートのフォーマットが不正です。'));
					} catch (PhpSpreadsheetWriterException $ex) {
						$this->Flash->error(__('FAX送付状の書き込みに失敗しました。'));
					} catch (\PhpOffice\PhpSpreadsheet\Exception $ex) {
						$this->Flash->error(__('FAX送付状の発行に失敗しました。'));
					} catch (\InvalidArgumentException $ex) {
						$this->Flash->error(__($ex->getMessage()));
					}
				} else {
					$this->Flash->error(__('不正なアクセスです。操作をやり直してください。' . $this->request->getData('submit_btn')));
				}

				return $this->redirect(['action' => 'fax']);
			} else {
				//POST以外は基本的にGET（検索、検索条件のクリア、ページング、ソート）の想定
				$vouchers = $this->searchReportExec();
				$vouchersExcludeDestination = $this->searchReportExecExcludeDestination();
				$this->set(compact('vouchers'));
				$this->set(compact('vouchersExcludeDestination'));
			}
		}

		/**
		 * Fax送付状、内訳明細書、請求書の発行画面で検索するときのメソッド
		 * @return \App\Model\Entity\Voucher[]|\Cake\Datasource\ResultSetInterface
		 */
		function searchUtiwakeExec() {
			$this->paginate = [
					'limit' => 100
			];

			//ソートの内容を反映する
			$sort = ['created' => 'desc'];
			if ($this->request->getQuery('sort') && $this->request->getQuery('direction')) {
				$sort = [$this->request->getQuery('sort') => $this->request->getQuery('direction')];
			}

			//検索条件のクリアが選択された場合は全件検索をする
			if ($this->request->getQuery('submit_btn') == 'clear') {
				$itemizedStatement = $this->paginate(TableRegistry::get('ItemizedStatements')->find('all'));
			} else {
				$conditions = $this->makeConditionsUtiwake();

				$itemizedStatement = $this->paginate(TableRegistry::get('ItemizedStatements')->find('all')
						->where($conditions)->order($sort));
			}

			return $itemizedStatement;
		}

		/**
		 * Fax送付状、内訳明細書、請求書の発行画面で検索するときのメソッド
		 * @return \App\Model\Entity\Voucher[]|\Cake\Datasource\ResultSetInterface
		 */
		function searchReportExec() {
			$this->paginate = [
					'limit' => 100
			];

			//ソートの内容を反映する
			$sort = ['Vouchers.created' => 'desc'];
			if ($this->request->getQuery('sort') && $this->request->getQuery('direction')) {
				$sort = ['Vouchers.' . $this->request->getQuery('sort') => $this->request->getQuery('direction')];
			}

			//検索条件のクリアが選択された場合は全件検索をする
			if ($this->request->getQuery('submit_btn') == 'clear') {
				$vouchers = $this->paginate($this->Vouchers->find('all', ['order' => $sort]));
			} else {
				$conditions = $this->makeConditions();

				$vouchers = $this->paginate(TableRegistry::get('Vouchers')->find('all')->join([
						'type' => 'LEFT',
						'table' => 'deliveries',
						'conditions' => 'deliveries.voucher_id = Vouchers.id'
				])->where($conditions)->order($sort)->distinct('Vouchers.id'));
			}

			return $vouchers;
		}

		/**
		 * FAX送付状、内訳明細書、請求書の検索条件をGETより作成する
		 * @return array
		 */
		function makeConditionsUtiwake() {
			$conditions = [];

			//納品先（伝票に登録された単体の納品先）
			if ($this->request->getQuery('delivery_dest') != '') {
				$conditions['delivery_dest'] = $this->request->getQuery('delivery_dest');
			}

			//作成日（いつから）
			if ($this->request->getQuery('upper_created') != '') {
				$conditions['created >='] = $this->request->getQuery('upper_created');
			}

			//作成日（いつまで）
			if ($this->request->getQuery('under_created') != '') {
				$conditions['created <='] = $this->request->getQuery('under_created');
			}

			return $conditions;
		}

		/**
		 * FAX送付状、内訳明細書、請求書の検索条件をGETより作成する
		 * @return array
		 */
		function makeConditions() {
			$conditions = [];

			//配達員
			if ($this->request->getQuery('deliveryman_name') != '') {
				$conditions['Vouchers.deliveryman_name'] = $this->request->getQuery('deliveryman_name');
			}

			//得意先
			if ($this->request->getQuery('customers_name') != '') {
				$conditions['Vouchers.customers_name'] = $this->request->getQuery('customers_name');
			}

			//納品先（伝票に登録された単体の納品先）
			if ($this->request->getQuery('delivery_dest') != '') {
				$conditions['Vouchers.delivery_dest'] = $this->request->getQuery('delivery_dest');
			}

			//備考
			if ($this->request->getQuery('appendix') != '') {
				$conditions['Vouchers.appendix LIKE'] = '%' . $this->request->getQuery('appendix') . '%';
			}

			//作成日（いつから）
			if ($this->request->getQuery('upper_created') != '') {
				$conditions['Vouchers.created >='] = $this->request->getQuery('upper_created');
			}

			//作成日（いつまで）
			if ($this->request->getQuery('under_created') != '') {
				$conditions['Vouchers.created <='] = $this->request->getQuery('under_created');
			}

			//納品先（伝票に紐づけられた一つ一つの納品先）
			if ($this->request->getQuery('cargo_dest') && is_array($this->request->getQuery('cargo_dest'))) {
				$conditions['deliveries.destination IN'] = $this->request->getQuery('cargo_dest');
			}

			return $conditions;
		}

		/**
		 * Fax送付状、内訳明細書、請求書の発行画面で検索するときのメソッド
		 * @return \App\Model\Entity\Voucher[]|\Cake\Datasource\ResultSetInterface
		 */
		function searchReportExecExcludeDestination() {
			$this->paginate = [
					'limit' => 50
			];

			//ソートの内容を反映する
			$sort = ['Vouchers.created' => 'desc'];
			if ($this->request->getQuery('sort') && $this->request->getQuery('direction')) {
				$sort = ['Vouchers.' . $this->request->getQuery('sort') => $this->request->getQuery('direction')];
			}

			//検索条件のクリアが選択された場合は全件検索をする
			if ($this->request->getQuery('submit_btn') == 'clear') {
				$vouchers = $this->paginate($this->Vouchers->find('all', ['order' => $sort]));
			} else {
				$conditions = $this->makeConditionsExcludeDestination();

				$vouchers = $this->paginate(TableRegistry::get('Vouchers')->find('all')->join([
						'type' => 'LEFT',
						'table' => 'deliveries',
						'conditions' => 'deliveries.voucher_id = Vouchers.id'
				])->where($conditions)->order($sort));
			}

			return $vouchers;
		}

		/**
		 * FAX送付状、内訳明細書、請求書の検索条件をGETより作成する
		 * ただし、納品先は除く
		 * @return array
		 */
		function makeConditionsExcludeDestination() {
			$conditions = [];

			//配達員
			if ($this->request->getQuery('deliveryman_name') != '') {
				$conditions['Vouchers.deliveryman_name'] = $this->request->getQuery('deliveryman_name');
			}

			//得意先
			if ($this->request->getQuery('customers_name') != '') {
				$conditions['Vouchers.customers_name'] = $this->request->getQuery('customers_name');
			}

			//納品先（伝票に登録された単体の納品先）
			if ($this->request->getQuery('delivery_dest') != '') {
				$conditions['Vouchers.delivery_dest'] = $this->request->getQuery('delivery_dest');
			}

			//備考
			if ($this->request->getQuery('appendix') != '') {
				$conditions['Vouchers.appendix LIKE'] = '%' . $this->request->getQuery('appendix') . '%';
			}

			//作成日（いつから）
			if ($this->request->getQuery('upper_created') != '') {
				$conditions['Vouchers.created <='] = $this->request->getQuery('upper_created');
			}

			//作成日（いつまで）
			if ($this->request->getQuery('under_created') != '') {
				$conditions['Vouchers.created >='] = $this->request->getQuery('under_created');
			}

			return $conditions;
		}

		/**
		 * View method
		 *
		 * @param string|null $id Voucher id.
		 * @return \Cake\Http\Response|void
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function view($id = null) {
			$this->viewBuilder()->setLayout('editor_layout');
			$voucher = $this->Vouchers->get($id, [
					'contain' => ['Deliveries', 'Routes']
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
					$this->Flash->success(__('伝票を登録しました。'));

					return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('伝票の登録に失敗しました。'));
			}
			$this->set(compact('voucher'));
		}

		/**
		 * Add method
		 *
		 * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
		 */
		public function addPart() {
			$this->viewBuilder()->setLayout('editor_layout');
			$voucher = $this->Vouchers->newEntity();
			if ($this->request->is('post')) {
				$voucher = $this->Vouchers->patchEntity($voucher, $this->request->getData());
				if ($this->Vouchers->save($voucher)) {
					$this->Flash->success(__('伝票を登録しました。'));

					return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('伝票の登録に失敗しました。'));
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
					$this->Flash->success(__('伝票の情報を更新しました。'));

					return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('伝票の情報更新に失敗しました。'));
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
		public function updateRegularService($id = null) {
			$this->viewBuilder()->setLayout('editor_layout');
			$voucher = $this->Vouchers->get($id, [
					'contain' => []
			]);
			if ($this->request->is(['patch', 'post', 'put'])) {
				$voucher = $this->Vouchers->patchEntity($voucher, $this->request->getData());
				if ($this->deleteAllDeliveries($id) && $this->Vouchers->save($voucher)) {

					$this->Flash->success(__('伝票の情報を更新しました。'));

					return $this->redirect(['action' => 'view', $voucher->id]);
				}
				$this->Flash->error(__('伝票の情報更新に失敗しました。'));
			}
			$this->set(compact('voucher'));
		}

		//TODO 経路情報など子テーブル情報がコピーされない
		public function copy($id = null) {
			$this->viewBuilder()->setLayout('editor_layout');
			$voucher = TableRegistry::get('Vouchers')->find('All')->where(['id' => $id])->first()->toArray();
			$voucherCpy = $this->Vouchers->newEntity($voucher);

			if ($this->request->is('post')) {
				if ($this->Vouchers->save($voucherCpy)) {
					$this->Flash->success(__('伝票をコピーしました。'));
				} else {
					$this->Flash->error(__('伝票のコピーに失敗しました。'));
				}
			}
			return $this->redirect(['action' => 'index']);
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
				$this->Flash->success(__('伝票の情報を削除しました。'));
			} else {
				$this->Flash->error(__('伝票の情報を削除できませんでした。'));
			}

			return $this->redirect(['action' => 'index']);
		}

		/**
		 * 関連する納品積込をすべて削除する
		 *
		 * @param null $id
		 * @return bool
		 */
		private function deleteAllDeliveries($id = null) {
			$voucher = $this->Vouchers->get($id);
			$myDeliveryList = TableRegistry::get('Deliveries')->find('All')->where(['voucher_id' => $voucher->id]);
			$deleteResult = true;

			$connection = ConnectionManager::get('default');
			// トランザクション開始
			$connection->begin();
			try {

				foreach ($myDeliveryList as $myDelivery) {
					if (TableRegistry::get('Deliveries')->delete($myDelivery)) {
						$myRouteList = TableRegistry::get('Routes')->find('All')->where(['delivery_id' => $myDelivery->id]);
						foreach ($myRouteList as $myRoute) {
							if (!TableRegistry::get('Routes')->delete($myRoute)) {
								$deleteResult = false;
							}
						}
					} else {
						$deleteResult = false;
					}
				}

				if ($deleteResult) {
					$connection->commit();
					ModelUtil::updateVoucherPrice($id);
				} else {
					$connection->rollback();
				}

			} catch (\Exception $e) {
				$connection->rollback();
			}

			return $deleteResult;
		}

		/**
		 *
		 * @param null $id
		 * @return \Cake\Http\Response|null
		 */
		public function addAllDeliveriesFromRegularService($id = null) {
			$voucher = $this->Vouchers->get($id);
			if ($this->request->is(['patch', 'post', 'put'])) {

				//まずは定期便フォームの内容を上記で取得したレコードに設定する
				$voucher = $this->Vouchers->patchEntity($voucher, $this->request->getData());

				if ($voucher->is_regular) {

					//上記で設定された定期便コードをセットする
					$myRegularService = TableRegistry::get('RegularServices')->find('All')->where(['id' => $voucher->regular_service_id])->first();

					if ($this->Vouchers->save($voucher) && $myRegularService) {
						$myRegularDeliveries = TableRegistry::get('RegularDeliveries')->find('All')->where(['regular_service_id' => $myRegularService->id]);
						$this->deleteAllDeliveries($id);

						foreach ($myRegularDeliveries as $myDelivery) {
							$newDelivery = TableRegistry::get('Deliveries')->newEntity();
							$newDelivery->voucher_id = $voucher->id;
							$newDelivery->deliveries_or_cargo = $myDelivery->deliveries_or_cargo;
							$newDelivery->outward_or_return = $myDelivery->outward_or_return;
							$newDelivery->delivery_dest = $myDelivery->delivery_dest;
							$newDelivery->start_location = $myDelivery->start_location;
							$newDelivery->destination = $myDelivery->destination;
							$newDelivery->distance = $myDelivery->distance;
							$newDelivery->price = $myDelivery->price;
							$newDelivery->additional_price = $myDelivery->additional_price;
							$newDelivery->advances_paid = $myDelivery->advances_paid;
							$newDelivery->appendix = $myDelivery->appendix;
							$newDelivery->is_exception = 'なし';

							TableRegistry::get('Deliveries')->save($newDelivery);
						}
						$this->Flash->success(__('伝票の情報を更新しました。'));
						ModelUtil::updateDeliveryPrices($id);
						ModelUtil::updateVoucherPrice($id);
						return $this->redirect(['action' => 'view', $voucher->id]);
					}
				}
			}
			$this->set(compact('voucher'));
		}
	}
