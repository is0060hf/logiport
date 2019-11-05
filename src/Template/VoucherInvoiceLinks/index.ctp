<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\VoucherInvoiceLink[]|\Cake\Collection\CollectionInterface $voucherInvoiceLinks
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Voucher Invoice Link'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Vouchers'), ['controller' => 'Vouchers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Voucher'), ['controller' => 'Vouchers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Invoices'), ['controller' => 'Invoices', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Invoice'), ['controller' => 'Invoices', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="voucherInvoiceLinks index large-9 medium-8 columns content">
    <h3><?= __('Voucher Invoice Links') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('voucher_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('invoice_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($voucherInvoiceLinks as $voucherInvoiceLink): ?>
            <tr>
                <td><?= $this->Number->format($voucherInvoiceLink->id) ?></td>
                <td><?= $voucherInvoiceLink->has('voucher') ? $this->Html->link($voucherInvoiceLink->voucher->id, ['controller' => 'Vouchers', 'action' => 'view', $voucherInvoiceLink->voucher->id]) : '' ?></td>
                <td><?= $voucherInvoiceLink->has('invoice') ? $this->Html->link($voucherInvoiceLink->invoice->id, ['controller' => 'Invoices', 'action' => 'view', $voucherInvoiceLink->invoice->id]) : '' ?></td>
                <td><?= h($voucherInvoiceLink->created) ?></td>
                <td><?= h($voucherInvoiceLink->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $voucherInvoiceLink->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $voucherInvoiceLink->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $voucherInvoiceLink->id], ['confirm' => __('Are you sure you want to delete # {0}?', $voucherInvoiceLink->id)]) ?>
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
