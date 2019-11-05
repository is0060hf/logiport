<?php
	/**
	 * @var \App\View\AppView          $this
	 * @var \App\Model\Entity\Delivery $delivery
	 */

	use Cake\ORM\TableRegistry;

	$voucher = TableRegistry::get('Vouchers')->find('All')->where(['id' => $delivery->voucher_id])->first();
?>
<div class="breadcrumb_div">
	<ol class="breadcrumb m-b-20">
		<li class="breadcrumb-item"><a
					href="<?php echo $this->Url->build(['controller' => 'Vouchers', 'action' => 'index']); ?>">Home</a>
		</li>
		<li class="breadcrumb-item"><a
					href="<?php echo $this->Url->build(['controller' => 'Vouchers', 'action' => 'index']); ?>">伝票一覧</a>
		</li>
		<li class="breadcrumb-item"><a
					href="<?php echo $this->Url->build(['controller' => 'Vouchers', 'action' => 'view', $delivery->voucher_id]); ?>">伝票詳細</a>
		</li>
		<li class="breadcrumb-item active">配達情報詳細</li>
	</ol>
</div>
<div class="deliveries view large-9 medium-8 columns content">
	<div class="row mb-4">
		<div class="col-sm-12">
			<div class="pull-left">
				<legend>配達情報詳細</legend>
			</div>
			<div class="text-center mt-4">
				<a href="<?= $this->Url->build(['controller' => 'Deliveries', 'action' => 'edit', $delivery->id]); ?>"
				   class="btn btn-success mr-3">
					<i class="fe-edit"></i>
					<span>編集する</span>
				</a>
				<a href="<?= $this->Url->build(['controller' => 'Vouchers', 'action' => 'view', $voucher->id]); ?>"
				   class="btn btn-info">
					<i class="fe-skip-back"></i>
					<span>伝票情報に戻る</span>
				</a>
			</div>
		</div>
	</div>

	<div class="row mb-4">
		<div class="col-12">
			<table class="table">
				<tr>
					<th scope="row"><?= __('納品/積込') ?></th>
					<td><?= h($delivery->deliveries_or_cargo) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('往路/復路') ?></th>
					<td><?= h($delivery->outward_or_return) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('積込先') ?></th>
					<td><?= h($delivery->delivery_dest) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('出発地') ?></th>
					<td><?= h($delivery->start_location) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('行先') ?></th>
					<td><?= h($delivery->destination) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('距離') ?></th>
					<td><?= $this->Number->format($delivery->distance) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('料金') ?></th>
					<td><?= $this->Number->format($delivery->price) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('追加料金') ?></th>
					<td><?= $this->Number->format($delivery->additional_price) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('立替金') ?></th>
					<td><?= $this->Number->format($delivery->advances_paid) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('特殊な事情') ?></th>
					<td><?= h($delivery->is_exception) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('備考') ?></th>
					<td><?= h($delivery->appendix) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('受領書有無') ?></th>
					<td><?= h($delivery->receipt_flg) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('持ち帰りの有無') ?></th>
					<td><?= h($delivery->has_take_out) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('到着時刻') ?></th>
					<td><?= h($delivery->arrival_time) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('完了時刻') ?></th>
					<td><?= h($delivery->complete_time) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('設定温度') ?></th>
					<td><?= h($delivery->temperature) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('受領サイン有無') ?></th>
					<td><?= h($delivery->receipt_sign) ?></td>
				</tr>
			</table>
		</div>
	</div>

	<div class="row mb-4">
		<div class="col-sm-12">
			<div class="text-center mt-4">
				<a href="<?= $this->Url->build(['controller' => 'Deliveries', 'action' => 'edit', $delivery->id]); ?>"
				   class="btn btn-success mr-3">
					<i class="fe-edit"></i>
					<span>編集する</span>
				</a>
				<a href="<?= $this->Url->build(['controller' => 'Vouchers', 'action' => 'view', $voucher->id]); ?>"
				   class="btn btn-info">
					<i class="fe-skip-back"></i>
					<span>伝票情報に戻る</span>
				</a>
			</div>
		</div>
	</div>
</div>
