<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Invoice[]|\Cake\Collection\CollectionInterface $invoices
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Invoice'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Voucher Invoice Links'), ['controller' => 'VoucherInvoiceLinks', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Voucher Invoice Link'), ['controller' => 'VoucherInvoiceLinks', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="invoices index large-9 medium-8 columns content">
    <h3><?= __('Invoices') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('bank_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sum_fare') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sum_additional_fee') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sum_advances_paid') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sum_tax') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sum_price') ?></th>
                <th scope="col"><?= $this->Paginator->sort('invoice_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('invoice_atena') ?></th>
                <th scope="col"><?= $this->Paginator->sort('invoice_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('moto_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('moto_zip') ?></th>
                <th scope="col"><?= $this->Paginator->sort('moto_address') ?></th>
                <th scope="col"><?= $this->Paginator->sort('moto_tel') ?></th>
                <th scope="col"><?= $this->Paginator->sort('moto_fax') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($invoices as $invoice): ?>
            <tr>
                <td><?= $this->Number->format($invoice->id) ?></td>
                <td><?= $this->Number->format($invoice->bank_id) ?></td>
                <td><?= $this->Number->format($invoice->sum_fare) ?></td>
                <td><?= $this->Number->format($invoice->sum_additional_fee) ?></td>
                <td><?= $this->Number->format($invoice->sum_advances_paid) ?></td>
                <td><?= $this->Number->format($invoice->sum_tax) ?></td>
                <td><?= $this->Number->format($invoice->sum_price) ?></td>
                <td><?= h($invoice->invoice_name) ?></td>
                <td><?= h($invoice->invoice_atena) ?></td>
                <td><?= h($invoice->invoice_date) ?></td>
                <td><?= h($invoice->moto_name) ?></td>
                <td><?= h($invoice->moto_zip) ?></td>
                <td><?= h($invoice->moto_address) ?></td>
                <td><?= h($invoice->moto_tel) ?></td>
                <td><?= h($invoice->moto_fax) ?></td>
                <td><?= h($invoice->created) ?></td>
                <td><?= h($invoice->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $invoice->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $invoice->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $invoice->id], ['confirm' => __('Are you sure you want to delete # {0}?', $invoice->id)]) ?>
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
