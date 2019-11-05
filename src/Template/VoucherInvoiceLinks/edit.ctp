<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\VoucherInvoiceLink $voucherInvoiceLink
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $voucherInvoiceLink->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $voucherInvoiceLink->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Voucher Invoice Links'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Vouchers'), ['controller' => 'Vouchers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Voucher'), ['controller' => 'Vouchers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Invoices'), ['controller' => 'Invoices', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Invoice'), ['controller' => 'Invoices', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="voucherInvoiceLinks form large-9 medium-8 columns content">
    <?= $this->Form->create($voucherInvoiceLink) ?>
    <fieldset>
        <legend><?= __('Edit Voucher Invoice Link') ?></legend>
        <?php
            echo $this->Form->control('voucher_id', ['options' => $vouchers]);
            echo $this->Form->control('invoice_id', ['options' => $invoices]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
