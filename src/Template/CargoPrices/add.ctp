<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CargoPrice $cargoPrice
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Cargo Prices'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Price Tables'), ['controller' => 'PriceTables', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Price Table'), ['controller' => 'PriceTables', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="cargoPrices form large-9 medium-8 columns content">
    <?= $this->Form->create($cargoPrice) ?>
    <fieldset>
        <legend><?= __('Add Cargo Price') ?></legend>
        <?php
            echo $this->Form->control('price_table_id', ['options' => $priceTables]);
            echo $this->Form->control('cargo');
            echo $this->Form->control('price');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
