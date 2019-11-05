<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\VoucherInvoiceLink $voucherInvoiceLink
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Voucher Invoice Link'), ['action' => 'edit', $voucherInvoiceLink->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Voucher Invoice Link'), ['action' => 'delete', $voucherInvoiceLink->id], ['confirm' => __('Are you sure you want to delete # {0}?', $voucherInvoiceLink->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Voucher Invoice Links'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Voucher Invoice Link'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Vouchers'), ['controller' => 'Vouchers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Voucher'), ['controller' => 'Vouchers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Invoices'), ['controller' => 'Invoices', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Invoice'), ['controller' => 'Invoices', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="voucherInvoiceLinks view large-9 medium-8 columns content">
    <h3><?= h($voucherInvoiceLink->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Voucher') ?></th>
            <td><?= $voucherInvoiceLink->has('voucher') ? $this->Html->link($voucherInvoiceLink->voucher->id, ['controller' => 'Vouchers', 'action' => 'view', $voucherInvoiceLink->voucher->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Invoice') ?></th>
            <td><?= $voucherInvoiceLink->has('invoice') ? $this->Html->link($voucherInvoiceLink->invoice->id, ['controller' => 'Invoices', 'action' => 'view', $voucherInvoiceLink->invoice->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($voucherInvoiceLink->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($voucherInvoiceLink->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($voucherInvoiceLink->modified) ?></td>
        </tr>
    </table>
</div>
