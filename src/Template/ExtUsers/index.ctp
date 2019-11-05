<?php
	/**
	 * @var \App\View\AppView                                             $this
	 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
	 */
?>
<div class="users index large-9 medium-8 columns content">
	<h3><?= __('ユーザ一覧') ?></h3>
	<table cellpadding="0" cellspacing="0" class="table table-hover mb-0">
		<thead>
		<tr>
			<th scope="col"><?= $this->Paginator->sort('username', '氏名') ?></th>
			<th scope="col"><?= $this->Paginator->sort('mail_address', 'メールアドレス') ?></th>
			<th scope="col"><?= $this->Paginator->sort('user_role', '役割') ?></th>
			<th scope="col"><?= $this->Paginator->sort('created', '作成日') ?></th>
			<th scope="col"><?= $this->Paginator->sort('modified', '更新日') ?></th>
			<th scope="col" class="actions"><?= __('操作') ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($users as $user): ?>
			<tr>
				<td><?= h($user->username) ?></td>
				<td><?= h($user->mail_address) ?></td>
				<td><?= h($user->user_role) ?></td>
				<td><?= h($user->created) ?></td>
				<td><?= h($user->modified) ?></td>
				<td class="actions">
					<?= $this->Html->link(__('詳細'), ['action' => 'view', $user->id]) ?>
					<?= $this->Html->link(__('編集'), ['action' => 'edit', $user->id]) ?>
					<?= $this->Form->postLink(__('削除'), ['action' => 'delete', $user->id], ['confirm' => __('本当に削除してもよろしいでしょうか # {0}?', $user->id)]) ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<?= $this->element('pagenate'); ?>
</div>
