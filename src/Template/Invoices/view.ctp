<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Invoice $invoice
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Invoice'), ['action' => 'edit', $invoice->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Invoice'), ['action' => 'delete', $invoice->id], ['confirm' => __('Are you sure you want to delete # {0}?', $invoice->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Invoices'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Invoice'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Voucher Invoice Links'), ['controller' => 'VoucherInvoiceLinks', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Voucher Invoice Link'), ['controller' => 'VoucherInvoiceLinks', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="invoices view large-9 medium-8 columns content">
    <h3><?= h($invoice->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Invoice Name') ?></th>
            <td><?= h($invoice->invoice_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Invoice Atena') ?></th>
            <td><?= h($invoice->invoice_atena) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Moto Name') ?></th>
            <td><?= h($invoice->moto_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Moto Zip') ?></th>
            <td><?= h($invoice->moto_zip) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Moto Address') ?></th>
            <td><?= h($invoice->moto_address) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Moto Tel') ?></th>
            <td><?= h($invoice->moto_tel) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Moto Fax') ?></th>
            <td><?= h($invoice->moto_fax) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($invoice->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Bank Id') ?></th>
            <td><?= $this->Number->format($invoice->bank_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sum Fare') ?></th>
            <td><?= $this->Number->format($invoice->sum_fare) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sum Additional Fee') ?></th>
            <td><?= $this->Number->format($invoice->sum_additional_fee) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sum Advances Paid') ?></th>
            <td><?= $this->Number->format($invoice->sum_advances_paid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sum Tax') ?></th>
            <td><?= $this->Number->format($invoice->sum_tax) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sum Price') ?></th>
            <td><?= $this->Number->format($invoice->sum_price) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Invoice Date') ?></th>
            <td><?= h($invoice->invoice_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($invoice->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($invoice->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Voucher Invoice Links') ?></h4>
        <?php if (!empty($invoice->voucher_invoice_links)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Voucher Id') ?></th>
                <th scope="col"><?= __('Invoice Id') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($invoice->voucher_invoice_links as $voucherInvoiceLinks): ?>
            <tr>
                <td><?= h($voucherInvoiceLinks->id) ?></td>
                <td><?= h($voucherInvoiceLinks->voucher_id) ?></td>
                <td><?= h($voucherInvoiceLinks->invoice_id) ?></td>
                <td><?= h($voucherInvoiceLinks->created) ?></td>
                <td><?= h($voucherInvoiceLinks->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'VoucherInvoiceLinks', 'action' => 'view', $voucherInvoiceLinks->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'VoucherInvoiceLinks', 'action' => 'edit', $voucherInvoiceLinks->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'VoucherInvoiceLinks', 'action' => 'delete', $voucherInvoiceLinks->id], ['confirm' => __('Are you sure you want to delete # {0}?', $voucherInvoiceLinks->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
