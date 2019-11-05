<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Delivery $delivery
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Deliveries'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Vouchers'), ['controller' => 'Vouchers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Voucher'), ['controller' => 'Vouchers', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="deliveries form large-9 medium-8 columns content">
    <?= $this->Form->create($delivery) ?>
    <fieldset>
        <legend><?= __('Add Delivery') ?></legend>
        <?php
            echo $this->Form->control('voucher_id');
            echo $this->Form->control('deliveries_or_cargo');
            echo $this->Form->control('destination');
            echo $this->Form->control('distance');
            echo $this->Form->control('receipt_flg');
            echo $this->Form->control('arrival_time');
            echo $this->Form->control('complete_time');
            echo $this->Form->control('temperature');
            echo $this->Form->control('receipt_sign');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
