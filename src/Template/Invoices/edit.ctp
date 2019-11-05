<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Invoice $invoice
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $invoice->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $invoice->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Invoices'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Voucher Invoice Links'), ['controller' => 'VoucherInvoiceLinks', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Voucher Invoice Link'), ['controller' => 'VoucherInvoiceLinks', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="invoices form large-9 medium-8 columns content">
    <?= $this->Form->create($invoice) ?>
    <fieldset>
        <legend><?= __('Edit Invoice') ?></legend>
        <?php
            echo $this->Form->control('bank_id');
            echo $this->Form->control('sum_fare');
            echo $this->Form->control('sum_additional_fee');
            echo $this->Form->control('sum_advances_paid');
            echo $this->Form->control('sum_tax');
            echo $this->Form->control('sum_price');
            echo $this->Form->control('invoice_name');
            echo $this->Form->control('invoice_atena');
            echo $this->Form->control('invoice_date', ['empty' => true]);
            echo $this->Form->control('moto_name');
            echo $this->Form->control('moto_zip');
            echo $this->Form->control('moto_address');
            echo $this->Form->control('moto_tel');
            echo $this->Form->control('moto_fax');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
