<?php
	/**
	 * @var \App\View\AppView                                                $this
	 * @var \App\Model\Entity\Voucher[]|\Cake\Collection\CollectionInterface $vouchers
	 */
?>
<div class="vouchers index large-9 medium-8 columns content">
	<h3><?= __('伝票一覧') ?></h3>
	<table cellpadding="0" cellspacing="0" class="table table-hover mb-0">
		<thead>
		<tr>
			<th scope="col"><?= $this->Paginator->sort('id', 'ID') ?></th>
			<th scope="col"><?= $this->Paginator->sort('deliveryman_name', '配達員') ?></th>
			<th scope="col"><?= $this->Paginator->sort('customers_name', '得意先') ?></th>
			<th scope="col"><?= $this->Paginator->sort('delivery_dest', '搬入先') ?></th>
			<th scope="col"><?= $this->Paginator->sort('arrival_time', '入庫時刻') ?></th>
			<th scope="col"><?= $this->Paginator->sort('departure_time', '出庫時刻') ?></th>
			<th scope="col"><?= $this->Paginator->sort('appendix', '備考') ?></th>
			<th scope="col"><?= $this->Paginator->sort('created', '作成日') ?></th>
			<th scope="col"><?= $this->Paginator->sort('modified', '更新日') ?></th>
			<th scope="col" class="actions"><?= __('操作') ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($vouchers as $voucher): ?>
			<tr>
				<td><?= $this->Number->format($voucher->id) ?></td>
				<td><?= h($voucher->deliveryman_name) ?></td>
				<td><?= h($voucher->customers_name) ?></td>
				<td><?= h($voucher->delivery_dest) ?></td>
				<td><?= h($voucher->arrival_time) ?></td>
				<td><?= h($voucher->departure_time) ?></td>
				<td><?= h($voucher->appendix) ?></td>
				<td><?= h($voucher->created) ?></td>
				<td><?= h($voucher->modified) ?></td>
				<td class="actions">
					<?= $this->Html->link(__('詳細'), ['action' => 'view', $voucher->id]) ?>
					<?= $this->Html->link(__('編集'), ['action' => 'edit', $voucher->id]) ?>
					<?= $this->Form->postLink(__('削除'), ['action' => 'delete', $voucher->id], ['confirm' => __('本当に削除してもよろしいでしょうか # {0}?', $voucher->id)]) ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<?= $this->element('pagenate'); ?>
</div>
