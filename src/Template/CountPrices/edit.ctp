<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CountPrice $countPrice
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $countPrice->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $countPrice->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Count Prices'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Price Tables'), ['controller' => 'PriceTables', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Price Table'), ['controller' => 'PriceTables', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="countPrices form large-9 medium-8 columns content">
    <?= $this->Form->create($countPrice) ?>
    <fieldset>
        <legend><?= __('Edit Count Price') ?></legend>
        <?php
            echo $this->Form->control('price_table_id', ['options' => $priceTables]);
            echo $this->Form->control('counts');
            echo $this->Form->control('price');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
