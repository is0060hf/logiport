<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Delivery[]|\Cake\Collection\CollectionInterface $deliveries
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Delivery'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Vouchers'), ['controller' => 'Vouchers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Voucher'), ['controller' => 'Vouchers', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="deliveries index large-9 medium-8 columns content">
    <h3><?= __('Deliveries') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('voucher_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('deliveries_or_cargo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('destination') ?></th>
                <th scope="col"><?= $this->Paginator->sort('distance') ?></th>
                <th scope="col"><?= $this->Paginator->sort('receipt_flg') ?></th>
                <th scope="col"><?= $this->Paginator->sort('arrival_time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('complete_time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('temperature') ?></th>
                <th scope="col"><?= $this->Paginator->sort('receipt_sign') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($deliveries as $delivery): ?>
            <tr>
                <td><?= $this->Number->format($delivery->id) ?></td>
                <td><?= $this->Number->format($delivery->voucher_id) ?></td>
                <td><?= h($delivery->deliveries_or_cargo) ?></td>
                <td><?= h($delivery->destination) ?></td>
                <td><?= $this->Number->format($delivery->distance) ?></td>
                <td><?= h($delivery->receipt_flg) ?></td>
                <td><?= h($delivery->arrival_time) ?></td>
                <td><?= h($delivery->complete_time) ?></td>
                <td><?= h($delivery->temperature) ?></td>
                <td><?= h($delivery->receipt_sign) ?></td>
                <td><?= h($delivery->created) ?></td>
                <td><?= h($delivery->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $delivery->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $delivery->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $delivery->id], ['confirm' => __('Are you sure you want to delete # {0}?', $delivery->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
