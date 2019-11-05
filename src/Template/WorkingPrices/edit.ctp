<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\WorkingPrice $workingPrice
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $workingPrice->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $workingPrice->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Working Prices'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Price Tables'), ['controller' => 'PriceTables', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Price Table'), ['controller' => 'PriceTables', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="workingPrices form large-9 medium-8 columns content">
    <?= $this->Form->create($workingPrice) ?>
    <fieldset>
        <legend><?= __('Edit Working Price') ?></legend>
        <?php
            echo $this->Form->control('price_table_id', ['options' => $priceTables]);
            echo $this->Form->control('working');
            echo $this->Form->control('price');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
