<?php
	/**
	 * @var \App\View\AppView                  $this
	 * @var \App\Model\Entity\Customer         $customer
	 * @var \App\Model\Entity\RegularService[] $regular_services
	 */

	use Cake\ORM\TableRegistry;

	$pTable = TableRegistry::get('PriceTables')->find()->where(['customer_id' => $customer->id, 'mode' => ''])->first();
	if ($pTable) {
		$distancePriceTable = TableRegistry::get('DistancePrices')->find()->where(['price_table_id' => $pTable->id])->orderAsc('distance');
	}

	$driverPriceTable = TableRegistry::get('PriceTables')->find()->where(['customer_id' => $customer->id, 'mode' => 'driver'])->first();
	if ($driverPriceTable) {
		$driverDistancePriceTable = TableRegistry::get('DistancePrices')->find()->where(['price_table_id' => $driverPriceTable->id])->orderAsc('distance');
	}
?>
<div class="breadcrumb_div">
	<ol class="breadcrumb m-b-20">
		<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller' => 'Vouchers', 'action' => 'index']); ?>">Home</a></li>
		<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller' => 'Customers', 'action' => 'index']); ?>">顧客一覧</a></li>
		<li class="breadcrumb-item active">顧客情報</li>
	</ol>
</div>

<div class="customers view large-9 medium-8 columns content">
	<div class="row mb-4">
		<div class="col-sm-6">
			<div class="pull-left">
				<legend>顧客情報</legend>
				<p class="text-muted">料金表の設定を行ってください。</p>
			</div>
			<div class="text-left mt-4">
				<a href="<?= $this->Url->build(['controller' => 'Customers', 'action' => 'edit', $customer->id]); ?>" class="btn btn-success mr-3">
					<i class="fe-edit-2"></i>
					<span>編集する</span>
				</a>

				<a href="<?= $this->Url->build(['controller' => 'Customers', 'action' => 'index']); ?>" class="btn btn-info">
					<i class="fe-skip-back"></i>
					<span>一覧に戻る</span>
				</a>
			</div>
		</div>

		<div class="col-sm-4 offset-sm-2">
			<div class="mt-3 float-right">
				<p class="m-b-10"><strong>作成日 : </strong> <span class="float-right"> <?= h($customer->created) ?></span></p>
				<?php if ($pTable) { ?>
					<p class="m-b-10"><strong>料金表 : </strong> <span class="float-right"><span class="badge badge-info">作成済</span></span></p>
				<?php } else { ?>
					<p class="m-b-10"><strong>料金表 : </strong> <span class="float-right"><span class="badge badge-danger">未作成</span></span></p>
				<?php } ?>
				<p class="m-b-10"><strong>更新日 : </strong> <span class="float-right"> <?= h($customer->modified) ?></span></p>
			</div>
		</div>
	</div>

	<table class="table mb-4">
		<tr>
			<th scope="row"><?= __('顧客名') ?></th>
			<td><?= h($customer->customers_name) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('連絡先') ?></th>
			<td><?= h($customer->customers_phone) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('積込先') ?></th>
			<td><?= h($customer->delivery_dest) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('作成日') ?></th>
			<td><?= h($customer->created) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('更新日') ?></th>
			<td><?= h($customer->modified) ?></td>
		</tr>
	</table>

	<!--料金表欄-->
	<div class="related">
		<div class="row mb-4">
			<div class="col-sm-6">
				<div class="pull-left">
					<legend>料金表</legend>
					<p class="text-muted">ここで登録された料金表を基に料金を自動計算します。</p>
				</div>
			</div>
		</div>

		<div class="row mt-4">
			<div class="col-12">
				<?php if ($pTable) { ?>
					<a href="<?= $this->Url->build(['controller' => 'PriceTables', 'action' => 'edit', $pTable->id]); ?>" class="btn btn-success mr-3">
						<i class="fe-edit-2"></i>
						<span>料金表を編集する</span>
					</a>
					<a href="<?= $this->Url->build(['controller' => 'DistancePrices', 'action' => 'add']); ?>?mode=&customer_id=<?= $customer->id ?>" class="btn btn-outline-success mr-3">
						<i class="fe-edit"></i>
						<span>料金区分登録</span>
					</a>
				<?php } else { ?>
					<a href="<?= $this->Url->build(['controller' => 'PriceTables', 'action' => 'add']); ?>?mode=&customer_id=<?= $customer->id ?>" class="btn btn-success mr-3">
						<i class="fe-edit"></i>
						<span>料金表を新規作成する</span>
					</a>
				<?php } ?>
			</div>
		</div>

		<div class="row mt-3">
			<div class="col-12">
				<?php if (!empty($pTable)): ?>
					<table cellpadding="0" cellspacing="0" class="table mb-4">
						<tr>
							<th scope="col"><?= __('基本料金（円）') ?></th>
							<th scope="col"><?= __('帰り荷割増') ?></th>
							<th scope="col"><?= __('キャンセル料金') ?></th>
						</tr>
						<tr>
							<td><?= h($pTable->basic_price) ?>円</td>
							<td>
								<?php if (isset($pTable->return_additional_fee)): ?>
									<?= h($pTable->return_additional_fee) ?>円
								<?php else: ?>
									<?= h($pTable->return_magnification) ?>％
								<?php endif; ?>
							</td>
							<td><?= h($pTable->cancel_fee) ?></td>
						</tr>

						<?php if (!empty($distancePriceTable)): ?>
							<tr>
								<th scope="col"><?= __('距離（km）') ?></th>
								<th scope="col"><?= __('値段（円）') ?></th>
								<th scope="col"><?= __('操作') ?></th>
							</tr>
							<?php foreach ($distancePriceTable as $tItem): ?>
								<tr>
									<td><?= h($tItem->distance) ?></td>
									<td><?= h($tItem->price) ?></td>
									<td>
										<?= $this->Html->link(__('編集'), ['controller' => 'DistancePrices', 'action' => 'edit', $tItem->id]) ?>
										<?= $this->Form->postLink(__('削除'), ['controller' => 'DistancePrices', 'action' => 'delete', $tItem->id], ['confirm' => __('本当に削除してもよろしいでしょうか # {0}?', $tItem->id)]) ?>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
					</table>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<!--ドライバー用料金表欄-->
	<div class="related">
		<div class="row mb-4">
			<div class="col-sm-6">
				<div class="pull-left">
					<legend>ドライバー用料金表</legend>
					<p class="text-muted">ここで登録された料金表を基にドライバーへの支払い料金を自動計算します。</p>
				</div>
			</div>
		</div>

		<div class="row mt-4">
			<div class="col-12">
				<?php if ($driverPriceTable) { ?>
					<a href="<?= $this->Url->build(['controller' => 'PriceTables', 'action' => 'edit', $driverPriceTable->id]); ?>" class="btn btn-success mr-3">
						<i class="fe-edit-2"></i>
						<span>ドライバー用料金表を編集する</span>
					</a>
					<a href="<?= $this->Url->build(['controller' => 'DistancePrices', 'action' => 'add']); ?>?mode=driver&customer_id=<?= $customer->id ?>" class="btn btn-outline-success mr-3">
						<i class="fe-edit"></i>
						<span>料金区分登録</span>
					</a>

					<a href="<?= $this->Url->build(['controller' => 'DistancePrices', 'action' => 'copyFromOrdinalScale', $customer->id]); ?>" class="btn btn-outline-success mr-3">
						<i class="fe-copy"></i>
						<span>顧客用料金区分からコピー</span>
					</a>
				<?php } else { ?>
					<a href="<?= $this->Url->build(['controller' => 'PriceTables', 'action' => 'addDriverPriceTable']); ?>?mode=driver&customer_id=<?= $customer->id ?>" class="btn btn-success mr-3">
						<i class="fe-edit"></i>
						<span>ドライバー用料金表を新規作成する</span>
					</a>
				<?php } ?>
			</div>
		</div>

		<div class="row mt-3">
			<div class="col-12">
				<?php if ($driverPriceTable): ?>
					<table cellpadding="0" cellspacing="0" class="table mb-4">
						<tr>
							<th scope="col"><?= __('基本料金（円）') ?></th>
							<th scope="col"><?= __('帰り荷割増') ?></th>
							<th scope="col"><?= __('キャンセル料金') ?></th>
						</tr>
						<tr>
							<td><?= h($driverPriceTable->basic_price) ?>円</td>
							<td>
								<?php if (isset($driverPriceTable->return_additional_fee)): ?>
									<?= h($driverPriceTable->return_additional_fee) ?>円
								<?php else: ?>
									<?= h($driverPriceTable->return_magnification) ?>％
								<?php endif; ?>
							</td>
							<td><?= h($driverPriceTable->cancel_fee) ?></td>
						</tr>

						<?php if (!empty($driverDistancePriceTable)): ?>
							<tr>
								<th scope="col"><?= __('距離（km）') ?></th>
								<th scope="col"><?= __('値段（円）') ?></th>
								<th scope="col"><?= __('操作') ?></th>
							</tr>
							<?php foreach ($driverDistancePriceTable as $tItem): ?>
								<tr>
									<td><?= h($tItem->distance) ?></td>
									<td><?= h($tItem->price) ?></td>
									<td>
										<?= $this->Html->link(__('編集'), ['controller' => 'DistancePrices', 'action' => 'edit', $tItem->id]) ?>
										<?= $this->Form->postLink(__('削除'), ['controller' => 'DistancePrices', 'action' => 'delete', $tItem->id], ['confirm' => __('本当に削除してもよろしいでしょうか # {0}?', $tItem->id)]) ?>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
					</table>
				<?php endif; ?>
			</div>
		</div>
	</div>


	<!--定期便欄-->
	<div class="related">
		<div class="row mb-4">
			<div class="col-sm-6">
				<div class="pull-left">
					<legend>定期便</legend>
					<p class="text-muted">ここで登録された定期便は伝票画面にて設定頂けます。</p>
				</div>
			</div>
		</div>

		<div class="row mt-4">
			<div class="col-12">
				<a href="<?= $this->Url->build(['controller' => 'RegularServices', 'action' => 'add']); ?>?id=<?= $customer->id ?>" class="btn btn-success mr-3">
					<i class="fe-edit"></i>
					<span>定期便を新規作成する</span>
				</a>
			</div>
		</div>

		<div class="row mt-3">
			<div class="col-12">
				<?php if (!empty($regular_services)): ?>
					<table cellpadding="0" cellspacing="0" class="table mb-4">
						<tr>
							<th scope="col"><?= __('ID') ?></th>
							<th scope="col"><?= __('定期便名') ?></th>
							<th scope="col"><?= __('経路') ?></th>
							<th scope="col"><?= __('操作') ?></th>
						</tr>
						<?php foreach ($regular_services as $regularService): ?>
							<tr>
								<td><?= h($regularService->id) ?></td>
								<td><?= h($regularService->regular_service_name) ?></td>
								<td>
									<?php
										$rdList = TableRegistry::get('RegularDeliveries')->find('All')->where(['regular_service_id' => $regularService->id]);
										foreach ($rdList as $regularDelivery):
											?>
											<?= h($regularDelivery->start_location) ?>　→　<?= h($regularDelivery->destination) ?>　<?= $this->Html->link(__('[編集]'), ['controller' => 'RegularDeliveries', 'action' => 'edit', $regularDelivery->id]) ?><?= $this->Form->postLink(__('[削除]'), ['controller' => 'RegularDeliveries', 'action' => 'delete', $regularDelivery->id], ['confirm' => __('本当に削除してもよろしいでしょうか # {0}?', $regularDelivery->id)]) ?><br>
										<?php endforeach; ?>
								</td>
								<td>
									<?= $this->Html->link(__('編集'), ['controller' => 'RegularServices', 'action' => 'edit', $regularService->id]) ?>
									<?= $this->Form->postLink(__('削除'), ['controller' => 'RegularServices', 'action' => 'delete', $regularService->id], ['confirm' => __('本当に削除してもよろしいでしょうか # {0}?', $regularService->id)]) ?>
									<?= $this->Html->link(__('経路追加'), ['controller' => 'RegularDeliveries', 'action' => 'add', $regularService->id]) ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</table>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
