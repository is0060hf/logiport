<?php
	/**
	 * @var \App\View\AppView                                                 $this
	 * @var \App\Model\Entity\Customer[]|\Cake\Collection\CollectionInterface $customers
	 */
?>
<div class="row">
	<div class="col-6 breadcrumb_div">
		<ol class="breadcrumb m-b-20">
			<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller'=>'Vouchers', 'action'=>'index']); ?>">Home</a></li>
			<li class="breadcrumb-item active">顧客一覧</li>
		</ol>
	</div>
	<div class="col-2 offset-4 text-right">
		<a href="<?= $this->Url->build(['controller'=>'Customers','action'=>'add']); ?>" class="btn btn-success mt-2">
			<i class="fe-git-pull-request"></i>
			<span>新規登録する</span>
		</a>
	</div>
</div>

<div class="customers index large-9 medium-8 columns content">
	<legend><?= __('顧客一覧') ?></legend>
	<table cellpadding="0" cellspacing="0" class="table table-hover mb-0">
		<thead>
		<tr>
			<th scope="col"><?= $this->Paginator->sort('顧客名') ?></th>
			<th scope="col"><?= $this->Paginator->sort('連絡先') ?></th>
			<th scope="col"><?= $this->Paginator->sort('積込先') ?></th>
			<th scope="col"><?= $this->Paginator->sort('作成日') ?></th>
			<th scope="col"><?= $this->Paginator->sort('更新日') ?></th>
			<th scope="col" class="actions"><?= __('操作') ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($customers as $customer): ?>
			<tr>
				<td class="align-middle"><a href="<?php echo $this->Url->build(['controller'=>'Customers', 'action' => 'view', $customer->id]); ?>" class="btn btn-info"><?= h($customer->customers_name) ?></a></td>
				<td class="align-middle"><?= h($customer->customers_phone) ?></td>
				<td class="align-middle"><?= h($customer->delivery_dest) ?></td>
				<td class="align-middle"><?= h($customer->created) ?></td>
				<td class="align-middle"><?= h($customer->modified) ?></td>
				<td class="actions align-middle">
					<?= $this->Html->link(__('編集'), ['action' => 'edit', $customer->id]) ?>
					<?= $this->Form->postLink(__('削除'), ['action' => 'delete', $customer->id], ['confirm' => __('本当に削除してもよろしいでしょうか # {0}?', $customer->id)]) ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<?= $this->element('pagenate'); ?>
</div>
